<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalPermission extends Model
{
    protected $fillable = [
        "justification"
    ];
    protected $appends = [
        "tasks"
    ];
    public function authorization(){
        return $this->belongsTo(Authorizations::class);
    }
    protected function tasks() : Attribute{
        return Attribute::make(
            get: fn($value) => null
        );
    }
}
