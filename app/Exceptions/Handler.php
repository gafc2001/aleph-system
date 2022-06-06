<?php

namespace App\Exceptions;

use App\Exceptions\V1\EmptyAttendanceException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
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
        $this->renderable(function (EmptyAttendanceException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => 'No hay datos de asitencia actualmente'
                ], 404);
            }
        });
        $this->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    "message" => "No existe la ruta especificada",
                    "path" => request()->server()["REQUEST_URI"],
                ], 404);
            }
        });
        $this->renderable(function (MethodNotAllowedHttpException $e, $request) {
            return response()->json([
                "message" => sprintf("El metodo %s no esta soportado para esta ruta",
                            request()->server()["REQUEST_METHOD"]),
                "path" => request()->server()["REQUEST_URI"],
                "supported_methods" => $e->getHeaders()["Allow"],
            ],405);
        });
        
    }
}
