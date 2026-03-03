<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GalleryAlbum extends Model
{
    protected $fillable = [
        'title',
        'description',
        'slug',
        'active',
        'order',
    ];

    protected $casts = [
        'title' => 'array',
        'description' => 'array',
        'active' => 'boolean',
    ];

    public function images(): HasMany
    {
        return $this->hasMany(GalleryImage::class, 'album_id')->orderBy('order');
    }
}
