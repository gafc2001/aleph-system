<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExtraHour extends Model
{
    protected $fillable = [
        "hours"
    ];
    protected $appends = [
        "tasks"
    ];
    protected function tasks() : Attribute{
        return Attribute::make(
            get: fn($value) => $this->authorization()->first()->tasks()->get(),
        );
    }
    public function authorization(){
        return $this->belongsTo(Authorizations::class,"authorization_id","id");
    }
}
