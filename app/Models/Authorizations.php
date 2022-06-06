<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Authorizations extends Model
{
    protected $fillable = [
        'code',
        'date',
        'estimated_start_time',
        'estimated_end_time',
        'reference',
        'state',
        'employee_id'
    ];

    public function employee(){
        return $this->belongsTo(User::class,'employee_id');
    }
    public function autherizedBy(){
        return $this->belongsTo(User::class,'authorized_by');
    }
    public function personalPermission(){
        return $this->hasMany(PersonalPermission::class,'authorization_id');
    }
}
