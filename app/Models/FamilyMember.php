<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FamilyMember extends Model
{
    protected $fillable = [
        'family_id',
        'name',
        'birth_year',
        'relationship',
        'social_status',
        'academic_level',
        'health_status',
        'has_disability',
    ];
    public function family()
    {
        return $this->belongsTo(Family::class);
    }

}
