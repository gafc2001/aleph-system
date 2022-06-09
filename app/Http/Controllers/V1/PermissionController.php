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
        return $this->repository->createPermission($request->all(),$id);
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
        $permission = $this->repository->updatePermissionState($request->all(),$id);
        return response()->json([
            "message" => "Se cambio el estado del permiso con id : $id",
            "state" => $permission->state,
            "update_at" => $permission->updated_at,
        ]);
    }
    public function listPermissionsByUser(Request $request){
        $id = $request->user()->id;
        $permissions = $this->repository->listPermissionsByUser($id);
        return new PermissionCollection($permissions);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
