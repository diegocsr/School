<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = ['name', 'nip', 'photo', 'photo_thumbnail', 'course', 'position_id'];

    public function position() {
        return $this->belongsTo(Position::class);
    }
}
