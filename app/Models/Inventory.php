<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable = ['internal_product_id', 'warehouse_id', 'quantity', 'updated_by'];

    public function product()
    {
        return $this->belongsTo(InternalProduct::class, 'internal_product_id');
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
