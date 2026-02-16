<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkOrderItem extends Model
{
    protected $fillable = [
        'section_id',
        'product_id',
        'quantity',
        'price_at_time',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'price_at_time' => 'decimal:2',
    ];

    public function section()
    {
        return $this->belongsTo(WorkOrderSection::class);
    }

    public function product()
    {
        return $this->belongsTo(InternalProduct::class, 'product_id');
    }

    public function getSubtotalAttribute()
    {
        return $this->quantity * $this->price_at_time;
    }
}
