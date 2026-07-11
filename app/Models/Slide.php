<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Slide extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'image',
        'title',
        'description',
        'button_text',
        'button_link',
        'text_position_x',
        'text_position_y',
        'order',
        'active',
    ];

    protected $casts = [
        'title'       => 'array',
        'description' => 'array',
        'button_text' => 'array',
        'active'      => 'boolean',
    ];

    public function getImageUrlAttribute(): string
    {
        if (! $this->image) {
            return asset('images/ftherm/hero-ftherm-technician-ac-installation.webp');
        }

        return str_starts_with($this->image, 'images/')
            ? asset($this->image)
            : Storage::disk('public')->url($this->image);
    }
}
