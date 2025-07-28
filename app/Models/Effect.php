<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Effect extends Model
{
    protected $fillable = [
        'patient_id',
        'health_physical',
        'health_mental',
        'health_psychological',
        'education',
        'marital_life',
        'social_activities',
        'social_skills',
        'self_management',
        'family_relationship',
        'work',
        'financial_independence',
        'public_life',
    ];

    public function patient()
    {
        return $this->hasOne(Patient::class);
    }
    public function healthPhysicalGrade()
    {
        return $this->belongsTo(Grade::class, 'health_physical');
    }

    public function healthMentalGrade()
    {
        return $this->belongsTo(Grade::class, 'health_mental');
    }

    public function healthPsychologicalGrade()
    {
        return $this->belongsTo(Grade::class, 'health_psychological');
    }

    public function educationGrade()
    {
        return $this->belongsTo(Grade::class, 'education');
    }

    public function maritalLifeGrade()
    {
        return $this->belongsTo(Grade::class, 'marital_life');
    }

    public function socialActivitiesGrade()
    {
        return $this->belongsTo(Grade::class, 'social_activities');
    }

    public function socialSkillsGrade()
    {
        return $this->belongsTo(Grade::class, 'social_skills');
    }

    public function selfManagementGrade()
    {
        return $this->belongsTo(Grade::class, 'self_management');
    }

    public function familyRelationshipGrade()
    {
        return $this->belongsTo(Grade::class, 'family_relationship');
    }

    public function workGrade()
    {
        return $this->belongsTo(Grade::class, 'work');
    }

    public function financialIndependenceGrade()
    {
        return $this->belongsTo(Grade::class, 'financial_independence');
    }

    public function publicLifeGrade()
    {
        return $this->belongsTo(Grade::class, 'public_life');
    }


}
