<?php

namespace App\Repositories;

use App\Exceptions\V1\EmptyAttendanceException;
use App\Imports\TempExcelImport;
use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
class AttendanceRepository
{

    private Attendance $model;
    
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
    private function getUserAttendances(){
        return $this->model->info(Carbon::createFromFormat('Y-m-d','2022-02-17'));
    }
    public function getStatistics($date){
        
        $attendances = $this->getUserAttendances();
        if(count($attendances) == 0){
            throw new EmptyAttendanceException();
        }
        $total_attendances = 0;
        $total_tardinness = 0;
        $total_absences = 0;
        foreach($attendances as $el){
            $total_attendances += $el['assitance'];
            $total_tardinness += $el['tardies'];
            $total_absences += $el['absences'];
        }
        $total = $total_attendances + $total_tardinness + $total_absences;
        $generalData = [
            [
                'title' => "Asistencias",
                'valueMonth' => $total_attendances,
                'percent' => round(($total_attendances /$total) * 100,2),
                'valuesXdays' => $this->model::attendancePerDay()
            ],
            [
                'title' => "Tardanzas",
                'valueMonth' => $total_tardinness,
                'percent' => round(($total_tardinness /$total) * 100,2),
                'valuesXdays' => $this->model::tardinessPerDay(),    
            ],
            [
                'title' => "Faltas",
                'valueMonth' => $total_absences,
                'percent' => round(($total_absences /$total) * 100,2),
                'valuesXdays' => $this->model::absencesPerDay(),    
            ],
        ];
        return [
            "dataAttendance" => $attendances,
            "dataAllStatistic" => $generalData,
            "dateRegister" => [
                "days" => $this->days($date),
            ]
        ];
    }
    private function days($date){
        Carbon::setLocale('es');
        setlocale(LC_ALL, 'es_ES');
        $first_date = Carbon::createFromFormat('Y-m-d',$date)->subMonth();
        $second_date = Carbon::createFromFormat('Y-m-d',$date);
        $days = CarbonPeriod::create($first_date, $second_date)->toArray();
        $daysN = array_map(function($i){
            return $i->formatLocalized('%d %B');
        },$days);
        return $daysN;
    }
}
