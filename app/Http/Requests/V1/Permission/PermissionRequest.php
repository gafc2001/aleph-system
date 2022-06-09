<?php

namespace App\Http\Requests\V1\Permission;

use App\Enums\FieldWorkEnum;
use App\Enums\PermissionEnum;
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
        return [
            "dateCreate" => 'required|date|date_format:Y-m-d',
            "typeAuthorization" => ['required',new Enum(PermissionEnum::class)],
            "startEvent" => 'required|date_format:H:i',
            "endEvent" => 'required|date_format:H:i|after:startEvent',
            "typeDiscount" => [Rule::requiredIf($request->typeAuthorization == PermissionEnum::PERMISO_PERSONAL->value),
                                'boolean'],
            "quantityHours" => [Rule::requiredIf($request->typeAuthorization == PermissionEnum::SOLICITUD_HORAS_EXTRAS->value),'integer','gte:1'],
            "justification" => [Rule::requiredIf($request->typeAuthorization == PermissionEnum::PERMISO_PERSONAL->value),'string'],
            "typeService" => [Rule::requiredIf($request->typeAuthorization == PermissionEnum::TRABAJO_CAMPO->value),new Enum(FieldWorkEnum::class)],
            "tasks" => [Rule::requiredIf($request->typeAuthorization != PermissionEnum::PERMISO_PERSONAL->value),
                        'array',
                        'min:1'],
            "tasks.*" => "required_with:tasks,string",
            "comments" => "string"
        ];
    }
    public function messages(){
        return [
            "typeAuthorization.Illuminate\Validation\Rules\Enum" => [
                "Tipo de autorizacion invalida [PERMISO_PERSONAL , SOLICITUD_HORAS_EXTRAS , TRABAJO_CAMPO , COMPENSACION]",
            ],
            "typeService.Illuminate\Validation\Rules\Enum" => [
                "Tipo de trabajo campo invalido [OPERATIVA , ADMINISTRATIVA]",
            ]
        ];
    }
}
