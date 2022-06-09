<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compesation extends Model
{
    protected $appends = [
        "tasks"
    ];    
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
