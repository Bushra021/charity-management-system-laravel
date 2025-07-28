<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name',
        'user_id',
    ];

    public function providedservices()
    {
        return $this->hasMany(ProvidedService::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
