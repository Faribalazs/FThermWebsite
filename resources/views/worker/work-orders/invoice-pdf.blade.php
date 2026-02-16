<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
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
            font-size: 10pt;
            color: #1F2937;
            line-height: 1.4;
        }

        .container {
            padding: 20px;
        }

        .header {
            background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
            color: white;
            padding: 20px 25px;
            margin: -20px -20px 15px -20px;
            border-bottom: 3px solid #6366F1;
        }

        .header-content {
            display: table;
            width: 100%;
        }

        .header-left {
            display: table-cell;
            vertical-align: middle;
        }

        .header-right {
            display: table-cell;
            vertical-align: middle;
            text-align: right;
        }

        .header h1 {
            font-size: 24pt;
            margin-bottom: 3px;
            letter-spacing: 1px;
        }

        .header .invoice-number {
            font-size: 13pt;
            opacity: 0.95;
            font-weight: 600;
        }

        .header .invoice-date {
            font-size: 10pt;
            opacity: 0.85;
            margin-top: 2px;
        }

        .company-info {
            display: table;
            width: 100%;
            margin-bottom: 15px;
            border: 1px solid #E5E7EB;
            border-radius: 4px;
            background: #FAFAFA;
        }

        .company-col {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            padding: 12px 15px;
        }

        .company-col:first-child {
            border-right: 1px solid #E5E7EB;
        }

        .company-col h3 {
            font-size: 8pt;
            text-transform: uppercase;
            color: #4F46E5;
            margin-bottom: 6px;
            font-weight: 700;
            letter-spacing: 0.8px;
        }

        .company-col p {
            margin: 3px 0;
            font-size: 9pt;
            line-height: 1.3;
        }

        .company-col .company-name {
            font-size: 11pt;
            font-weight: 700;
            margin-bottom: 6px;
            color: #111827;
        }

        .work-order-info {
            background: #F0F4FF;
            padding: 10px 15px;
            margin-bottom: 15px;
            border-left: 3px solid #4F46E5;
            border-radius: 3px;
        }

        .work-order-info h3 {
            font-size: 8pt;
            text-transform: uppercase;
            color: #4F46E5;
            margin-bottom: 5px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .work-order-info p {
            margin: 2px 0;
            font-size: 9pt;
            color: #374151;
        }

        .section {
            margin-bottom: 15px;
        }

        .section-title {
            font-size: 11pt;
            font-weight: 700;
            color: #4F46E5;
            margin-bottom: 8px;
            padding: 6px 10px;
            background: #F3F4F6;
            border-left: 3px solid #4F46E5;
        }

        .section-header {
            font-size: 10pt;
            font-weight: 700;
            margin-bottom: 6px;
            color: #374151;
            padding: 6px 8px;
            background: #F9FAFB;
            border-radius: 3px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            border: 1px solid #E5E7EB;
        }

        table thead {
            background: linear-gradient(180deg, #4F46E5 0%, #4338CA 100%);
            color: white;
        }

        table th {
            padding: 8px 8px;
            text-align: left;
            font-size: 8pt;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        table th.text-center {
            text-align: center;
        }

        table th.text-right {
            text-align: right;
        }

        table td {
            padding: 7px 8px;
            font-size: 9pt;
            border-bottom: 1px solid #F3F4F6;
            background: white;
        }

        table tbody tr:nth-child(even) td {
            background: #FAFAFA;
        }

        table tbody tr:last-child td {
            border-bottom: none;
        }

        table td.text-center {
            text-align: center;
        }

        table td.text-right {
            text-align: right;
        }

        .product-name {
            font-weight: 600;
            color: #111827;
        }

        .product-unit {
            color: #6B7280;
            font-size: 8pt;
        }

        .time-badge {
            background: #DBEAFE;
            color: #1E40AF;
            padding: 3px 8px;
            border-radius: 10px;
            font-size: 8pt;
            font-weight: 600;
            display: inline-block;
        }

        .totals {
            margin-top: 15px;
            float: right;
            width: 320px;
        }

        .totals table {
            margin: 0;
            border: 2px solid #4F46E5;
        }

        .totals td {
            padding: 6px 12px;
            font-size: 9pt;
        }

        .totals .subtotal-row {
            background: #FAFAFA;
        }

        .totals .subtotal-row td {
            border-bottom: 1px solid #E5E7EB;
        }

        .totals .total-row {
            background: linear-gradient(135deg, #4F46E5 0%, #4338CA 100%);
            color: white;
            font-weight: 700;
            font-size: 12pt;
        }

        .totals .total-row td {
            padding: 10px 12px;
            border: none;
        }

        .footer {
            clear: both;
            margin-top: 25px;
            padding-top: 12px;
            border-top: 2px solid #E5E7EB;
            text-align: center;
            font-size: 8pt;
            color: #6B7280;
        }

        .footer p {
            margin: 3px 0;
        }

        .thank-you {
            font-weight: 700;
            color: #4F46E5;
            font-size: 10pt;
        }

        .clearfix {
            clear: both;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="header-content">
                <div class="header-left">
                    <h1>FAKTURA</h1>
                </div>
                <div class="header-right">
                    <div class="invoice-number">#{{ $workOrder->invoice_number }}</div>
                    <div class="invoice-date">{{ $workOrder->created_at->format('d.m.Y') }}</div>
                </div>
            </div>
        </div>

        <!-- Company and Client Info -->
        <div class="company-info">
            <div class="company-col">
                <h3>Izdavalac</h3>
                <p class="company-name">F-Therm d.o.o.</p>
                <p>Industrijska 15</p>
                <p>Beograd, Srbija</p>
                <p style="margin-top: 5px;"><strong>PIB:</strong> 123456789</p>
                <p><strong>Mat. br:</strong> 987654321</p>
            </div>
            <div class="company-col">
                <h3>Kupac</h3>
                <p class="company-name">{{ $workOrder->invoice_company_name }}</p>
                @if ($workOrder->invoice_pib)
                <p><strong>PIB:</strong> {{ $workOrder->invoice_pib }}</p>
                @endif
                <p>{{ $workOrder->invoice_address }}</p>
                @if ($workOrder->invoice_email)
                <p style="margin-top: 5px;"><strong>Email:</strong> {{ $workOrder->invoice_email }}</p>
                @endif
                @if ($workOrder->invoice_phone)
                <p><strong>Tel:</strong> {{ $workOrder->invoice_phone }}</p>
                @endif
            </div>
        </div>

        <!-- Work Order Info -->
        <div class="work-order-info">
            <h3>Radni Nalog</h3>
            <p><strong>Klijent:</strong> {{ $workOrder->client_name }}</p>
            <p><strong>Lokacija:</strong> {{ $workOrder->location }}</p>
        </div>

        <!-- Items -->
        <div class="section">
            <div class="section-title">STAVKE</div>

            @foreach ($workOrder->sections as $section)
            <div style="margin-bottom: 12px;">
                <div class="section-header">
                    {{ $section->title }}
                    @if($section->hours_spent)
                    <span class="time-badge" style="float: right;">⏱ {{ number_format($section->hours_spent, 2) }}h</span>
                    @endif
                    <div style="clear: both;"></div>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>Proizvod</th>
                            <th class="text-center">Količina</th>
                            <th class="text-right">Jed. Cena (RSD)</th>
                            <th class="text-right">Ukupno (RSD)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($section->items as $item)
                        <tr>
                            <td>
                                <span class="product-name">{{ $item->product->name }}</span>
                                <span class="product-unit">({{ $item->product->unit }})</span>
                            </td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td class="text-right">{{ number_format($item->price_at_time, 2) }}</td>
                            <td class="text-right"><strong>{{ number_format($item->subtotal, 2) }}</strong></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endforeach
        </div>

        <!-- Totals -->
        <div class="totals">
            <table>
                <tr class="subtotal-row">
                    <td>Materijal:</td>
                    <td class="text-right">{{ number_format($workOrder->total_amount, 2) }} RSD</td>
                </tr>
                @if($workOrder->hourly_rate && $workOrder->calculateTotalHours() > 0)
                <tr class="subtotal-row">
                    <td>Rad ({{ number_format($workOrder->calculateTotalHours(), 2) }}h × {{ number_format($workOrder->hourly_rate, 2) }} RSD):</td>
                    <td class="text-right">{{ number_format($workOrder->calculateLaborCost(), 2) }} RSD</td>
                </tr>
                <tr class="subtotal-row">
                    <td>Osnova:</td>
                    <td class="text-right">{{ number_format($workOrder->calculateGrandTotal() / 1.2, 2) }} RSD</td>
                </tr>
                <tr class="subtotal-row">
                    <td>PDV (20%):</td>
                    <td class="text-right">{{ number_format($workOrder->calculateGrandTotal() - ($workOrder->calculateGrandTotal() / 1.2), 2) }} RSD</td>
                </tr>
                <tr class="total-row">
                    <td>UKUPNO:</td>
                    <td class="text-right">{{ number_format($workOrder->calculateGrandTotal(), 2) }} RSD</td>
                </tr>
                @else
                <tr class="subtotal-row">
                    <td>Osnova:</td>
                    <td class="text-right">{{ number_format($workOrder->total_amount / 1.2, 2) }} RSD</td>
                </tr>
                <tr class="subtotal-row">
                    <td>PDV (20%):</td>
                    <td class="text-right">{{ number_format($workOrder->total_amount - ($workOrder->total_amount / 1.2), 2) }} RSD</td>
                </tr>
                <tr class="total-row">
                    <td>UKUPNO:</td>
                    <td class="text-right">{{ number_format($workOrder->total_amount, 2) }} RSD</td>
                </tr>
                @endif
            </table>
        </div>

        <div class="clearfix"></div>

        <!-- Footer -->
        <div class="footer">
            <p class="thank-you">Hvala Vam na poverenju!</p>
            <p style="margin-top: 5px;">Za sva pitanja kontaktirajte nas na:</p>
            <p><strong>Email:</strong> info@ftherm.rs | <strong>Tel:</strong> +381 11 123 4567</p>
        </div>
    </div>
</body>
</html>
