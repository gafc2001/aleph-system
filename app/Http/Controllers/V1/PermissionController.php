<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Permission\PermissionRequest;
use App\Http\Requests\V1\Permission\UpdateStatePermission;
use App\Http\Resources\V1\Permission\PermissionCollection;
use App\Http\Resources\V1\Permission\PermissionResource;
use App\Repositories\PermissionRepository;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    private PermissionRepository $repository;

    public function __construct(PermissionRepository $repository){
        $this->repository = $repository;
        $this->middleware("auth:api");
        $this->middleware("scope:admin-access")->only(["index","update"]);
        $this->middleware("scope:employee-access")->only(["store","listPermissionsByUser"]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = $this->repository->getAllPermissions();
        return new PermissionCollection($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionRequest $request)
    {
        $id = $request->user()->id;
        $permission = $this->repository->createPermission($request->all(),$id);
        return new PermissionResource($permission);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $permission = $this->repository->getPermissionById($id);
        return new PermissionResource($permission);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStatePermission $request, $id)
    {
        $user_id = $request->user()->id;
        $permission = $this->repository->updatePermissionState($request->all(),$id,$user_id);
        return response()->json([
            "message" => "Se cambio el estado del permiso con id : $id",
            "state" => $permission->state,
            "authorized_by" => [
                "id" => $permission->authorized_by,
                "full_name" => $permission->autherizedBy()->first()->full_name,
            ],
            "update_at" => $permission->updated_at,
        ]);
    }
    public function listPermissionsByUser(Request $request){
        $id = $request->user()->id;
        $permissions = $this->repository->listPermissionsByUser($id);
        return new PermissionCollection($permissions);
    }

}
