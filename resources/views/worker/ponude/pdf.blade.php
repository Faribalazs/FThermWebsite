<!DOCTYPE html>
<html lang="sr">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ponuda #{{ $ponuda->id }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 8pt; color: #000; line-height: 1.3; background: #ffffff; }
        .container { padding: 15px 20px; max-width: 100%; }
        .top-header { display: table; width: 100%; margin-bottom: 8px; border-bottom: 1px solid #000; padding-bottom: 8px; }
        .top-header-left { display: table-cell; width: 50%; vertical-align: top; font-size: 9pt; line-height: 1.4; }
        .top-header-right { display: table-cell; width: 50%; vertical-align: top; text-align: right; font-size: 7.5pt; line-height: 1.4; }
        .company-title { font-size: 13pt; font-weight: bold; margin-bottom: 3px; }
        .middle-section { display: table; width: 100%; margin-bottom: 10px; }
        .invoice-info { display: table-cell; width: 50%; vertical-align: top; font-size: 9pt; font-weight: bold; }
        .customer-box { display: table-cell; width: 50%; vertical-align: top; }
        .customer-inner { border: 2px solid #000; padding: 8px; font-size: 8pt; line-height: 1.4; }
        .customer-title { font-size: 9pt; font-weight: bold; margin-bottom: 5px; }
        .invoice-table { width: 100%; border-collapse: collapse; margin-bottom: 8px; border: 1px solid #000; }
        .invoice-table th { background: #fff; border: 1px solid #000; padding: 4px 3px; font-size: 7pt; font-weight: bold; text-align: center; }
        .invoice-table td { border: 1px solid #000; padding: 4px 3px; font-size: 7.5pt; }
        .invoice-table td.center { text-align: center; }
        .invoice-table td.right { text-align: right; }
        .totals { text-align: right; font-size: 10pt; font-weight: bold; margin-bottom: 10px; }
        .amount-words { font-size: 8pt; font-style: italic; margin-bottom: 15px; padding: 8px; background: #f5f5f5; border-left: 3px solid #000; }
        .footer { font-size: 7.5pt; line-height: 1.4; margin-top: 15px; padding-top: 10px; border-top: 1px solid #000; }
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
            @if($companySifraDelatnosti || $companyMaticniBroj)
            <div>Šifra delatnosti: {{ $companySifraDelatnosti }} Matični broj: {{ $companyMaticniBroj }}</div>
            @endif
            @if($companyPib)
            <div>PIB: {{ $companyPib }}</div>
            @endif
            @if($companyBankAccount)
            <div>Tekući račun:</div>
            <div><strong>{{ $companyBankAccount }}</strong></div>
            @endif
        </div>
    </div>

    <!-- Middle Section: ponuda info + client -->
    <div class="middle-section">
        <div class="invoice-info">
            <div style="margin-bottom: 10px;">
                <div style="font-size: 11pt;">Br. ponude: {{ $ponuda->id }}/{{ $ponuda->created_at->format('Y') }}</div>
            </div>
            <div style="font-weight: normal; font-size: 8pt;">
                <div>Mesto i datum: {{ $ponuda->location }}, {{ $ponuda->created_at->format('d/m/Y') }}</div>
            </div>
        </div>
        <div class="customer-box">
            <div class="customer-inner">
                @if($ponuda->client_type === 'pravno_lice')
                    <div class="customer-title" style="font-size: 10pt; font-weight: bold; margin-bottom: 4px;">{{ $ponuda->company_name }}</div>
                    <div style="font-size: 7.5pt;">
                        @if($ponuda->company_address)<div>Adresa: {{ $ponuda->company_address }}</div>@endif
                        @if($ponuda->pib)<div>PIB: {{ $ponuda->pib }}</div>@endif
                        @if($ponuda->maticni_broj)<div>Matični broj: {{ $ponuda->maticni_broj }}</div>@endif
                        @if($ponuda->client_phone)<div>Telefon: {{ $ponuda->client_phone }}</div>@endif
                        @if($ponuda->client_email)<div>Email: {{ $ponuda->client_email }}</div>@endif
                    </div>
                @else
                    <div class="customer-title" style="font-size: 10pt; font-weight: bold; margin-bottom: 4px;">{{ $ponuda->client_name }}</div>
                    <div style="font-size: 7.5pt;">
                        @if($ponuda->client_address)<div>Adresa: {{ $ponuda->client_address }}</div>@endif
                        @if($ponuda->client_phone)<div>Telefon: {{ $ponuda->client_phone }}</div>@endif
                        @if($ponuda->client_email)<div>Email: {{ $ponuda->client_email }}</div>@endif
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Document Title -->
    <div style="text-align: center; font-size: 14pt; font-weight: bold; margin-bottom: 8px; letter-spacing: 2px;">
        P O N U D A
    </div>

    <!-- Items Table -->
    @php
        $rowNumber = 1;
        $grandTotal = 0;
        $multiSection = $ponuda->sections->count() > 1;
    @endphp

    <table class="invoice-table">
        <thead>
            <tr>
                <th style="width: 5%;">Rbr</th>
                <th style="width: 50%;">Naziv dobra / usluge</th>
                <th style="width: 10%;">JM</th>
                <th style="width: 10%;">Kol.</th>
                <th style="width: 12%;">Cena</th>
                <th style="width: 13%;">Vrednost</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ponuda->sections as $section)
                @if($multiSection)
                <tr>
                    <td colspan="6" style="font-weight: bold; background: #f0f4f8; font-size: 7.5pt; padding: 3px 5px;">
                        {{ $section->title }}
                    </td>
                </tr>
                @endif

                @foreach($section->items as $item)
                    @php
                        $itemTotal = $item->price_at_time * $item->quantity;
                        $grandTotal += $itemTotal;
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

                @if($section->hours_spent && $section->hours_spent > 0 && $ponuda->hourly_rate)
                    @php
                        $laborCost = $section->hours_spent * $ponuda->hourly_rate;
                        $grandTotal += $laborCost;
                    @endphp
                    <tr>
                        <td class="center">{{ $rowNumber }}</td>
                        <td>{{ $multiSection ? $section->title . ' - Usluge rada' : 'Usluge rada' }}</td>
                        <td class="center">sat</td>
                        <td class="right">{{ number_format($section->hours_spent, 2) }}</td>
                        <td class="right">{{ number_format($ponuda->hourly_rate, 2) }}</td>
                        <td class="right">{{ number_format($laborCost, 2) }}</td>
                    </tr>
                    @php $rowNumber++; @endphp
                @endif

                @if($section->service_price && $section->service_price > 0)
                    @php $grandTotal += $section->service_price; @endphp
                    <tr>
                        <td class="center">{{ $rowNumber }}</td>
                        <td>{{ $multiSection ? $section->title . ' - Usluge' : 'Usluge' }}</td>
                        <td class="center">paušal</td>
                        <td class="right">1,00</td>
                        <td class="right">{{ number_format($section->service_price, 2) }}</td>
                        <td class="right">{{ number_format($section->service_price, 2) }}</td>
                    </tr>
                    @php $rowNumber++; @endphp
                @endif
            @endforeach

            @if($ponuda->km_to_destination && $kmPrice > 0)
                @php
                    $travelCost = $ponuda->km_to_destination * $kmPrice;
                    $grandTotal += $travelCost;
                @endphp
                <tr>
                    <td class="center">{{ $rowNumber }}</td>
                    <td>Putni troškovi</td>
                    <td class="center">km</td>
                    <td class="right">{{ number_format($ponuda->km_to_destination, 0) }}</td>
                    <td class="right">{{ number_format($kmPrice, 2) }}</td>
                    <td class="right">{{ number_format($travelCost, 2) }}</td>
                </tr>
            @endif
        </tbody>
    </table>

    <!-- Totals -->
    <div class="totals">
        Ukupno(din): {{ number_format($grandTotal, 2) }}
    </div>

    <!-- Amount in Words -->
    <div class="amount-words">
        <strong>Slovima:</strong> {{ str_replace(' ', '', number_to_words_serbian($grandTotal)) }} dinara
    </div>

    @if($ponuda->notes)
    <div style="font-size: 8pt; margin-bottom: 15px; padding: 8px; border: 1px solid #ddd;">
        <strong>Napomena:</strong> {{ $ponuda->notes }}
    </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <div style="margin-bottom: 8px;">
            Ponuda važi 30 dana od datuma izdavanja.<br>
            Ova ponuda nije fiskalni račun.
        </div>
    </div>

    <!-- Signature Section -->
    <div style="margin-top: 150px; display: table; width: 100%;">
        <div style="display: table-cell; width: 25%; max-width: 25%; vertical-align: bottom; padding-right: 20px;">
            <div style="border-top: 1px solid #000; padding-top: 5px; text-align: center; font-size: 8pt;">
                Ponudu sačinio
            </div>
        </div>
        <div style="display: table-cell; width: 25%; max-width: 25%; vertical-align: bottom; padding-left: 20px;">
            <div style="border-top: 1px solid #000; padding-top: 5px; text-align: center; font-size: 8pt;">
                Prihvatio
            </div>
        </div>
    </div>

</div>
</body>
</html>
