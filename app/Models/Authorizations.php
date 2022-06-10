<?php

namespace App\Models;

use App\Enums\PermissionEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

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

    protected $dates = [
        "created_at",
        "updated_at",
    ];
    public function createdAt() : Attribute{
        return Attribute::make(
            get: fn($value) => Carbon::parse($value)->format("Y-m-d\TH:i:s.u\Z"),
        );
    }
    public function updatedAt() : Attribute{
        return Attribute::make(
            get: fn($value) => Carbon::parse($value)->format("Y-m-d\TH:i:s.u\Z")
        );
    }

    public function employee(){
        return $this->belongsTo(User::class,'employee_id');
    }
    public function autherizedBy(){
        return $this->belongsTo(User::class,'authorized_by');
    }
    public function permission(){
        switch ($this->reference){
            case PermissionEnum::PERMISO_PERSONAL->value: return $this->hasMany(PersonalPermission::class,'authorization_id');
            case PermissionEnum::SOLICITUD_HORAS_EXTRAS->value: return $this->hasMany(ExtraHour::class,'authorization_id');
            case PermissionEnum::TRABAJO_CAMPO->value: return $this->hasMany(FieldWork::class,'authorization_id');
            case PermissionEnum::COMPENSACION->value: return $this->hasMany(Compesation::class,'authorization_id');
        }
    }
    public function tasks(){
        if($this->references != PermissionEnum::PERMISO_PERSONAL->value){
            return $this->hasMany(Task::class,"authorization_id","id");
        }
        return null;
    }
}
