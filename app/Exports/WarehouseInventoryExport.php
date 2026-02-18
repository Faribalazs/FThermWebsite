<?php

namespace App\Exports;

use App\Models\Warehouse;
use App\Models\Inventory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class WarehouseInventoryExport implements FromCollection, WithHeadings, WithMapping, WithStyles
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
        return Inventory::where('warehouse_id', $this->warehouse->id)
            ->where('quantity', '>', 0)
            ->with(['product'])
            ->orderBy('quantity', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Naziv',
            'Stanje',
            'Cena (RSD)',
            'Jedinica'
        ];
    }

    public function map($inventory): array
    {
        return [
            $inventory->product->name,
            $inventory->quantity,
            number_format($inventory->product->price, 2, ',', '.'),
            $inventory->product->unit
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}
