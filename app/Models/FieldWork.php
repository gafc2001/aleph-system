<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FieldWork extends Model
{
    protected $fillable = [
        "type"
    ];
    protected $appends = [
        "tasks"
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
    protected function tasks() : Attribute{
        return Attribute::make(
            get: fn($value) => $this->authorization()
                    ->first()
                    ->tasks()
                    ->get()
                    ->map(fn($e) => $e->task),
        );
    }
    public function authorization(){
        return $this->belongsTo(Authorizations::class,"authorization_id","id");
    }
}
