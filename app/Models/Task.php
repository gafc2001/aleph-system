<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        "task",
        "authorization_id",
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
    public function authorization(){
        return $this->belongsTo(Authorization::class,"authorzation_id","id");
    }
}
