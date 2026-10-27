<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GalleryVideo extends Model
{
    protected $fillable = ['album_id', 'path', 'mime_type', 'caption', 'order'];

    protected $casts = ['album_id' => 'integer', 'order' => 'integer'];

    protected $touches = ['album'];

    public function album(): BelongsTo
    {
        return $this->belongsTo(GalleryAlbum::class, 'album_id');
    }
}
