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
    private $weekDays = [
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
            set: fn ($value) => $this->weekDays[$value-1]
        );
    }
    public function info(){
        $userAttendances =[];
        $users = $this->groupBy('user_id')->get();
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
}
