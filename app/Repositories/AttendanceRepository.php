<?php

namespace App\Repositories;

use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;

class AttendanceRepository
{

    private $model;
    
    public function __construct(Attendance $attendance)
    {
        $this->model = $attendance;
    }
    public function store(array $data)
    {
        foreach ($this->cast($data) as $row) {
            $this->storeRow($row);
        }
    }
    
    private function storeRow($row)
    {
        error_log($row['date_time']->dayOfWeek);
        $attendance = Attendance::firstOrNew(
            [
                'user_id' => $this->getOrCreateUser($row['name']),
                'date' => $row['date'],
            ],[
                'created_at' =>Carbon::now(),
                'updated_at' => Carbon::now(), 
            ]
        );
        $attendance[$row['time_type']] = $row['time'];
        $attendance->day = $row['date_time']->dayOfWeek;
        $attendance->save();
    }
    private function cast($data)
    {
        $castedData = [];
        foreach ($data as $row) {
            $row['date_time'] = Carbon::createFromFormat("m/d/Y H:i:s", $row['date_time']);
            $row['date'] = $row['date_time']->format('Y-m-d');
            $row['time'] = $row['date_time']->format('H:i');
            $row['time_type'] = $this->getTimeType($row['time']);
            $castedData[] = $row;
        }
        return $castedData;
    }
    private function getOrCreateUser($name){
        [$first_name,$last_name] = explode('.', $name);

        $user = User::firstOrCreate(
            ['first_name' => $first_name],
            [
                'last_name' => $last_name,
                'created_at' =>Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        return $user->id;
    }
    private function getTimeType($time)
    {  
        if ($time < "10:00") {
            return "checkin_time";
        }
        if ($time >= "10:01" && $time <= "13:30") {
            return "lunch_time";
        }
        if ($time >= "13:31" && $time <= "14:30") {
            return "lunch_end_time";
        }
        if ($time > "14:30") {
            return "checkout_time";
        }
    }
    

}
