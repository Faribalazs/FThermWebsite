<?php

namespace App\Services;

use App\Models\WorkOrder;
use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class EfakturaService
{
    /**
     * Maximum retry attempts for API calls.
     */
    protected int $maxRetries = 3;

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

            // Cache for slightly less than the actual expiry
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
     * Send an invoice to the Serbian eFaktura system.
     */
    public function sendInvoice(WorkOrder $workOrder): array
    {
        // Validate before sending
        $this->validateForSubmission($workOrder);

        $workOrder->load(['sections.items.product', 'worker']);

        $payload = $this->mapInvoiceToEfakturaFormat($workOrder);

        Log::info('Efaktura request', [
            'work_order_id' => $workOrder->id,
            'invoice_number' => $workOrder->invoice_number,
            'payload' => $payload,
        ]);

        $response = $this->sendWithRetry($payload);

        if ($response->successful()) {
            $workOrder->update([
                'efaktura_status' => 'sent',
                'efaktura_response' => $response->body(),
                'efaktura_sent_at' => now(),
            ]);

            Log::info('Efaktura sent successfully', [
                'work_order_id' => $workOrder->id,
                'invoice_number' => $workOrder->invoice_number,
                'response_status' => $response->status(),
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
     * Send the API request with automatic token refresh and retry logic.
     */
    protected function sendWithRetry(array $payload, int $attempt = 1): \Illuminate\Http\Client\Response
    {
        $token = $this->getAccessToken();
        $baseUrl = config('efaktura.base_url');
        $apiKey = config('efaktura.api_key');

        $request = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ]);

        // Use bearer token if available, otherwise use API key
        if ($token) {
            $request = $request->withToken($token);
        }

        if ($apiKey) {
            $request = $request->withHeaders([
                'ApiKey' => $apiKey,
            ]);
        }

        $response = $request->post($baseUrl . '/invoices', $payload);

        // If 401 Unauthorized and we haven't exhausted retries, refresh token and retry
        if ($response->status() === 401 && $attempt < $this->maxRetries) {
            Log::warning('Efaktura: Received 401, refreshing token and retrying.', [
                'attempt' => $attempt,
            ]);
            $this->refreshAccessToken();
            return $this->sendWithRetry($payload, $attempt + 1);
        }

        // Retry on server errors (5xx)
        if ($response->serverError() && $attempt < $this->maxRetries) {
            Log::warning('Efaktura: Server error, retrying.', [
                'attempt' => $attempt,
                'status' => $response->status(),
            ]);
            sleep(1); // Brief delay before retry
            return $this->sendWithRetry($payload, $attempt + 1);
        }

        return $response;
    }

    /**
     * Map the WorkOrder (invoice) data to the eFaktura API format.
     */
    protected function mapInvoiceToEfakturaFormat(WorkOrder $workOrder): array
    {
        $kmPrice = (float) (Setting::where('key', 'km_price')->value('value') ?? 0);
        $companyName = Setting::where('key', 'company_name')->value('value') ?? '';
        $companyPib = Setting::where('key', 'company_pib')->value('value') ?? '';
        $companyMaticniBroj = Setting::where('key', 'company_maticni_broj')->value('value') ?? '';
        $companyAddress = Setting::where('key', 'company_address')->value('value') ?? '';
        $companyPhone = Setting::where('key', 'company_phone')->value('value') ?? '';
        $companyEmail = Setting::where('key', 'company_email')->value('value') ?? '';
        $companyBankAccount = Setting::where('key', 'company_bank_account')->value('value') ?? '';

        // Build line items from sections
        $invoiceLines = [];
        $lineNumber = 1;

        foreach ($workOrder->sections as $section) {
            // Material items
            foreach ($section->items as $item) {
                $invoiceLines[] = [
                    'LineNumber' => $lineNumber++,
                    'ItemName' => $item->product->name ?? 'Materijal',
                    'ItemDescription' => $section->title . ' - ' . ($item->product->name ?? ''),
                    'Quantity' => $item->quantity,
                    'UnitOfMeasure' => $item->product->unit ?? 'kom',
                    'UnitPrice' => (float) $item->price_at_time,
                    'LineAmount' => (float) $item->subtotal,
                    'TaxCategory' => 'S', // Standard rate
                    'TaxPercent' => 0, // Not a VAT payer per the invoice footer
                ];
            }

            // Service price (paušal)
            if ($section->service_price && $section->service_price > 0) {
                $invoiceLines[] = [
                    'LineNumber' => $lineNumber++,
                    'ItemName' => 'Usluga: ' . $section->title,
                    'ItemDescription' => 'Usluga rada - ' . $section->title,
                    'Quantity' => 1,
                    'UnitOfMeasure' => 'usluga',
                    'UnitPrice' => (float) $section->service_price,
                    'LineAmount' => (float) $section->service_price,
                    'TaxCategory' => 'S',
                    'TaxPercent' => 0,
                ];
            }
        }

        // Travel cost line
        $travelCost = 0;
        if ($workOrder->km_to_destination && $kmPrice > 0) {
            $travelCost = $workOrder->km_to_destination * $kmPrice;
            $invoiceLines[] = [
                'LineNumber' => $lineNumber++,
                'ItemName' => 'Putni troškovi',
                'ItemDescription' => $workOrder->km_to_destination . ' km × ' . number_format($kmPrice, 2) . ' RSD',
                'Quantity' => (float) $workOrder->km_to_destination,
                'UnitOfMeasure' => 'km',
                'UnitPrice' => $kmPrice,
                'LineAmount' => $travelCost,
                'TaxCategory' => 'S',
                'TaxPercent' => 0,
            ];
        }

        $grandTotal = $this->calculateGrandTotal($workOrder);

        return [
            'InvoiceNumber' => $workOrder->invoice_number,
            'InvoiceType' => 380, // Commercial invoice
            'DocumentCurrencyCode' => 'RSD',
            'IssueDate' => $workOrder->created_at->format('Y-m-d'),
            'DueDate' => $workOrder->created_at->copy()->addMonth()->format('Y-m-d'),
            'TaxPointDate' => $workOrder->created_at->format('Y-m-d'),

            // Supplier (seller) info
            'Supplier' => [
                'Name' => $companyName,
                'PIB' => $companyPib,
                'MaticniBroj' => $companyMaticniBroj,
                'Address' => $companyAddress,
                'Phone' => $companyPhone,
                'Email' => $companyEmail,
                'BankAccount' => $companyBankAccount,
            ],

            // Customer (buyer) info
            'Customer' => [
                'Name' => $workOrder->invoice_company_name,
                'CustomerType' => $workOrder->invoice_type === 'pravno_lice' ? 'Business' : 'Individual',
                'PIB' => $workOrder->invoice_pib ?? '',
                'Address' => $workOrder->invoice_address ?? '',
                'Email' => $workOrder->invoice_email ?? '',
                'Phone' => $workOrder->invoice_phone ?? '',
            ],

            // Invoice lines
            'InvoiceLines' => $invoiceLines,

            // Totals
            'TotalAmount' => $grandTotal,
            'TaxAmount' => 0, // Not a VAT payer
            'PayableAmount' => $grandTotal,

            // Tax summary
            'TaxSummary' => [
                [
                    'TaxCategory' => 'S',
                    'TaxPercent' => 0,
                    'TaxableAmount' => $grandTotal,
                    'TaxAmount' => 0,
                ],
            ],

            // Notes
            'Note' => 'Izdavalac računa nije obveznik PDV-a.',
        ];
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
