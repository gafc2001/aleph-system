<?php

namespace App\Http\Resources\V1\Permission;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PermissionCollection extends ResourceCollection
{

    public $collects = PermissionResource::class;

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
