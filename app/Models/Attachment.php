<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class  Attachment extends Model
{
    protected $fillable = [
        'patient_id',
        'tool_id',
        'assigned_at',
        'source',
        'price',
        'exemption_value',
        'received',
        'needed',
    ];

    public function patients(){
        return $this->hasMany(Patient::class);
    }
    public function tool(){
        return $this->belongsTo(Tool::class,'tool_id');
    }

}
