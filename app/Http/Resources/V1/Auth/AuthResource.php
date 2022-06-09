<?php

namespace App\Http\Resources\V1\Auth;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $access = $this->department()->first()->name == "Administracion"?"admin-access":"employee-access";
        $credentials = $this->createToken($this->id,[$access]);
        return [
            "message" => "Success",
            'data' => [
                "id" => $this->id,
                "first_name" => $this->first_name,
                "last_name" => $this->last_name,
                "dni" => $this->dni,
                "email" => $this->email,
            ],
            "access" => [
                "token_type" => "Bearer",
                "token" => $credentials->accessToken,
                "client_id" => $credentials->token->client_id,
                "expires_at" => $credentials->token->expires_at,
                "scopes" => $access,
            ],
        ];
    }
    public function withResponse($request,$response){
        $response->setStatusCode($response::HTTP_OK);
    }
}
