<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable = ['internal_product_id', 'quantity', 'updated_by'];

    public function product()
    {
        return $this->belongsTo(InternalProduct::class, 'internal_product_id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
