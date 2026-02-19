<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PonudaItem extends Model
{
    protected $fillable = ['section_id', 'product_id', 'quantity', 'price_at_time'];

    public function section()
    {
        return $this->belongsTo(PonudaSection::class, 'section_id');
    }

    public function product()
    {
        return $this->belongsTo(InternalProduct::class, 'product_id');
    }
}
