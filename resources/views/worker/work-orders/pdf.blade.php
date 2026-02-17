<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Radni Nalog - {{ $workOrder->id }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10px;
            line-height: 1.3;
            color: #000;
        }
        .container {
            padding: 20px;
        }
        
        /* Header with Company Info */
        .header {
            display: table;
            width: 100%;
            margin-bottom: 15px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        .header-left {
            display: table-cell;
            vertical-align: middle;
            width: 30%;
        }
        .header-right {
            display: table-cell;
            vertical-align: middle;
            width: 70%;
            text-align: right;
            padding-left: 15px;
        }
        .company-name {
            font-size: 11px;
            font-weight: bold;
            margin-bottom: 3px;
        }
        .company-details {
            font-size: 8px;
            line-height: 1.4;
            color: #333;
        }
        .logo {
            max-width: 180px;
            max-height: 90px;
        }
        
        /* Document Title */
        .doc-title {
            text-align: center;
        }
        .doc-title h1 {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 3px;
        }
        .doc-number {
            font-size: 11px;
            color: #333;
        }
        
        /* Info Sections */
        .info-section {
            margin-bottom: 12px;
        }
        .info-title {
            font-size: 11px;
            font-weight: bold;
            margin-bottom: 5px;
            padding-bottom: 2px;
            border-bottom: 1px solid #ccc;
        }
        .info-grid {
            display: table;
            width: 100%;
        }
        .info-row {
            display: table-row;
        }
        .info-label {
            display: table-cell;
            font-weight: bold;
            padding: 2px 10px 2px 0;
            width: 30%;
            font-size: 9px;
            color: #333;
        }
        .info-value {
            display: table-cell;
            padding: 2px 0;
            font-size: 9px;
        }
        
        /* Client and Meta Info Side by Side */
        .two-column {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        .column {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            padding-right: 15px;
        }
        .column:last-child {
            padding-right: 0;
            padding-left: 15px;
        }
        
        /* Tables */
        .section {
            margin-bottom: 15px;
            page-break-inside: avoid;
        }
        .section-header {
            font-size: 11px;
            font-weight: bold;
            margin-bottom: 5px;
            padding: 3px 0;
            border-bottom: 1px solid #000;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
        }
        th {
            background: #f5f5f5;
            padding: 4px 6px;
            text-align: left;
            font-weight: bold;
            font-size: 9px;
            border: 1px solid #ddd;
        }
        td {
            padding: 3px 6px;
            border: 1px solid #ddd;
            font-size: 9px;
        }
        .text-right {
            text-align: right;
        }
        
        /* Totals */
        .totals {
            margin-top: 12px;
            border-top: 2px solid #000;
            padding-top: 6px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 3px 0;
            font-size: 10px;
        }
        .total-row.grand {
            border-top: 2px solid #000;
            padding-top: 6px;
            margin-top: 6px;
            font-size: 12px;
            font-weight: bold;
        }
        
        /* Footer */
        .footer {
            margin-top: 20px;
            padding-top: 8px;
            border-top: 1px solid #ccc;
            text-align: center;
            font-size: 8px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Company Header -->
        <div class="header">
            <div class="header-left">
                <img src="{{ public_path('images/logo.svg') }}" alt="FTherm Logo" class="logo">
            </div>
            <div class="header-right">
                <div class="company-name">Tibor Farkaš PR FTherm SZR</div>
                <div class="company-details">
                    Nadežde Petrović 6 Subotica<br>
                    PIB: 110054333 | Matični broj: 64615327<br>
                    Tekući račun: 165-7007689513-11<br>
                    Telefon: 0641391360 | E-mail: farkas.tibor@ftherm.rs<br>
                    Šifra delatnosti: 4322
                </div>
            </div>
        </div>

        <!-- Document Title -->
        <div class="doc-title">
            <h1>RADNI NALOG</h1>
        </div>

        <!-- Client Info -->
        <div class="info-section" style="margin-bottom: 12px;">
            <div class="info-title">
                Informacije o Klijentu
            </div>
                    <div class="info-grid">
                        @if($workOrder->client_type === 'pravno_lice')
                            @if($workOrder->company_name)
                            <div class="info-row">
                                <div class="info-label">Kompanija:</div>
                                <div class="info-value">{{ $workOrder->company_name }}</div>
                            </div>
                            @endif
                            @if($workOrder->pib)
                            <div class="info-row">
                                <div class="info-label">PIB:</div>
                                <div class="info-value">{{ $workOrder->pib }}</div>
                            </div>
                            @endif
                            @if($workOrder->maticni_broj)
                            <div class="info-row">
                                <div class="info-label">Matični Broj:</div>
                                <div class="info-value">{{ $workOrder->maticni_broj }}</div>
                            </div>
                            @endif
                            @if($workOrder->company_address)
                            <div class="info-row">
                                <div class="info-label">Adresa:</div>
                                <div class="info-value">{{ $workOrder->company_address }}</div>
                            </div>
                            @endif
                        @else
                            @if($workOrder->client_name)
                            <div class="info-row">
                                <div class="info-label">Ime i Prezime:</div>
                                <div class="info-value">{{ $workOrder->client_name }}</div>
                            </div>
                            @endif
                            @if($workOrder->client_address)
                            <div class="info-row">
                                <div class="info-label">Adresa:</div>
                                <div class="info-value">{{ $workOrder->client_address }}</div>
                            </div>
                            @endif
                        @endif
                        @if($workOrder->client_phone)
                        <div class="info-row">
                            <div class="info-label">Telefon:</div>
                            <div class="info-value">{{ $workOrder->client_phone }}</div>
                        </div>
                        @endif
                        @if($workOrder->client_email)
                        <div class="info-row">
                            <div class="info-label">Email:</div>
                            <div class="info-value">{{ $workOrder->client_email }}</div>
                        </div>
                        @endif
                        <div class="info-row">
                            <div class="info-label">Lokacija:</div>
                            <div class="info-value">{{ $workOrder->location }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Datum:</div>
                            <div class="info-value">{{ $workOrder->created_at->format('d.m.Y H:i') }}</div>
                        </div>
                    </div>
        </div>

        <!-- Work Sections -->
        @foreach($workOrder->sections as $section)
        <div class="section">
            <div class="section-header">
                {{ $section->title }}
                @if($section->hours_spent)
                    <span style="float: right; font-weight: normal; font-size: 9px;">Vreme: {{ number_format($section->hours_spent, 2) }}h</span>
                @endif
            </div>

            <table>
                <thead>
                    <tr>
                        <th style="width: 70%;">Materijal</th>
                        <th style="width: 30%;" class="text-right">Količina</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($section->items as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td class="text-right">{{ $item->quantity }} {{ $item->product->unit }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endforeach

        @if($workOrder->km_to_destination)
        <!-- Distance Info -->
        <div class="section" style="margin-top: 15px;">
            <div class="section-header">
                Dodatne Informacije
            </div>
            <table>
                <thead>
                    <tr>
                        <th style="width: 70%;">Opis</th>
                        <th style="width: 30%;" class="text-right">Količina</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Kilometara do destinacije</td>
                        <td class="text-right">{{ number_format($workOrder->km_to_destination, 0) }} km</td>
                    </tr>
                </tbody>
            </table>
        </div>
        @endif

        <!-- Footer -->
        <div class="footer">
            <p>Radni nalog generisan: {{ now()->format('d.m.Y H:i') }}</p>
            <p>FTherm - Sistem za upravljanje radnim nalozima</p>
        </div>
    </div>
</body>
</html>
