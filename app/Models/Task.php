<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        "task",
        "authorization_id",
    ];

    public function authorization(){
        return $this->belongsTo(Authorization::class,"authorzation_id","id");
    }
}
