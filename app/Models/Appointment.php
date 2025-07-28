<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'status',
        'patient_id',
        'service_id',
        'available_appointments_id',
        'date',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function availableAppointment()
    {
        return $this->belongsTo(AvailableAppointment::class, 'available_appointments_id');
    }



}
