<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempExcel extends Model
{
    protected $fillable = [
        'full_name',
        'time',
        'state',
        'location',
    ];
    public $timestamps = false;
}
