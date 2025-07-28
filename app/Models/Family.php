<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    protected $fillable  = [
        'national_id',
        'name',
        'birth_date',
        'health_status',
        'academic_level',
        'profession',
        'marriages_count',
        'has_disabilities',
        'disability_family',
        'family_type',
        'has_health_insurance',
        'health_insurance_reason',
        'has_rehabilitation_centers',
        'healthy_adults_count',
        'annual_income',
        'house_ownership',
        'room_count',
        'monthly_rent',
    ];


    public function mothers()
    {
        return $this->hasMany(Mother::class);
    }

    public function familymembers()
    {
        return $this->hasMany(FamilyMember::class);
    }
}
