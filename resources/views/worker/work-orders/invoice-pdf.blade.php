<!DOCTYPE html>
<html lang="sr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faktura #{{ $workOrder->invoice_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 9pt;
            color: #1a1a1a;
            line-height: 1.5;
            background: #ffffff;
        }

        .container {
            padding: 30px 40px;
            max-width: 800px;
            margin: 0 auto;
        }

        /* Header Section */
        .header {
            display: table;
            width: 100%;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 1px solid #4a4a4a;
        }

        .header-left {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }

        .header-right {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            text-align: right;
        }

        .logo {
            max-width: 140px;
            height: auto;
            margin-bottom: 12px;
        }

        .company-details {
            font-size: 8.5pt;
            line-height: 1.6;
            color: #4a4a4a;
        }

        .company-details strong {
            color: #1a1a1a;
            font-weight: 600;
        }

        .company-name {
            font-size: 14pt;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 8px;
        }

        .invoice-title {
            font-size: 24pt;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 8px;
        }

        .invoice-meta {
            font-size: 9pt;
            color: #4a4a4a;
            line-height: 1.8;
        }

        .invoice-meta strong {
            color: #1a1a1a;
            font-weight: 600;
            display: inline-block;
            min-width: 150px;
        }

        /* Client Info Section */
        .parties-section {
            display: table;
            width: 100%;
            margin-bottom: 30px;
            border: 1px solid #d0d0d0;
            border-radius: 0;
        }

        .party-col {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            padding: 15px;
        }

        .party-col:first-child {
            border-right: 1px solid #d0d0d0;
        }

        .party-label {
            font-size: 8pt;
            text-transform: uppercase;
            color: #4a4a4a;
            font-weight: 700;
            letter-spacing: 0.5px;
            margin-bottom: 10px;
        }

        .party-name {
            font-size: 11pt;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 8px;
        }

        .party-details {
            font-size: 8.5pt;
            color: #4a4a4a;
            line-height: 1.6;
        }

        .party-details p {
            margin: 3px 0;
        }

        /* Work Order Info */
        .work-order-box {
            border: 1px solid #d0d0d0;
            border-left: 2px solid #4a4a4a;
            padding: 12px 15px;
            margin-bottom: 30px;
        }

        .work-order-box h3 {
            font-size: 8pt;
            text-transform: uppercase;
            color: #4a4a4a;
            font-weight: 700;
            margin-bottom: 8px;
            letter-spacing: 0.5px;
        }

        .work-order-box p {
            font-size: 8.5pt;
            color: #1a1a1a;
            margin: 3px 0;
        }

        .work-order-box strong {
            font-weight: 600;
        }

        /* Invoice Table */
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
            border: 1px solid #d0d0d0;
        }

        .invoice-table thead {
            border-bottom: 2px solid #1a1a1a;
        }

        .invoice-table th {
            padding: 8px 10px;
            text-align: left;
            font-size: 7.5pt;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            color: #1a1a1a;
            background: white;
        }

        .invoice-table th.center {
            text-align: center;
        }

        .invoice-table th.right {
            text-align: right;
        }

        .invoice-table td {
            padding: 8px 10px;
            font-size: 8.5pt;
            border-bottom: 1px solid #e0e0e0;
            background: white;
        }

        .invoice-table tbody tr:last-child td {
            border-bottom: none;
        }

        .invoice-table td.center {
            text-align: center;
        }

        .invoice-table td.right {
            text-align: right;
            font-weight: 500;
        }

        .item-description {
            font-weight: 600;
            color: #1a1a1a;
        }

        .item-unit {
            color: #7a7a7a;
            font-size: 7.5pt;
            font-style: italic;
        }

        .section-row {
            background: white !important;
            font-weight: 700;
            color: #1a1a1a;
        }

        .section-row td {
            padding: 8px 10px;
            font-size: 8.5pt;
            border-top: 1px solid #4a4a4a;
            border-bottom: 1px solid #d0d0d0 !important;
        }

        /* Totals Section */
        .totals-section {
            float: right;
            width: 350px;
            margin-top: 20px;
        }

        .totals-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #d0d0d0;
        }

        .totals-table td {
            padding: 8px 15px;
            font-size: 9pt;
            border-bottom: 1px solid #e0e0e0;
            background: white;
        }

        .totals-table td:first-child {
            color: #4a4a4a;
            font-weight: 500;
        }

        .totals-table td:last-child {
            text-align: right;
            font-weight: 600;
            color: #1a1a1a;
        }

        .totals-table .total-row {
            border-top: 2px solid #1a1a1a;
            background: white;
            font-weight: 700;
            font-size: 11pt;
        }

        .totals-table .total-row td {
            padding: 10px 15px;
            border-bottom: none;
            color: #1a1a1a;
        }

        /* Footer */
        .footer {
            clear: both;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #d0d0d0;
        }

        .payment-info {
            margin-bottom: 20px;
            font-size: 8.5pt;
            line-height: 1.8;
        }

        .payment-info h4 {
            font-size: 9pt;
            color: #1a1a1a;
            font-weight: 700;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .payment-info p {
            margin: 3px 0;
            color: #4a4a4a;
        }

        .payment-info strong {
            color: #1a1a1a;
            font-weight: 600;
        }

        .footer-note {
            text-align: center;
            font-size: 8pt;
            color: #7a7a7a;
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid #e0e0e0;
        }

        .footer-note p {
            margin: 3px 0;
        }

        .footer-note .thank-you {
            font-weight: 700;
            color: #1a1a1a;
            font-size: 9pt;
            margin-bottom: 5px;
        }

        .clearfix {
            clear: both;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header Section -->
        <div class="header">
            <div class="header-left">
                <img src="{{ public_path('images/logo.svg') }}" alt="F-Therm Logo" class="logo">
                <div class="company-name">F-Therm d.o.o.</div>
                <div class="company-details">
                    <div>Industrijska 15, Beograd, Srbija</div>
                    <div><strong>PIB:</strong> 123456789</div>
                    <div><strong>Mati&#269;ni broj:</strong> 987654321</div>
                    <div><strong>Email:</strong> info@ftherm.rs</div>
                    <div><strong>Tel:</strong> +381 11 123 4567</div>
                </div>
            </div>
            <div class="header-right">
                <div class="invoice-title">FAKTURA</div>
                <div class="company-details">
                    <div><strong>Broj fakture:</strong> {{ $workOrder->invoice_number }}</div>
                    <div><strong>Datum izdavanja:</strong> {{ $workOrder->created_at->format('d.m.Y') }}</div>
                    <div><strong>Datum prometa:</strong> {{ $workOrder->created_at->format('d.m.Y') }}</div>
                    <div><strong>Valuta pla&#263;anja:</strong> {{ $workOrder->created_at->addDays(15)->format('d.m.Y') }}</div>
                </div>
            </div>
        </div>

        <!-- Client Info Section -->
        <div class="parties-section">
            <div class="party-col">
                <div class="party-label">Izdavalac fakture</div>
                <div class="party-name">F-Therm d.o.o.</div>
                <div class="party-details">
                    <p>Industrijska 15</p>
                    <p>Beograd, Srbija</p>
                    <p><strong>PIB:</strong> 123456789</p>
                    <p><strong>Mati&#269;ni broj:</strong> 987654321</p>
                </div>
            </div>
            <div class="party-col">
                <div class="party-label">Kupac</div>
                <div class="party-name">{{ $workOrder->invoice_company_name }}</div>
                <div class="party-details">
                    <p>{{ $workOrder->invoice_address }}</p>
                    @if ($workOrder->invoice_pib)
                    <p><strong>PIB:</strong> {{ $workOrder->invoice_pib }}</p>
                    @endif
                    @if ($workOrder->invoice_email)
                    <p><strong>Email:</strong> {{ $workOrder->invoice_email }}</p>
                    @endif
                    @if ($workOrder->invoice_phone)
                    <p><strong>Telefon:</strong> {{ $workOrder->invoice_phone }}</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Work Order Reference -->
        <div class="work-order-box">
            <h3>Referenca radnog naloga</h3>
            <p><strong>Klijent:</strong> {{ $workOrder->client_name }}</p>
            <p><strong>Lokacija:</strong> {{ $workOrder->location }}</p>
            @if($workOrder->description)
            <p><strong>Napomena:</strong> {{ $workOrder->description }}</p>
            @endif
        </div>

        <!-- Invoice Items Table -->
        <table class="invoice-table">
            <thead>
                <tr>
                    <th style="width: 45%;">Opis</th>
                    <th class="center" style="width: 10%;">Količina</th>
                    <th class="center" style="width: 8%;">Jed.</th>
                    <th class="right" style="width: 12%;">Cena (RSD)</th>
                    <th class="center" style="width: 10%;">PDV %</th>
                    <th class="right" style="width: 15%;">Ukupno (RSD)</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $materialsSubtotal = 0;
                    $materialsTax = 0;
                    $sectionNumber = 1;
                @endphp
                
                @foreach ($workOrder->sections as $section)
                    <tr class="section-row">
                        <td colspan="6">
                            {{ $sectionNumber }}. {{ $section->title }}
                            @if($section->hours_spent)
                                (Utrošeno vreme: {{ number_format($section->hours_spent, 2) }}h)
                            @endif
                        </td>
                    </tr>
                    
                    @foreach ($section->items as $item)
                        @php
                            $itemTotal = $item->subtotal;
                            $itemBase = $itemTotal / 1.2;
                            $itemTax = $itemTotal - $itemBase;
                            $materialsSubtotal += $itemBase;
                            $materialsTax += $itemTax;
                        @endphp
                        <tr>
                            <td>
                                <span class="item-description">{{ $item->product->name }}</span>
                            </td>
                            <td class="center">{{ number_format($item->quantity, 2) }}</td>
                            <td class="center"><span class="item-unit">{{ $item->product->unit }}</span></td>
                            <td class="right">{{ number_format($item->price_at_time, 2) }}</td>
                            <td class="center">20%</td>
                            <td class="right">{{ number_format($itemTotal, 2) }}</td>
                        </tr>
                    @endforeach
                    
                    @php $sectionNumber++; @endphp
                @endforeach

                @if($workOrder->hourly_rate && $workOrder->calculateTotalHours() > 0)
                    @php
                        $laborTotal = $workOrder->calculateLaborCost();
                        $laborBase = $laborTotal / 1.2;
                        $laborTax = $laborTotal - $laborBase;
                    @endphp
                    <tr class="section-row">
                        <td colspan="6">{{ $sectionNumber }}. Usluga rada</td>
                    </tr>
                    <tr>
                        <td>
                            <span class="item-description">Rad na terenu</span>
                        </td>
                        <td class="center">{{ number_format($workOrder->calculateTotalHours(), 2) }}</td>
                        <td class="center"><span class="item-unit">h</span></td>
                        <td class="right">{{ number_format($workOrder->hourly_rate, 2) }}</td>
                        <td class="center">20%</td>
                        <td class="right">{{ number_format($laborTotal, 2) }}</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <!-- Totals Section -->
        <div class="totals-section">
            <table class="totals-table">
                @php
                    $baseTotal = $materialsSubtotal;
                    $taxTotal = $materialsTax;
                    $grandTotal = $workOrder->total_amount;
                    
                    if($workOrder->hourly_rate && $workOrder->calculateTotalHours() > 0) {
                        $laborTotal = $workOrder->calculateLaborCost();
                        $baseTotal += $laborTotal / 1.2;
                        $taxTotal += $laborTotal - ($laborTotal / 1.2);
                        $grandTotal = $workOrder->calculateGrandTotal();
                    }
                @endphp
                <tr>
                    <td>Osnovica (bez PDV-a):</td>
                    <td>{{ number_format($baseTotal, 2) }} RSD</td>
                </tr>
                <tr>
                    <td>PDV 20%:</td>
                    <td>{{ number_format($taxTotal, 2) }} RSD</td>
                </tr>
                <tr class="total-row">
                    <td>UKUPNO ZA UPLATU:</td>
                    <td>{{ number_format($grandTotal, 2) }} RSD</td>
                </tr>
            </table>
        </div>

        <div class="clearfix"></div>

        <!-- Footer Section -->
        <div class="footer">
            <div class="payment-info">
                <h4>Podaci za pla&#263;anje</h4>
                <p><strong>Banka:</strong> Komercijalna banka a.d. Beograd</p>
                <p><strong>Teku&#263;i ra&#269;un:</strong> 205-0000000123456-78</p>
                <p><strong>IBAN:</strong> RS35205000000012345678</p>
                <p><strong>Svrha uplate:</strong> Plaćanje po fakturi {{ $workOrder->invoice_number }}</p>
            </div>

            <div class="footer-note">
                <p class="thank-you">Hvala Vam na poverenju!</p>
                <p>Ova faktura je kreirana elektronski i va&#382;e&#263;a je bez pe&#269;ata i potpisa.</p>
                <p>Za dodatne informacije kontaktirajte nas na info@ftherm.rs ili pozovite +381 11 123 4567</p>
            </div>
        </div>
    </div>
</body>
</html>
