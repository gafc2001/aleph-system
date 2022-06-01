<?php

namespace App\Imports;

use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;

use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\OnEachRow;

class TempExcelImport implements WithHeadingRow,OnEachRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function onRow(Row $row){
        $row = $row->toCollection();
        $data = $this->cast($row);
        $this->storeRow($data);
    }
    private function storeRow($row)
    {
        $attendance = Attendance::firstOrNew(
            [
                'user_id' => $this->getOrCreateUser($row['nombre']),
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
    private function cast($row)
    {  
        $row['date_time'] = Carbon::createFromFormat("m/d/Y H:i:s", $row['tiempo']);
        $row['date'] = $row['date_time']->format('Y-m-d');
        $row['time'] = $row['date_time']->format('H:i');
        $row['time_type'] = $this->getTimeType($row['time']);
        return $row;
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
        // if ($time >= "14:31") {
            return "checkout_time";
        // }
    }
}
