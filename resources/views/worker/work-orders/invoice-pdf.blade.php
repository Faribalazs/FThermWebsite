<!DOCTYPE html>
<html lang="sr">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
            font-size: 8pt;
            color: #000;
            line-height: 1.3;
            background: #ffffff;
        }

        .container {
            padding: 15px 20px;
            max-width: 100%;
        }

        /* Top Header Section */
        .top-header {
            display: table;
            width: 100%;
            margin-bottom: 8px;
            border-bottom: 1px solid #000;
            padding-bottom: 8px;
        }

        .top-header-left {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            font-size: 9pt;
            line-height: 1.4;
        }

        .top-header-right {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            text-align: right;
            font-size: 7.5pt;
            line-height: 1.4;
        }

        .company-title {
            font-size: 13pt;
            font-weight: bold;
            margin-bottom: 3px;
        }

        /* Middle Section */
        .middle-section {
            display: table;
            width: 100%;
            margin-bottom: 10px;
        }

        .invoice-info {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            font-size: 9pt;
            font-weight: bold;
        }

        .customer-box {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }

        .customer-inner {
            border: 2px solid #000;
            padding: 8px;
            font-size: 8pt;
            line-height: 1.4;
        }

        .customer-title {
            font-size: 9pt;
            font-weight: bold;
            margin-bottom: 5px;
        }

        /* Invoice Table */
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
            border: 1px solid #000;
        }

        .invoice-table th {
            background: #fff;
            border: 1px solid #000;
            padding: 4px 3px;
            font-size: 7pt;
            font-weight: bold;
            text-align: center;
        }

        .invoice-table td {
            border: 1px solid #000;
            padding: 4px 3px;
            font-size: 7.5pt;
        }

        .invoice-table td.center {
            text-align: center;
        }

        .invoice-table td.right {
            text-align: right;
        }

        /* Totals */
        .totals {
            text-align: right;
            font-size: 10pt;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .amount-words {
            font-size: 8pt;
            font-style: italic;
            margin-bottom: 15px;
            padding: 8px;
            background: #f5f5f5;
            border-left: 3px solid #000;
        }

        /* Footer */
        .footer {
            font-size: 7.5pt;
            line-height: 1.4;
            margin-top: 15px;
            padding-top: 10px;
            border-top: 1px solid #000;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Top Header -->
        <div class="top-header">
            <div style="display: table-cell; width: 20%; vertical-align: middle; padding-right: 10px;">
                <img src="{{ public_path('images/logo.svg') }}" alt="Logo" style="max-width: 100%; height: auto; max-height: 90px;">
            </div>
            <div class="top-header-left" style="width: 40%;">
                <div class="company-title">{{ $companyName }}</div>
                <div>{{ $companyAddress }}</div>
                <div>Telefon/Fax: {{ $companyPhone }}</div>
                <div>email: {{ $companyEmail }}</div>
            </div>
            <div class="top-header-right" style="width: 40%;">
                <div>Šifra delatnosti: {{ $companySifraDelatnosti }} Matični broj: {{ $companyMaticniBroj }}</div>
                <div>PIB: {{ $companyPib }}</div>
                <div>Tekući račun:</div>
                <div><strong>{{ $companyBankAccount }}</strong></div>
            </div>
        </div>

        <!-- Middle Section -->
        <div class="middle-section">
            <div class="invoice-info">
                <div style="margin-bottom: 10px;">
                    <div style="font-size: 11pt;">Br. računa: {{ $workOrder->invoice_number }}</div>
                </div>
                <div style="font-weight: normal; font-size: 8pt;">
                    <div>Mesto i datum izdavanja: {{ $workOrder->location }},
                        {{ $workOrder->created_at->format('d/m/Y') }}</div>
                    <div>Datum prometa: {{ $workOrder->created_at->format('d/m/Y') }}</div>
                    <div>Valuta plaćanja: {{ $workOrder->created_at->copy()->addMonth()->format('d/m/Y') }}</div>
                </div>
            </div>
            <div class="customer-box">
                <div class="customer-inner">
                    @if ($workOrder->client_type === 'pravno_lice')
                        <div class="customer-title" style="font-size: 10pt; font-weight: bold; margin-bottom: 4px;">
                            {{ $workOrder->company_name }}</div>
                        <div style="font-size: 7.5pt;">
                            @if ($workOrder->company_address)
                                <div>Adresa: {{ $workOrder->company_address }}</div>
                            @endif
                            @if ($workOrder->pib)
                                <div>PIB: {{ $workOrder->pib }}</div>
                            @endif
                            @if ($workOrder->maticni_broj)
                                <div>Matični broj: {{ $workOrder->maticni_broj }}</div>
                            @endif
                            @if ($workOrder->location)
                                <div>Lokacija: {{ $workOrder->location }}</div>
                            @endif
                        </div>
                    @else
                        <div class="customer-title" style="font-size: 10pt; font-weight: bold; margin-bottom: 4px;">
                            {{ $workOrder->client_name }}</div>
                        <div style="font-size: 7.5pt;">
                            @if ($workOrder->client_address)
                                <div>Adresa: {{ $workOrder->client_address }}</div>
                            @endif
                            @if ($workOrder->location)
                                <div>Lokacija: {{ $workOrder->location }}</div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Invoice Table -->
        <table class="invoice-table">
            <thead>
                <tr>
                    <th style="width: 5%;">Rbr</th>
                    <th style="width: 55%;">Naziv dobra / usluge</th>
                    <th style="width: 10%;">JM</th>
                    <th style="width: 10%;">Kol.</th>
                    <th style="width: 15%;">Cena</th>
                    <th style="width: 15%;">Vrednost</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $rowNumber = 1;
                    $materialsTotal = 0;
                @endphp

                @foreach ($workOrder->sections as $section)
                    @foreach ($section->items as $item)
                        @php
                            $itemTotal = $item->subtotal;
                            $materialsTotal += $itemTotal;
                        @endphp
                        <tr>
                            <td class="center">{{ $rowNumber }}</td>
                            <td>{{ $item->product->name }}</td>
                            <td class="center">{{ $item->product->unit }}</td>
                            <td class="right">{{ number_format($item->quantity, 2) }}</td>
                            <td class="right">{{ number_format($item->price_at_time, 2) }}</td>
                            <td class="right">{{ number_format($itemTotal, 2) }}</td>
                        </tr>
                        @php $rowNumber++; @endphp
                    @endforeach
                @endforeach

                @php
                    $servicesTotal = 0;
                @endphp

                @foreach ($workOrder->sections as $section)
                    @if ($section->service_price && $section->service_price > 0)
                        @php
                            $servicesTotal += $section->service_price;
                        @endphp
                        <tr>
                            <td class="center">{{ $rowNumber }}</td>
                            <td>{{ $section->title }} - Usluge rada</td>
                            <td class="center">paušal</td>
                            <td class="right">1.00</td>
                            <td class="right">{{ number_format($section->service_price, 2) }}</td>
                            <td class="right">{{ number_format($section->service_price, 2) }}</td>
                        </tr>
                        @php $rowNumber++; @endphp
                    @endif
                @endforeach

                @if ($workOrder->km_to_destination && $kmPrice > 0)
                    @php
                        $travelCost = $workOrder->km_to_destination * $kmPrice;
                    @endphp
                    <tr>
                        <td class="center">{{ $rowNumber }}</td>
                        <td>Putni troškovi</td>
                        <td class="center">km</td>
                        <td class="right">{{ number_format($workOrder->km_to_destination, 0) }}</td>
                        <td class="right">{{ number_format($kmPrice, 2) }}</td>
                        <td class="right">{{ number_format($travelCost, 2) }}</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <!-- Totals -->
        @php
            $grandTotal = $materialsTotal + $servicesTotal;
            if ($workOrder->km_to_destination && $kmPrice > 0) {
                $grandTotal += $travelCost;
            }
        @endphp

        <div class="totals">
            Ukupno(din): {{ number_format($grandTotal, 2) }}
        </div>

        <!-- Amount in Words -->
        <div class="amount-words">
            <strong>Slovima:</strong> {{ str_replace(' ', '', number_to_words_serbian($grandTotal)) }} dinara
        </div>

        <!-- Footer -->
        <div class="footer">
            <div style="margin-bottom: 8px;">
                Izdavalac računa nije obveznik pdv-a <br>
                Registrovano u Subotici u slučaju spora nadležan je Privredni sud u Subotici
            </div>
        </div>

        <!-- Signature Section -->
        <div style="margin-top: 150px; display: table; width: 100%;">
            <div style="display: table-cell; width: 25%; max-width: 25%; vertical-align: bottom; padding-right: 20px;">
                <div style="border-top: 1px solid #000; padding-top: 5px; text-align: center; font-size: 8pt;">
                    Računa izdao
                </div>
            </div>
            <div style="display: table-cell; width: 25%; max-width: 25%; vertical-align: bottom; padding-left: 20px;">
                <div style="border-top: 1px solid #000; padding-top: 5px; text-align: center; font-size: 8pt;">
                    Računa primio
                </div>
            </div>
        </div>
    </div>
</body>

</html>
