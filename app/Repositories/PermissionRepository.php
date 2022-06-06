<?php 
namespace App\Repositories;

use App\Enums\PermissionEnum;

class PermissionRepository{


    public function createPermission(array $array){
        $data = json_decode(json_encode($array), FALSE);
        switch($data->typeAuthorization){
            case PermissionEnum::PERMISO_PERSONAL->value : return $this->createPersonalPermission($data);
            case PermissionEnum::SOLICITUD_HORAS_EXTRAS->value : return $this->createExtraHoursePermission($data);
            case PermissionEnum::TRABAJO_CAMPO->value : return $this->createFieldWorkPermission($data);
            case PermissionEnum::COMPENSACION->value : return $this->createCompensationsPermission($data);
        }
    }
    private function createPersonalPermission($data){
        return $data;
    }
    private function createExtraHoursePermission($data){
        return $data;
        
    }
    private function createFieldWorkPermission($data){
        return $data;
        
    }
    private function createCompensationsPermission($data){
        return $data;

    }
}