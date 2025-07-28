<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        'mother_id',
        'user_id',
        'disability_type_id',
        'disability_cause_id',
        'note_id',
        'national_id',
        'name',
        'birth_date',
        'social_status',
        'injury_date',
        'toilet_facilities',
        'water_source',
        'electricity_source',
        'family_order',
        'relationship_to_head',
        'disabled_person_residence',
        'education_reason',
        'education_type',
        'unwra_card_number',
        'employment_type',
        'job_type',
        'employment_method',
        'vocational_training',
        'social_case_responsible',
        'disability_union_responsible',
        'employment_status',
        'refugee_status',
        'education_status',
        'training_location',
        'training_type',
        'social_case_responsible_relation',
        'permanent_disability_percentage',
        'phone_number',
        'fax_number',
        'self_dependence_level',
        'monthly_income',
    ];


    public function disabilityCause()
    {
        return $this->belongsTo(DisabilityCause::class);
    }

    public function disabilityType()
    {
        return $this->belongsTo(DisabilityType::class);
    }

    public function mother()
    {
        return $this->belongsTo(Mother::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    public function effect()
    {
        return $this->hasOne(Effect::class);
    }

    public function providedServices()
    {
        return $this->hasMany(ProvidedService::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function medicalReports()
    {
        return $this->hasMany(MedicalReport::class);
    }

}









