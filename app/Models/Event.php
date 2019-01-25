<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['title', 'body', 'photo', 'slug','photo_thumbnail', 'status','category_id'];

    public function category() {
        return $this->belongsTo(Category::class);
    }
}
