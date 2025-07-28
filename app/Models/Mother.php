<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mother extends Model
{
    protected $fillable = [
        'family_id',
        'name',
        'birth_date',
        'health_status',
        'academic_level',
        'profession',
        'marriages_count',
        'national_id',
        'relationship_with_father',
        'has_disabilities',
        'had_diseases_during_pregnancy',
        'had_accidents_during_pregnancy',
        'smoked_during_pregnancy',
        'visited_doctor_during_pregnancy',
        'disability_family',
    ];
    public function family()
    {
        return $this->belongsTo(Family::class);
    }
    public function patients()
    {
        return $this->hasMany(Patient::class);
    }


}
