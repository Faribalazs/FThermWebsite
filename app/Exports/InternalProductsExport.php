<?php

namespace App\Exports;

use App\Models\InternalProduct;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class InternalProductsExport implements FromCollection, WithHeadings, WithStyles, WithStrictNullComparison
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return InternalProduct::with('inventory')
            ->orderBy('name')
            ->get()
            ->map(function ($product) {
                return [
                    $product->name,
                    $product->unit,
                    $product->price,
                    $product->low_stock_threshold,
                    (int)($product->inventory?->quantity ?? 0),
                ];
            });
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Naziv',
            'Jedinica',
            'Cena (RSD)',
            'Nizak Limit Zaliha',
            'Stanje',
        ];
    }

    /**
     * @param Worksheet $sheet
     */
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}

