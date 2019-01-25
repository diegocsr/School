<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = ['image', 'name', 'image_thumbnail', 'album_id'];

    public function album() {
        return $this->belongsTo(Album::class);
    }
}
