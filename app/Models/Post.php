<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'type',
        'post',
        'photo',
        'video',
        'user_id',
        'active',
    ];

    public function users()
    {
        return $this->belongsTo(Family::class);
    }
}

