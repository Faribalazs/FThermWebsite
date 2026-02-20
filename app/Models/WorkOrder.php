<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkOrder extends Model
{
    protected $fillable = [
        'worker_id',
        'warehouse_id',
        'client_name',
        'client_address',
        'client_type',
        'company_name',
        'pib',
        'maticni_broj',
        'company_address',
        'client_phone',
        'client_email',
        'location',
        'km_to_destination',
        'status',
        'invoice_type',
        'invoice_number',
        'invoice_company_name',
        'invoice_pib',
        'invoice_address',
        'invoice_email',
        'invoice_phone',
        'total_amount',
        'has_invoice',
        'hourly_rate',
        'efaktura_status',
        'efaktura_response',
        'efaktura_sent_at',
    ];

    protected $casts = [
        'has_invoice' => 'boolean',
        'total_amount' => 'decimal:2',
        'efaktura_sent_at' => 'datetime',
    ];

    public function worker()
    {
        return $this->belongsTo(User::class, 'worker_id');
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function sections()
    {
        return $this->hasMany(WorkOrderSection::class);
    }

    public function calculateMaterialTotal()
    {
        $total = 0;
        foreach ($this->sections as $section) {
            foreach ($section->items as $item) {
                $total += $item->quantity * $item->price_at_time;
            }
        }
        return $total;
    }

    public function calculateServiceTotal()
    {
        $total = 0;
        foreach ($this->sections as $section) {
            if ($section->service_price && $section->service_price > 0) {
                $total += $section->service_price;
            }
        }
        return $total;
    }

    public function calculateTotal()
    {
        return $this->calculateMaterialTotal() + $this->calculateServiceTotal();
    }

    public function calculateTotalHours()
    {
        return $this->sections->sum('hours_spent');
    }

    public function calculateLaborCost()
    {
        if (!$this->hourly_rate) {
            return 0;
        }
        return $this->calculateTotalHours() * $this->hourly_rate;
    }

    public function calculateGrandTotal()
    {
        return $this->calculateTotal() + $this->calculateLaborCost();
    }
}
