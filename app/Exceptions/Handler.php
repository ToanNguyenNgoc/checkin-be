<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use Throwable;

class Handler extends ExceptionHandler
{
    use ApiResponser;

    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function(MethodNotAllowedHttpException $e, Request $request){
            if($request->expectsJson()){
                $msgError = ['message' => '405 The GET method is not supported for this route. Supported methods: POST.'];
                return $this->responseError($msgError, 405);
            }
        });

        /* 401 message */
        $this->renderable(function(AuthenticationException $e, Request $request){
            if($request->expectsJson()){
                $msgError = ['message' => '401 This action is unauthorized'];
                return $this->responseError($msgError, 401);
            }
        });

        /* 400 message */
        $this->renderable(function(NotFoundHttpException $e, Request $request){
            if($request->expectsJson()){
                $msgError = ['message' => '400 Page Not Found'];
                return $this->responseError($msgError, 400);
            }
        });

        /* 404 message */
        $this->renderable(function(NotFoundHttpException $e, Request $request){
            if($request->expectsJson()){
                $msgError = ['message' => '404 Page Not Found'];
                return $this->responseError($msgError, 404);
            }
        });

        /* 429 message */
        $this->renderable(function(ThrottleRequestsException $e, Request $request){
            if($request->expectsJson()){
                $msgError = ['message' => '429 Too Many Attempts'];
                return $this->responseError($msgError, 429);
            }
        });

        /* 500 message */
        $this->renderable(function(QueryException $e, Request $request){
            if($request->expectsJson()){
                $msgError = ['message' => '500 Internal Server Error'];
                return $this->responseError($msgError, 500);
            }
        });
    }
}
