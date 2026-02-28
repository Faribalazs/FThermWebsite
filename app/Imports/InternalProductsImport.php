<?php

namespace App\Imports;

use App\Models\InternalProduct;
use App\Models\Inventory;
use App\Models\Warehouse;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Facades\Auth;

class InternalProductsImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $stanje = isset($row['stanje']) ? (float) $row['stanje'] : null;

        // Always check by name first to avoid duplicates
        $existingProduct = InternalProduct::where('name', $row['naziv'])->first();

        if ($existingProduct) {
            // Update existing product fields
            $existingProduct->update([
                'unit'                => $row['jedinica'],
                'price'               => $row['cena_rsd'],
                'low_stock_threshold' => $row['nizak_limit_zaliha'] ?? 10,
            ]);

            // Update quantity if stanje column is present
            if ($stanje !== null) {
                $this->updateInventory($existingProduct, $stanje);
            }

            return null;
        }

        // Create new product
        $product = InternalProduct::create([
            'name'                => $row['naziv'],
            'unit'                => $row['jedinica'],
            'price'               => $row['cena_rsd'],
            'low_stock_threshold' => $row['nizak_limit_zaliha'] ?? 10,
            'created_by'          => Auth::guard('worker')->id(),
        ]);

        // Set quantity for new product if provided
        if ($stanje !== null) {
            $this->updateInventory($product, $stanje);
        }

        return null; // already saved via create()
    }

    /**
     * Update or create the inventory record for the given product.
     * Uses the product's existing inventory warehouse, or falls back to the first active warehouse.
     */
    private function updateInventory(InternalProduct $product, float $quantity): void
    {
        $existing = $product->inventory; // hasOne — first inventory record

        $warehouseId = $existing?->warehouse_id
            ?? Warehouse::where('is_active', true)->value('id')
            ?? Warehouse::value('id');

        if (!$warehouseId) {
            return; // no warehouse configured yet
        }

        Inventory::updateOrCreate(
            [
                'internal_product_id' => $product->id,
                'warehouse_id'        => $warehouseId,
            ],
            [
                'quantity'   => max(0, $quantity),
                'updated_by' => Auth::guard('worker')->id(),
            ]
        );
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'naziv'              => 'required|string|max:255',
            'jedinica'           => 'required|string|max:50',
            'cena_rsd'           => 'required|numeric|min:0',
            'nizak_limit_zaliha' => 'nullable|integer|min:0',
            'stanje'             => 'nullable|numeric|min:0',
        ];
    }

    /**
     * @return array
     */
    public function customValidationMessages()
    {
        return [
            'naziv.required'    => 'Naziv materijala je obavezan.',
            'jedinica.required' => 'Jedinica mere je obavezna.',
            'cena_rsd.required' => 'Cena je obavezna.',
            'cena_rsd.numeric'  => 'Cena mora biti broj.',
            'cena_rsd.min'      => 'Cena ne može biti negativna.',
            'stanje.numeric'    => 'Stanje mora biti broj.',
            'stanje.min'        => 'Stanje ne može biti negativno.',
        ];
    }
}

