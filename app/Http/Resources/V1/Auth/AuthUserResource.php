<?php

namespace App\Http\Resources\V1\Auth;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public static $wrap = null;
    public function toArray($request)
    {
        return [
            "user" => [
                "id" => $this->id,
                "first_name" => $this->first_name,
                "last_name" => $this->last_name,
                "dni" => $this->dni,
                "email" => $this->email,
                "scopes" => $this->scopes
            ]
        ];
    }
}
