<?php

namespace App\Exports;

use App\Models\InternalProduct;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class InternalProductsExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return InternalProduct::all();
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
        ];
    }

    /**
     * @param InternalProduct $product
     * @return array
     */
    public function map($product): array
    {
        return [
            $product->name,
            $product->unit,
            $product->price,
            $product->low_stock_threshold,
        ];
    }

    /**
     * @param Worksheet $sheet
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}
