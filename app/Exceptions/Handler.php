<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
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

        $this->renderable(function (NotFoundHttpException $e, $request) {
            return response()->json([
                'success' => false,
                'data' => null,
                'code' => Response::HTTP_NOT_FOUND,
                'error' => 'Resource Not Found',
                'message' => 'The requested resource could not be found.'
            ], Response::HTTP_NOT_FOUND);
        });

        $this->renderable(function (MethodNotAllowedHttpException $e, $request) {
            return response()->json([
                'success' => false,
                'code' => Response::HTTP_METHOD_NOT_ALLOWED,
                'data' => null,
                'error' => 'Http Method Not Allowed',
                'message' => 'The HTTP method used is not allowed for this route.'
            ], Response::HTTP_METHOD_NOT_ALLOWED);
        });

    }
}
