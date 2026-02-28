<?php

namespace App\Exports;

use App\Models\Warehouse;
use App\Models\InternalProduct;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class WarehouseInventoryExport implements FromCollection, WithHeadings, WithStyles, WithStrictNullComparison
{
    protected $warehouse;

    public function __construct(Warehouse $warehouse)
    {
        $this->warehouse = $warehouse;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return InternalProduct::with(['inventories' => function ($q) {
                $q->where('warehouse_id', $this->warehouse->id);
            }])
            ->orderBy('name')
            ->get()
            ->map(function ($product) {
                $quantity = (int)($product->inventories->first()?->quantity ?? 0);
                return [
                    $product->name,
                    $quantity,
                    number_format($product->price, 2, ',', '.'),
                    $product->unit,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Naziv',
            'Stanje',
            'Cena (RSD)',
            'Jedinica',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}

