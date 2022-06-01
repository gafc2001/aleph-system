<?php

namespace App\Models;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'dni',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected function password() : Attribute{
        return Attribute::make(
            set : fn($value) => Hash::make($value)
        );
    }
    public function attendances(){
        return $this->hasMany(Attendance::class);
    }
    public function assistances(Carbon $date){
        $second_date = $date->format('Y-m-d');
        $first_date = $date->subMonth()->format('Y-m-d');
        return $this->attendances()->whereBetween('date',[$first_date,$second_date]);
    }
    public function tardiness(Carbon $date){
        $range = $this->assistances($date);
        return $range->where('checkin_time','>','09:15');
    }
    public function absences(Carbon $date){
        $second_date = $date;
        $first_date = $date->copy()->subMonth();
        $total_days = 0;
        $days = CarbonPeriod::create($first_date, $second_date)->toArray();
        
        foreach($days as $day){
            if($day->format('N') !=7){
                $total_days++;
            }
        }
        $result = $total_days - $this->assistances($date)->count();
        return $result;
    }

}
