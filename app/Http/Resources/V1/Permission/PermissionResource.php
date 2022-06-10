<?php

namespace App\Http\Resources\V1\Permission;

use Illuminate\Http\Resources\Json\JsonResource;

class PermissionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "permission_code" => $this->code,
            "permission_date" => $this->date,
            "estimated_start_time" => $this->estimated_start_time,
            "estimated_end_time" => $this->estimated_end_time,
            "real_start_time" => $this->real_start_time,
            "real_end_time" => $this->real_end_time,
            "comments" => $this->comments,
            "reference" => $this->reference,
            "permission_detail" => $this->permission()->first()->makeHidden(["created_at","updated_at"],),
            "state" => $this->state,
            "authorized_by" => is_null($this->authorized_by) ? "Sin auntorizacion" : $this->autherizedBy()->first()->fullName,
            "employee_id" => $this->employee()->first()->fullName,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }
}
