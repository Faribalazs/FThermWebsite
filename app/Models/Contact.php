<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'created_by',
        'type',
        'client_name',
        'client_address',
        'client_phone',
        'client_email',
        'company_name',
        'pib',
        'maticni_broj',
        'company_address',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the display name for this contact.
     */
    public function getDisplayNameAttribute(): string
    {
        if ($this->type === 'fizicko_lice') {
            return $this->client_name ?? '';
        }
        return $this->company_name ?? '';
    }
}
