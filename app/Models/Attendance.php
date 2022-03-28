<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        "user_id",
        "date",
    ];
    use HasFactory;
    private $day = [
        "lunes",
        "martes",
        "miercoles",
        "jueves",
        "viernes",
        "sabado",
        "domingo",
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function day() : Attribute {
        return Attribute::make(
            set: fn ($value) => $this->day[$value]
        );
    }
}
