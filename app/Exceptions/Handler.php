<?php

namespace App\Exceptions;

use App\Utils\Toasts;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
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
        $this->renderable(function (AccessDeniedHttpException $e, Request $request) {
            if ($request->method() !== 'GET') {
                Toasts::danger($e->getMessage(), Response::$statusTexts[$e->getStatusCode()]);
                return redirect()->back(Response::HTTP_SEE_OTHER);
            }
        });
    }
}
