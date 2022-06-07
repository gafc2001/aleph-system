<?php 
namespace App\Repositories;

use App\Enums\PermissionEnum;
use App\Models\Authorizations;
use App\Models\Compesation;
use App\Models\ExtraHour;
use App\Models\FieldWork;
use App\Models\PersonalPermission;
use Exception;
use Illuminate\Support\Facades\DB;

class PermissionRepository{


    public function createPermission(array $array,$user_id){
        $data = json_decode(json_encode($array), FALSE);
        switch($data->typeAuthorization){
            case PermissionEnum::PERMISO_PERSONAL->value : return $this->createPersonalPermission($data,$user_id);
            case PermissionEnum::SOLICITUD_HORAS_EXTRAS->value : return $this->createExtraHoursePermission($data,$user_id);
            case PermissionEnum::TRABAJO_CAMPO->value : return $this->createFieldWorkPermission($data,$user_id);
            case PermissionEnum::COMPENSACION->value : return $this->createCompensationsPermission($data,$user_id);
        }
    }
    private function createPersonalPermission($data,$id){
        try{
            DB::beginTransaction();
            $authorization = $this->createGeneralAuthorization($data,PermissionEnum::PERMISO_PERSONAL,$id);
            $personaPermission = new PersonalPermission([
                "justification" => $data->justification
            ]); 
            $authorization->permission()->save($personaPermission);
            DB::commit();
            return $authorization;
        }catch(Exception $e){
            DB::rollback();
            return $e->getMessage();
        }
        
    }
    private function createExtraHoursePermission($data,$user_id){
        try{
            DB::beginTransaction();
            $authorization = $this->createGeneralAuthorization($data,PermissionEnum::SOLICITUD_HORAS_EXTRAS,$user_id);
            $extraHour = new ExtraHour([
                "hours" => $data->quantityHours
            ]);
            $authorization->permission()->save($extraHour);
            DB::commit();
            return $authorization;
        }catch(Exception $e){
            DB::rollback();
            return $e->getMessage();
        }
    }
    private function createFieldWorkPermission($data,$user_id){
        try{
            DB::beginTransaction();
            $authorization = $this->createGeneralAuthorization($data,PermissionEnum::TRABAJO_CAMPO,$user_id);
            $fieldWork = new FieldWork([
                "type" => $data->typeService,
            ]);
            $authorization->permission()->save($fieldWork);
            DB::commit();
            return $authorization;
        }catch(Exception $e){
            DB::rollback();
            return $e->getMessage();
        }
    }
    private function createCompensationsPermission($data,$user_id){
        try{
            DB::beginTransaction();
            $authorization = $this->createGeneralAuthorization($data,PermissionEnum::COMPENSACION,$user_id);
            $compesation = new Compesation();
            DB::commit();
            return $authorization->permission()->save($compesation);
        }catch(Exception $e){
            DB::rollback();
            return $e->getMessage();
        }

    }
    private function createGeneralAuthorization($data,PermissionEnum $reference,$id) : Authorizations{
        $authorization = Authorizations::create([
            'code' => generateCode(),
            'date' => $data->dateCreate,
            'estimated_start_time' => $data->startEvent,
            'estimated_end_time' => $data->endEvent,
            'reference' => $reference->value,
            'employee_id' => $id
        ]);
        if(!is_null($data->comments)){
            $authorization->comments = $data->comments;
            $authorization->save();
        }
        return $authorization;
    }
}