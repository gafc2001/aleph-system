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
    protected $appends = [
        "tasks"
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
    public function scopes() : Attribute{
        return Attribute::make(
            get : fn($value) => $this->department()->first()->name == "Administracion"?"admin-access":"employee-access"
        );
    }

    //Relationships
    public function attendances(){
        return $this->hasMany(Attendance::class);
    }
    public function authorizations(){
        return $this->hasMany(Authorizations::class,'employee_id');
    }
    public function department(){
        return $this->belongsTo(Department::class,"department_id");
    }

    
    public function assistances($date){
        $second_date = Carbon::createFromFormat('Y-m-d',$date);
        $first_date = Carbon::createFromFormat('Y-m-d',$date)->subMonth();
        return $this->attendances()->whereBetween('date',[$first_date,$second_date]);
    }
    public function tardiness($date){
        $range = $this->assistances($date);
        return $range->where('checkin_time','>','09:15');
    }
    public function absences($date){
        $second_date = Carbon::createFromFormat('Y-m-d',$date);
        $first_date = Carbon::createFromFormat('Y-m-d',$date)->subMonth();
        $total_days = 0;
        $days = CarbonPeriod::create($first_date, $second_date)->toArray();
        
        foreach($days as $day){
            if($day->format('N') !=7){
                $total_days++;
            }
        }
        error_log('asistencias'.$this->assistances($date)->count());
        error_log('total'.$total_days);
        $result = $total_days - $this->assistances($date)->count();
        return $result;
    }
    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->first_name." ".$this->last_name,
        );
        
    }

}
