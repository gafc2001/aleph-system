<?php

namespace App\Repositories;

use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class AttendanceRepository
{

    private $model;
    
    public function __construct(Attendance $attendance)
    {
        $this->model = $attendance;
    }
    public function uploadExcel($file){
        return Storage::disk('public')->put('temp/',$file);
    }

    public function importExcel($filename){
        
    }


    
    

}
