<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tool extends Model
{
    protected $fillable = [
        'name',
        'price',
    ];
    public function user()
    {
        return $this->hasMany(User::class);
    }
    public function attachment()
    {
        return $this->belongsTo(Attachment::class);
    }

}
