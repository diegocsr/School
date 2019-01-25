<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    protected $fillable = ['title', 'description', 'rank', 'slug', 'status', 'name', 'image', 'image_thumbnail'];
};
