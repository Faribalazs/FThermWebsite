<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ponuda extends Model
{
    protected $table = 'ponude';

    protected $fillable = [
        'worker_id',
        'client_type',
        'client_name',
        'client_address',
        'company_name',
        'pib',
        'maticni_broj',
        'company_address',
        'client_phone',
        'client_email',
        'location',
        'km_to_destination',
        'hourly_rate',
        'total_amount',
        'status',
        'notes',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
    ];

    public function worker()
    {
        return $this->belongsTo(User::class, 'worker_id');
    }

    public function sections()
    {
        return $this->hasMany(PonudaSection::class);
    }

    public function calculateTravelCost($kmPrice = 0)
    {
        if ($this->km_to_destination && $kmPrice > 0) {
            return $this->km_to_destination * $kmPrice;
        }
        return 0;
    }

    public function calculateTotal($kmPrice = 0)
    {
        $total = 0;
        foreach ($this->sections as $section) {
            foreach ($section->items as $item) {
                $total += $item->price_at_time * $item->quantity;
            }
            if ($section->service_price) {
                $total += $section->service_price;
            }
            if ($section->hours_spent && $this->hourly_rate) {
                $total += $section->hours_spent * $this->hourly_rate;
            }
        }
        $total += $this->calculateTravelCost($kmPrice);
        return $total;
    }
}
