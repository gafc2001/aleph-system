<?php

namespace App\Repositories;

use App\Imports\TempExcelImport;
use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
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
        Excel::import(new TempExcelImport,"assets/temp/$filename");
        return true;
    }


    
    

}
