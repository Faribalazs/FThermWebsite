<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InternalProduct extends Model
{
    protected $fillable = ['name', 'unit', 'price', 'low_stock_threshold', 'created_by'];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function inventory()
    {
        return $this->hasOne(Inventory::class, 'internal_product_id');
    }

    public function inventories()
    {
        return $this->hasMany(Inventory::class, 'internal_product_id');
    }
}
