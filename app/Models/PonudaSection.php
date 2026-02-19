<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PonudaSection extends Model
{
    protected $fillable = ['ponuda_id', 'title', 'hours_spent', 'service_price'];

    public function ponuda()
    {
        return $this->belongsTo(Ponuda::class);
    }

    public function items()
    {
        return $this->hasMany(PonudaItem::class, 'section_id');
    }
}
