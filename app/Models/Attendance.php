<?php

namespace App\Models;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isNull;

class Attendance extends Model
{
    protected $fillable = [
        "user_id",
        "date",
    ];
    use HasFactory;
    private $weekDays = [
        "lunes",
        "martes",
        "miercoles",
        "jueves",
        "viernes",
        "sabado",
        "domingo",
    ];
    public function createdAt() : Attribute{
        return Attribute::make(
            get: fn($value) => Carbon::parse($value)->format("Y-m-d\TH:i:s.u\Z"),
        );
    }
    public function updatedAt() : Attribute{
        return Attribute::make(
            get: fn($value) => Carbon::parse($value)->format("Y-m-d\TH:i:s.u\Z")
        );
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function day() : Attribute {
        return Attribute::make(
            set: fn ($value) => $this->weekDays[$value-1]
        );
    }
    public function info(){
        $userAttendances =[];
        $users = $this->select('user_id')->groupBy('user_id')->get();
        foreach($users as $user){
            /** @var User $user **/
            $userObj = User::find($user->user_id);
            $attendance = [
                'uid' => $userObj->id,
                'nameEmployee' => $userObj->full_name,
                'assitance' => $userObj->assistances('2022-02-17')->count(),
                'tardies' => $userObj->tardiness('2022-02-17')->count(),
                'absences' => $userObj->absences('2022-02-17'),
                'schedule' => "ALEPH SECTOR 1",
            ];
            array_push($userAttendances,$attendance);
        }
        return $userAttendances;
    }
    private static function validDays(array $days){
        $validDays = [];
        foreach($days as $day){
            if($day->format('N') !=7){
                $validDays[] = $day;
            }
        }
        return $validDays;
    }
    public static function attendancePerDay(){
        $days = CarbonPeriod::create('2022-01-18', '2022-02-17')->toArray();
        $validDays = self::validDays($days);
        $values = [];
        foreach ($validDays as $date){
            $r = Attendance::select(DB::raw("count(*) as total"))->where('date',$date)->groupBy('date')->first();
            $values[] = $r!=null?$r->total:0;
        }
        return $values;
    }
    public static function tardinessPerDay(){
        $days = CarbonPeriod::create('2022-01-18', '2022-02-17')->toArray();
        $validDays = self::validDays($days);
        $values = [];
        foreach ($validDays as $date){
            $r = Attendance::select(DB::raw("count(*) as total"))->where([['date',$date],['checkin_time','>','09:30']])->groupBy('date')->first();
            $values[] = $r!=null?$r->total:0;
        }
        return $values;
    }
    public static function absencesPerDay(){
        $days = CarbonPeriod::create('2022-01-18', '2022-02-17')->toArray();
        $validDays = self::validDays($days);
        $values = [];
        foreach ($validDays as $date){
            $total_users = User::where('last_name','!=','Farfan')->count();
            $r = Attendance::select(DB::raw("count(*) as total"))->where('date',$date)->groupBy('date')->first();
            error_log('users '. $total_users);
            error_log('asistencias '. $r);
            $values[] = $r!=null?$total_users - $r->total:0;
        }
        return $values;
    }
}
