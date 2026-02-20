<?php

namespace App\Services;

use App\Models\WorkOrder;
use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use DOMDocument;

class EfakturaService
{
    /**
     * Maximum retry attempts for API calls.
     */
    protected int $maxRetries = 3;

    /**
     * UBL 2.1 namespaces.
     */
    protected const NS_INVOICE = 'urn:oasis:names:specification:ubl:schema:xsd:Invoice-2';
    protected const NS_CAC = 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2';
    protected const NS_CBC = 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2';
    protected const NS_CEF = 'urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2';

    /**
     * Get OAuth access token, cached until expiry.
     */
    public function getAccessToken(): ?string
    {
        return Cache::remember('efaktura_access_token', 3500, function () {
            $tokenUrl = config('efaktura.token_url');

            if (empty($tokenUrl)) {
                Log::warning('Efaktura: token_url is not configured.');
                return null;
            }

            $response = Http::asForm()->post($tokenUrl, [
                'client_id' => config('efaktura.client_id'),
                'client_secret' => config('efaktura.client_secret'),
                'grant_type' => 'client_credentials',
            ]);

            if ($response->failed()) {
                Log::error('Efaktura: Failed to obtain access token.', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                return null;
            }

            $data = $response->json();

            if (isset($data['expires_in'])) {
                Cache::put('efaktura_access_token', $data['access_token'], $data['expires_in'] - 60);
            }

            return $data['access_token'] ?? null;
        });
    }

    /**
     * Force refresh the access token (e.g., after a 401).
     */
    public function refreshAccessToken(): ?string
    {
        Cache::forget('efaktura_access_token');
        return $this->getAccessToken();
    }

    /**
     * Validate that a work order / invoice is ready for eFaktura submission.
     *
     * @throws \Exception
     */
    public function validateForSubmission(WorkOrder $workOrder): void
    {
        $errors = [];

        if (!$workOrder->has_invoice) {
            $errors[] = 'Faktura nije generisana za ovaj radni nalog.';
        }

        if (empty($workOrder->invoice_number)) {
            $errors[] = 'Broj fakture nije definisan.';
        }

        if ($workOrder->invoice_type === 'pravno_lice' && empty($workOrder->invoice_pib)) {
            $errors[] = 'PIB kupca je obavezan za pravna lica.';
        }

        if (empty($workOrder->invoice_company_name)) {
            $errors[] = 'Naziv kupca/firme nije definisan.';
        }

        $grandTotal = $this->calculateGrandTotal($workOrder);
        if ($grandTotal <= 0) {
            $errors[] = 'Ukupan iznos fakture mora biti veći od 0.';
        }

        if (!empty($errors)) {
            throw new \Exception(implode(' ', $errors));
        }
    }

    /**
     * Send an invoice to the Serbian eFaktura system as UBL 2.1 XML.
     */
    public function sendInvoice(WorkOrder $workOrder): array
    {
        // Validate before sending
        $this->validateForSubmission($workOrder);

        $workOrder->load(['sections.items.product', 'worker']);

        $xml = $this->buildUblXml($workOrder);

        Log::info('Efaktura: Sending UBL XML invoice', [
            'work_order_id' => $workOrder->id,
            'invoice_number' => $workOrder->invoice_number,
            'xml_length' => strlen($xml),
        ]);

        $response = $this->sendXmlWithRetry($xml);

        if ($response->successful()) {
            $responseData = $response->json();

            $workOrder->update([
                'efaktura_status' => 'sent',
                'efaktura_response' => $response->body(),
                'efaktura_sent_at' => now(),
            ]);

            Log::info('Efaktura sent successfully', [
                'work_order_id' => $workOrder->id,
                'invoice_number' => $workOrder->invoice_number,
                'response_status' => $response->status(),
                'sales_invoice_id' => $responseData['SalesInvoiceId'] ?? null,
            ]);
        } else {
            Log::error('Efaktura error', [
                'work_order_id' => $workOrder->id,
                'invoice_number' => $workOrder->invoice_number,
                'response_status' => $response->status(),
                'response' => $response->body(),
            ]);

            $workOrder->update([
                'efaktura_status' => 'error',
                'efaktura_response' => $response->body(),
            ]);
        }

        return [
            'success' => $response->successful(),
            'status' => $response->status(),
            'data' => $response->json(),
        ];
    }

    /**
     * Send UBL XML to the eFaktura API with retry logic.
     */
    protected function sendXmlWithRetry(string $xml, int $attempt = 1): \Illuminate\Http\Client\Response
    {
        $token = $this->getAccessToken();
        $baseUrl = config('efaktura.base_url');
        $apiKey = config('efaktura.api_key');

        $headers = [
            'Content-Type' => 'application/xml',
            'Accept' => 'application/json',
        ];

        if ($apiKey) {
            $headers['ApiKey'] = $apiKey;
        }

        $request = Http::withHeaders($headers);

        if ($token) {
            $request = $request->withToken($token);
        }

        // Generate unique requestId (required by the API to process the invoice)
        $requestId = (string) Str::uuid();
        $url = $baseUrl . '/sales-invoice/ubl?requestId=' . $requestId . '&sendToCir=No';

        $response = $request->withBody($xml, 'application/xml')
            ->post($url);

        // If 401 Unauthorized and we haven't exhausted retries, refresh token and retry
        if ($response->status() === 401 && $attempt < $this->maxRetries) {
            Log::warning('Efaktura: Received 401, refreshing token and retrying.', [
                'attempt' => $attempt,
            ]);
            $this->refreshAccessToken();
            return $this->sendXmlWithRetry($xml, $attempt + 1);
        }

        // Retry on server errors (5xx)
        if ($response->serverError() && $attempt < $this->maxRetries) {
            Log::warning('Efaktura: Server error, retrying.', [
                'attempt' => $attempt,
                'status' => $response->status(),
            ]);
            sleep(1);
            return $this->sendXmlWithRetry($xml, $attempt + 1);
        }

        return $response;
    }

    /**
     * Build a UBL 2.1 Invoice XML document from the work order data.
     */
    protected function buildUblXml(WorkOrder $workOrder): string
    {
        $companyName = Setting::where('key', 'company_name')->value('value') ?? '';
        $companyPib = Setting::where('key', 'company_pib')->value('value') ?? '';
        $companyMaticniBroj = Setting::where('key', 'company_maticni_broj')->value('value') ?? '';
        $companyAddress = Setting::where('key', 'company_address')->value('value') ?? '';
        $companyPhone = Setting::where('key', 'company_phone')->value('value') ?? '';
        $companyEmail = Setting::where('key', 'company_email')->value('value') ?? '';
        $companyBankAccount = Setting::where('key', 'company_bank_account')->value('value') ?? '';

        $grandTotal = $this->calculateGrandTotal($workOrder);
        $kmPrice = (float) (Setting::where('key', 'km_price')->value('value') ?? 0);

        $issueDate = $workOrder->created_at->format('Y-m-d');
        $dueDate = $workOrder->created_at->copy()->addMonth()->format('Y-m-d');

        $doc = new DOMDocument('1.0', 'UTF-8');
        $doc->formatOutput = true;

        // Root <Invoice> element with UBL 2.1 namespaces
        $invoice = $doc->createElementNS(self::NS_INVOICE, 'Invoice');
        $invoice->setAttribute('xmlns:cac', self::NS_CAC);
        $invoice->setAttribute('xmlns:cbc', self::NS_CBC);
        $invoice->setAttribute('xmlns:cef', self::NS_CEF);
        $doc->appendChild($invoice);

        // CustomizationID — Serbian eFaktura requires this
        $this->addCbcElement($doc, $invoice, 'CustomizationID',
            'urn:cen.eu:en16931:2017#compliant#urn:mfin.gov.rs:srbdt:2022');

        // Invoice ID
        $this->addCbcElement($doc, $invoice, 'ID', $workOrder->invoice_number);

        // Issue Date
        $this->addCbcElement($doc, $invoice, 'IssueDate', $issueDate);

        // Due Date
        $this->addCbcElement($doc, $invoice, 'DueDate', $dueDate);

        // InvoiceTypeCode: 380 = Commercial Invoice
        $this->addCbcElement($doc, $invoice, 'InvoiceTypeCode', '380');

        // Note
        $this->addCbcElement($doc, $invoice, 'Note', 'Izdavalac računa nije obveznik PDV-a.');

        // Document Currency Code
        $this->addCbcElement($doc, $invoice, 'DocumentCurrencyCode', 'RSD');

        // InvoicePeriod
        $period = $doc->createElementNS(self::NS_CAC, 'cac:InvoicePeriod');
        $this->addCbcElement($doc, $period, 'StartDate', $issueDate);
        $this->addCbcElement($doc, $period, 'EndDate', $issueDate);
        $invoice->appendChild($period);

        // AccountingSupplierParty (Seller)
        $supplierParty = $doc->createElementNS(self::NS_CAC, 'cac:AccountingSupplierParty');
        $party = $doc->createElementNS(self::NS_CAC, 'cac:Party');

        // Supplier Endpoint (PIB as electronic address)
        if ($companyPib) {
            $endpointId = $this->addCbcElement($doc, $party, 'EndpointID', $companyPib);
            $endpointId->setAttribute('schemeID', '9948'); // Serbia PIB scheme
        }

        // Supplier PartyName
        $partyName = $doc->createElementNS(self::NS_CAC, 'cac:PartyName');
        $this->addCbcElement($doc, $partyName, 'Name', $companyName);
        $party->appendChild($partyName);

        // Supplier PostalAddress
        if ($companyAddress) {
            $postalAddress = $doc->createElementNS(self::NS_CAC, 'cac:PostalAddress');
            $this->addCbcElement($doc, $postalAddress, 'StreetName', $companyAddress);
            $country = $doc->createElementNS(self::NS_CAC, 'cac:Country');
            $this->addCbcElement($doc, $country, 'IdentificationCode', 'RS');
            $postalAddress->appendChild($country);
            $party->appendChild($postalAddress);
        }

        // Supplier Legal Entity (Matični broj)
        $legalEntity = $doc->createElementNS(self::NS_CAC, 'cac:PartyLegalEntity');
        $this->addCbcElement($doc, $legalEntity, 'RegistrationName', $companyName);
        if ($companyMaticniBroj) {
            $this->addCbcElement($doc, $legalEntity, 'CompanyID', $companyMaticniBroj);
        }
        $party->appendChild($legalEntity);

        // Supplier Contact
        if ($companyEmail || $companyPhone) {
            $contact = $doc->createElementNS(self::NS_CAC, 'cac:Contact');
            if ($companyPhone) {
                $this->addCbcElement($doc, $contact, 'Telephone', $companyPhone);
            }
            if ($companyEmail) {
                $this->addCbcElement($doc, $contact, 'ElectronicMail', $companyEmail);
            }
            $party->appendChild($contact);
        }

        $supplierParty->appendChild($party);
        $invoice->appendChild($supplierParty);

        // AccountingCustomerParty (Buyer)
        $customerParty = $doc->createElementNS(self::NS_CAC, 'cac:AccountingCustomerParty');
        $cParty = $doc->createElementNS(self::NS_CAC, 'cac:Party');

        // Customer Endpoint
        $buyerPib = $workOrder->invoice_pib ?? '';
        if ($buyerPib) {
            $cEndpoint = $this->addCbcElement($doc, $cParty, 'EndpointID', $buyerPib);
            $cEndpoint->setAttribute('schemeID', '9948');
        }

        // Customer PartyName
        $cPartyName = $doc->createElementNS(self::NS_CAC, 'cac:PartyName');
        $this->addCbcElement($doc, $cPartyName, 'Name', $workOrder->invoice_company_name ?? '');
        $cParty->appendChild($cPartyName);

        // Customer PostalAddress
        $cPostal = $doc->createElementNS(self::NS_CAC, 'cac:PostalAddress');
        $this->addCbcElement($doc, $cPostal, 'StreetName', $workOrder->invoice_address ?? '');
        $cCountry = $doc->createElementNS(self::NS_CAC, 'cac:Country');
        $this->addCbcElement($doc, $cCountry, 'IdentificationCode', 'RS');
        $cPostal->appendChild($cCountry);
        $cParty->appendChild($cPostal);

        // Customer Legal Entity (with matični broj if available)
        $cLegal = $doc->createElementNS(self::NS_CAC, 'cac:PartyLegalEntity');
        $this->addCbcElement($doc, $cLegal, 'RegistrationName', $workOrder->invoice_company_name ?? '');
        if ($workOrder->maticni_broj) {
            $this->addCbcElement($doc, $cLegal, 'CompanyID', $workOrder->maticni_broj);
        }
        $cParty->appendChild($cLegal);

        // Customer Contact
        $cContact = $doc->createElementNS(self::NS_CAC, 'cac:Contact');
        if ($workOrder->invoice_phone) {
            $this->addCbcElement($doc, $cContact, 'Telephone', $workOrder->invoice_phone);
        }
        if ($workOrder->invoice_email) {
            $this->addCbcElement($doc, $cContact, 'ElectronicMail', $workOrder->invoice_email);
        }
        $cParty->appendChild($cContact);

        $customerParty->appendChild($cParty);
        $invoice->appendChild($customerParty);

        // Delivery (ActualDeliveryDate is mandatory for Serbian eFaktura)
        $delivery = $doc->createElementNS(self::NS_CAC, 'cac:Delivery');
        $this->addCbcElement($doc, $delivery, 'ActualDeliveryDate', $issueDate);
        $invoice->appendChild($delivery);

        // PaymentMeans
        $paymentMeans = $doc->createElementNS(self::NS_CAC, 'cac:PaymentMeans');
        // 30 = Credit transfer
        $this->addCbcElement($doc, $paymentMeans, 'PaymentMeansCode', '30');
        if ($companyBankAccount) {
            $payeeAccount = $doc->createElementNS(self::NS_CAC, 'cac:PayeeFinancialAccount');
            $this->addCbcElement($doc, $payeeAccount, 'ID', $companyBankAccount);
            $paymentMeans->appendChild($payeeAccount);
        }
        $invoice->appendChild($paymentMeans);

        // TaxTotal
        $taxTotal = $doc->createElementNS(self::NS_CAC, 'cac:TaxTotal');
        $taxAmountEl = $this->addCbcElement($doc, $taxTotal, 'TaxAmount', '0.00');
        $taxAmountEl->setAttribute('currencyID', 'RSD');

        // TaxSubtotal (SS = Small Supplier / paušalac)
        $taxSubtotal = $doc->createElementNS(self::NS_CAC, 'cac:TaxSubtotal');
        $taxableEl = $this->addCbcElement($doc, $taxSubtotal, 'TaxableAmount', $this->formatAmount($grandTotal));
        $taxableEl->setAttribute('currencyID', 'RSD');
        $subTaxAmt = $this->addCbcElement($doc, $taxSubtotal, 'TaxAmount', '0.00');
        $subTaxAmt->setAttribute('currencyID', 'RSD');

        $taxCategory = $doc->createElementNS(self::NS_CAC, 'cac:TaxCategory');
        $this->addCbcElement($doc, $taxCategory, 'ID', 'SS'); // SS = Small Supplier (paušalac)
        $this->addCbcElement($doc, $taxCategory, 'Percent', '0.00');
        $this->addCbcElement($doc, $taxCategory, 'TaxExemptionReasonCode', 'PDV-RS-33');
        $this->addCbcElement($doc, $taxCategory, 'TaxExemptionReason', 'Promet dobara i usluga koji vrši mali obveznik');
        $catTaxScheme = $doc->createElementNS(self::NS_CAC, 'cac:TaxScheme');
        $this->addCbcElement($doc, $catTaxScheme, 'ID', 'VAT');
        $taxCategory->appendChild($catTaxScheme);
        $taxSubtotal->appendChild($taxCategory);
        $taxTotal->appendChild($taxSubtotal);
        $invoice->appendChild($taxTotal);

        // LegalMonetaryTotal
        $monetaryTotal = $doc->createElementNS(self::NS_CAC, 'cac:LegalMonetaryTotal');
        $lineExtAmt = $this->addCbcElement($doc, $monetaryTotal, 'LineExtensionAmount', $this->formatAmount($grandTotal));
        $lineExtAmt->setAttribute('currencyID', 'RSD');
        $taxExcl = $this->addCbcElement($doc, $monetaryTotal, 'TaxExclusiveAmount', $this->formatAmount($grandTotal));
        $taxExcl->setAttribute('currencyID', 'RSD');
        $taxIncl = $this->addCbcElement($doc, $monetaryTotal, 'TaxInclusiveAmount', $this->formatAmount($grandTotal));
        $taxIncl->setAttribute('currencyID', 'RSD');
        $payable = $this->addCbcElement($doc, $monetaryTotal, 'PayableAmount', $this->formatAmount($grandTotal));
        $payable->setAttribute('currencyID', 'RSD');
        $invoice->appendChild($monetaryTotal);

        // InvoiceLines
        $lineNumber = 1;

        foreach ($workOrder->sections as $section) {
            // Material items
            foreach ($section->items as $item) {
                $this->addInvoiceLine($doc, $invoice, [
                    'id' => $lineNumber++,
                    'name' => $item->product->name ?? 'Materijal',
                    'description' => $section->title . ' - ' . ($item->product->name ?? ''),
                    'quantity' => (float) $item->quantity,
                    'unit' => $this->mapUnitCode($item->product->unit ?? 'kom'),
                    'price' => (float) $item->price_at_time,
                    'amount' => (float) $item->subtotal,
                ]);
            }

            // Service price (paušal)
            if ($section->service_price && $section->service_price > 0) {
                $this->addInvoiceLine($doc, $invoice, [
                    'id' => $lineNumber++,
                    'name' => 'Usluga: ' . $section->title,
                    'description' => 'Usluga rada - ' . $section->title,
                    'quantity' => 1,
                    'unit' => 'HUR', // Hour (service)
                    'price' => (float) $section->service_price,
                    'amount' => (float) $section->service_price,
                ]);
            }
        }

        // Travel cost line
        if ($workOrder->km_to_destination && $kmPrice > 0) {
            $travelCost = $workOrder->km_to_destination * $kmPrice;
            $this->addInvoiceLine($doc, $invoice, [
                'id' => $lineNumber++,
                'name' => 'Putni troškovi',
                'description' => $workOrder->km_to_destination . ' km × ' . number_format($kmPrice, 2) . ' RSD',
                'quantity' => (float) $workOrder->km_to_destination,
                'unit' => 'KMT', // Kilometre
                'price' => $kmPrice,
                'amount' => $travelCost,
            ]);
        }

        return $doc->saveXML();
    }

    /**
     * Add a single UBL InvoiceLine element.
     */
    protected function addInvoiceLine(DOMDocument $doc, \DOMElement $invoice, array $line): void
    {
        $invoiceLine = $doc->createElementNS(self::NS_CAC, 'cac:InvoiceLine');

        $this->addCbcElement($doc, $invoiceLine, 'ID', (string) $line['id']);

        $qty = $this->addCbcElement($doc, $invoiceLine, 'InvoicedQuantity', $this->formatAmount($line['quantity']));
        $qty->setAttribute('unitCode', $line['unit']);

        $lineAmt = $this->addCbcElement($doc, $invoiceLine, 'LineExtensionAmount', $this->formatAmount($line['amount']));
        $lineAmt->setAttribute('currencyID', 'RSD');

        // Item
        $item = $doc->createElementNS(self::NS_CAC, 'cac:Item');
        if (!empty($line['description'])) {
            $this->addCbcElement($doc, $item, 'Description', $line['description']);
        }
        $this->addCbcElement($doc, $item, 'Name', $line['name']);

        // ClassifiedTaxCategory for the line
        $classTax = $doc->createElementNS(self::NS_CAC, 'cac:ClassifiedTaxCategory');
        $this->addCbcElement($doc, $classTax, 'ID', 'SS'); // SS = Small Supplier (paušalac)
        $this->addCbcElement($doc, $classTax, 'Percent', '0.00');
        $classTaxScheme = $doc->createElementNS(self::NS_CAC, 'cac:TaxScheme');
        $this->addCbcElement($doc, $classTaxScheme, 'ID', 'VAT');
        $classTax->appendChild($classTaxScheme);
        $item->appendChild($classTax);

        $invoiceLine->appendChild($item);

        // Price
        $price = $doc->createElementNS(self::NS_CAC, 'cac:Price');
        $priceAmt = $this->addCbcElement($doc, $price, 'PriceAmount', $this->formatAmount($line['price']));
        $priceAmt->setAttribute('currencyID', 'RSD');
        $invoiceLine->appendChild($price);

        $invoice->appendChild($invoiceLine);
    }

    /**
     * Add a cbc: element to a parent.
     */
    protected function addCbcElement(DOMDocument $doc, \DOMElement $parent, string $name, string $value): \DOMElement
    {
        $el = $doc->createElementNS(self::NS_CBC, 'cbc:' . $name);
        $el->appendChild($doc->createTextNode($value));
        $parent->appendChild($el);
        return $el;
    }

    /**
     * Format a numeric amount to 2 decimal places.
     */
    protected function formatAmount(float $amount): string
    {
        return number_format($amount, 2, '.', '');
    }

    /**
     * Map local unit names to UN/ECE Recommendation 20 unit codes.
     */
    protected function mapUnitCode(string $unit): string
    {
        $map = [
            'kom' => 'H87',   // Piece
            'komad' => 'H87',
            'pcs' => 'H87',
            'm' => 'MTR',     // Metre
            'metar' => 'MTR',
            'm2' => 'MTK',    // Square metre
            'm3' => 'MTQ',    // Cubic metre
            'kg' => 'KGM',    // Kilogram
            'l' => 'LTR',     // Litre
            'litar' => 'LTR',
            'km' => 'KMT',    // Kilometre
            'sat' => 'HUR',   // Hour
            'h' => 'HUR',
            'usluga' => 'HUR',
            'dan' => 'DAY',   // Day
            'pak' => 'PK',    // Pack
            'set' => 'SET',
        ];

        return $map[mb_strtolower($unit)] ?? 'H87'; // Default to piece
    }

    /**
     * Calculate the grand total for a work order including materials, services, and travel.
     */
    protected function calculateGrandTotal(WorkOrder $workOrder): float
    {
        $workOrder->loadMissing(['sections.items.product']);

        $materialsTotal = 0;
        $servicesTotal = 0;

        foreach ($workOrder->sections as $section) {
            foreach ($section->items as $item) {
                $materialsTotal += $item->subtotal;
            }
            if ($section->service_price && $section->service_price > 0) {
                $servicesTotal += $section->service_price;
            }
        }

        $travelCost = 0;
        $kmPrice = (float) (Setting::where('key', 'km_price')->value('value') ?? 0);
        if ($workOrder->km_to_destination && $kmPrice > 0) {
            $travelCost = $workOrder->km_to_destination * $kmPrice;
        }

        return $materialsTotal + $servicesTotal + $travelCost;
    }
}
