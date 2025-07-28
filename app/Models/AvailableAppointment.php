<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class AvailableAppointment extends Model
{

    protected $fillable = [
        'user_id',
        'service_id',
        'date',
        'start_time',
        'end_time',
        'is_booked',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function appointment()
    {
        return $this->hasOne(Appointment::class, 'available_appointments_id');
    }

}
