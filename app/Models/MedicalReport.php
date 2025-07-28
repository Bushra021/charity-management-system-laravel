<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalReport extends Model
{
    protected $fillable = [
        'patient_id',
        'title',
        'content',
        'file_path',
        'is_generated',
        'created_at',
    ];

    // داخل MedicalReport.php
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }


}
