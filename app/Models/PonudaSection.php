<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PonudaSection extends Model
{
    protected $fillable = ['ponuda_id', 'title', 'hours_spent', 'service_price'];

    protected $casts = [
        'ponuda_id'     => 'integer',
        'hours_spent'   => 'decimal:2',
        'service_price' => 'decimal:2',
    ];

    public function ponuda()
    {
        return $this->belongsTo(Ponuda::class);
    }

    public function items()
    {
        return $this->hasMany(PonudaItem::class, 'section_id');
    }
}
