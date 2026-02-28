<?php

namespace App\Imports;

use App\Models\InternalProduct;
use App\Models\Inventory;
use App\Models\Warehouse;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class WarehouseInventoryImport implements ToCollection, WithHeadingRow, WithValidation
{
    protected $warehouse;
    public int $updatedCount = 0;
    public int $skippedCount = 0;

    public function __construct(Warehouse $warehouse)
    {
        $this->warehouse = $warehouse;
    }

    /**
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $naziv = trim($row['naziv'] ?? '');
            $stanje = $row['stanje'] ?? null;

            if ($naziv === '' || $stanje === null) {
                $this->skippedCount++;
                continue;
            }

            $product = InternalProduct::where('name', $naziv)->first();

            if (!$product) {
                $this->skippedCount++;
                continue;
            }

            Inventory::updateOrCreate(
                [
                    'internal_product_id' => $product->id,
                    'warehouse_id'        => $this->warehouse->id,
                ],
                [
                    'quantity'   => max(0, (float) $stanje),
                    'updated_by' => Auth::guard('worker')->id(),
                ]
            );

            $this->updatedCount++;
        }
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            '*.naziv'  => 'required|string',
            '*.stanje' => 'required|numeric|min:0',
        ];
    }

    /**
     * @return array
     */
    public function customValidationMessages()
    {
        return [
            '*.naziv.required'  => 'Naziv materijala je obavezan.',
            '*.stanje.required' => 'Stanje je obavezno.',
            '*.stanje.numeric'  => 'Stanje mora biti broj.',
            '*.stanje.min'      => 'Stanje ne može biti negativno.',
        ];
    }
}
