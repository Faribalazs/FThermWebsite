<?php

namespace App\Imports;

use App\Models\InternalProduct;
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
        // Check if product already exists by name
        $existingProduct = InternalProduct::where('name', $row['naziv'])->first();
        
        if ($existingProduct) {
            // Update existing product
            $existingProduct->update([
                'unit' => $row['jedinica'],
                'price' => $row['cena_rsd'],
                'low_stock_threshold' => $row['nizak_limit_zaliha'] ?? 10,
            ]);
            return null;
        }
        
        // Create new product
        return new InternalProduct([
            'name' => $row['naziv'],
            'unit' => $row['jedinica'],
            'price' => $row['cena_rsd'],
            'low_stock_threshold' => $row['nizak_limit_zaliha'] ?? 10,
            'created_by' => Auth::guard('worker')->id(),
        ]);
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'naziv' => 'required|string|max:255',
            'jedinica' => 'required|string|max:50',
            'cena_rsd' => 'required|numeric|min:0',
            'nizak_limit_zaliha' => 'nullable|integer|min:0',
        ];
    }

    /**
     * @return array
     */
    public function customValidationMessages()
    {
        return [
            'naziv.required' => 'Naziv materijala je obavezan.',
            'jedinica.required' => 'Jedinica mere je obavezna.',
            'cena_rsd.required' => 'Cena je obavezna.',
            'cena_rsd.numeric' => 'Cena mora biti broj.',
            'cena_rsd.min' => 'Cena ne može biti negativna.',
        ];
    }
}
