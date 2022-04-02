<?php

namespace App\Http\Requests\V1\Attendance;

use App\Rules\IsAssociative;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class AttendanceStoreRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        
        return [
            "data" => ["required",new IsAssociative(),"array","max:20"],
            "data.*.id" => "required|integer|min:1",
            "data.*.name" => "required|string",
            "data.*.date_time" => "required|date|date_format:m/d/Y H:i:s",
        ];
    }
}
