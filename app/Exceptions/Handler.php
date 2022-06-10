<?php

namespace App\Exceptions;

use App\Exceptions\V1\EmptyAttendanceException;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Laravel\Passport\Exceptions\MissingScopeException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
    public function render($request,Throwable $e){
        if ($request->is('api/*')) {
            if($e instanceof EmptyAttendanceException){
                return response()->json([
                    'message' => 'No hay datos de asitencia actualmente'
                ], 404);
            }
            if($e instanceof NotFoundHttpException){
                return response()->json([
                    "message" => "No existe la ruta especificada",
                    "path" => request()->server()["REQUEST_URI"],
                    "ex" => $e instanceof NotFoundHttpException
                ], 404);
            }
            if($e instanceof MethodNotAllowedHttpException){
                return response()->json([
                    "message" => sprintf("El metodo %s no esta soportado para esta ruta",
                                request()->server()["REQUEST_METHOD"]),
                    "path" => request()->server()["REQUEST_URI"],
                    "supported_methods" => $e->getHeaders()["Allow"],
                ],405);
            }
            if($e instanceof ModelNotFoundException){
                return response()->json([
                    "message" => "No se encontro el registro con el ID : ". $e->getIds()[0],
                    "path" => request()->server()["REQUEST_URI"],
                    "model" => $e->getModel()
                ],404);
            }
            if($e instanceof MissingScopeException){
                return response()->json([
                    "message" => "No tienes los permisos suficientes",
                    "path" => request()->server()["REQUEST_URI"],
                ],403);
            }
            return response()->json([
                "message" => $e->getMessage(),
            ],500);
        }
        return response()->json([
            "message" => $e->getTrace()
        ],500);
    }
}
