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
        $result = $this->repository->getStatistics('2022-02-17');
        return response()->json([
            "data" => $result
        ]);
    }
    public function upload(AttendanceUploadRequest $request){
        $file = $request->file('excel');
        $result = $this->repository->uploadExcel($file);
        if(!$result){
            return  response()->json(["message" => "Error al subir el archivo"],400);
        }
        $this->repository->importExcel($file->hashName());
        return  response()->json(["message" => "Se subio el archivo correctamente"]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $response = $this->repository->importExcel('1AXVYnnaGZzPHWXlUsmRaWSt5SCLZdY19Ad7wMAf.xls');
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
