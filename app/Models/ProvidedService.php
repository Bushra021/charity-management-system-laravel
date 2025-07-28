<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProvidedService extends Model
{
    protected $fillable = [
        'service_id',
        'patient_id',
        'received',
        'needed',
        'status',
        'end_date',
        'start_date',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
    public function patient(){
        return $this->belongsTo(Patient::class);
    }
}
