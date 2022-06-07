<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalPermission extends Model
{
    protected $fillable = [
        "justification"
    ];

    public function authorization(){
        return $this->belongsTo(Authorization::class);
    }
}
