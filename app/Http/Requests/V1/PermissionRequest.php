<?php

namespace App\Http\Requests\V1;

use App\Enums\Permission;
use App\Enums\WorkfieldType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Http\Request;

class PermissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(Request $request)
    {
        error_log("Boolean : ".$request->typeAuthorization != Permission::PERMISO_PERSONAL); 
        return [
            "idUser" => 'required|exists:users,id',
            "dateCreate" => 'required|date|date_format:Y-m-d',
            "department" => 'required',
            "typeAuthorization" => ['required',new Enum(Permission::class)],
            "startEvent" => 'required|date_format:H:i',
            "endEvent" => 'required|date_format:H:i|after:startEvent',
            "typeDiscount" => [Rule::requiredIf($request->typeAuthorization == Permission::PERMISO_PERSONAL->value),
                                'boolean'],
            "quantityHours" => [Rule::requiredIf($request->typeAuthorization == Permission::SOLICITUD_HORAS_EXTRAS->value),'integer','gte:1'],
            "justification" => [Rule::requiredIf($request->typeAuthorization == Permission::PERMISO_PERSONAL->value),'string'],
            "typeService" => [Rule::requiredIf($request->typeAuthorization == Permission::TRABAJO_CAMPO->value),new Enum(WorkfieldType::class)],
            "tasks" => [Rule::requiredIf($request->typeAuthorization != Permission::PERMISO_PERSONAL->value),
                        'array',
                        'min:1'],
            "tasks.*" => "required_with:tasks,string",
            "comments" => "string"
        ];
    }
    public function messages(){
        return [
            "typeAuthorization.enum" => "Tipo de autorizacion invalida"
        ];
    }
}
