<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkOrderSection extends Model
{
    protected $fillable = ['work_order_id', 'title', 'hours_spent'];

    public function workOrder()
    {
        return $this->belongsTo(WorkOrder::class);
    }

    public function items()
    {
        return $this->hasMany(WorkOrderItem::class, 'section_id');
    }
}
