<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\V1\Attendance\AttendanceStoreRequest;
use App\Http\Requests\V1\Attendance\AttendanceUploadRequest;
use App\Models\Attendance;
use App\Repositories\AttendanceRepository;
use Illuminate\Support\Facades\Storage;

class AttendanceController extends Controller
{
    private $repository;
    public function __construct(AttendanceRepository $repository){
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }


    public function upload(AttendanceUploadRequest $request){
        $file = $request->file('excel');
        $result = $this->repository->uploadExcel($file);
        if(!$result){
            return  response()->json(["message" => "Error al subir el archivo"],400);
        }
        return  response()->json(["message" => "Se subio el archivo correctamente"]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AttendanceStoreRequest $request)
    {
        $response = $this->repository->importExcel($request->data);
        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
