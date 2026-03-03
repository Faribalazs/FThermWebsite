<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
}
