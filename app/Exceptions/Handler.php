<?php

namespace App\Exceptions;

use App\Traits\ApiResponse;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;

use Throwable;

class Handler extends ExceptionHandler
{
    use ApiResponse;
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
        // Handle NotFoundHttpException (404)
        $this->renderable(function (NotFoundHttpException $e, $request) {
            // return $this->errorResponse(
            //     Response::HTTP_NOT_FOUND, 
            //     'Resource Not Found', 
            //     'The requested resource could not be found.'
            // );
            return $this->respondWithError(Response::HTTP_NOT_FOUND, 'Resource Not Found', 'The requested resource could not be found.');
        });

        // Handle MethodNotAllowedHttpException (405)
        $this->renderable(function (MethodNotAllowedHttpException $e, $request) {
            return $this->errorResponse(
                Response::HTTP_METHOD_NOT_ALLOWED, 
                'Http Method Not Allowed', 
                'The HTTP method used is not allowed for this route.'
            );
        });

        // Handle UnauthorizedHttpException (401)
        $this->renderable(function (UnauthorizedHttpException $e, $request) {
            return $this->errorResponse(
                Response::HTTP_UNAUTHORIZED, 
                'Unauthorized Access', 
                'You are not authorized to access this resource. Please authenticate.'
            );
        });

        // Handle various HTTP error codes
        $this->renderable(function (HttpException $e, $request) {
            // Centralize error handling for 4xx and 5xx errors
            $statusCode = $e->getStatusCode();
            
            // Handle common errors in a consistent way
            switch ($statusCode) {
                case Response::HTTP_INTERNAL_SERVER_ERROR:
                    return $this->errorResponse(
                        Response::HTTP_INTERNAL_SERVER_ERROR,
                        'Internal Server Error',
                        'An unexpected error occurred on the server. Please try again later.'
                    );
                case Response::HTTP_FORBIDDEN:
                    return $this->errorResponse(
                        Response::HTTP_FORBIDDEN,
                        'Forbidden',
                        'You do not have permission to access this resource.'
                    );
                case Response::HTTP_UNPROCESSABLE_ENTITY:
                    return $this->errorResponse(
                        Response::HTTP_UNPROCESSABLE_ENTITY,
                        'Validation Error',
                        'The given data was invalid.'
                    );
                case Response::HTTP_TOO_MANY_REQUESTS:
                    return $this->errorResponse(
                        Response::HTTP_TOO_MANY_REQUESTS,
                        'Too Many Requests',
                        'You have sent too many requests. Please try again later.'
                    );
                case Response::HTTP_SERVICE_UNAVAILABLE:
                    return $this->errorResponse(
                        Response::HTTP_SERVICE_UNAVAILABLE,
                        'Service Unavailable',
                        'The server is currently unavailable. Please try again later.'
                    );
                default:
                    // Fallback to parent handler for other cases
                    return parent::render($request, $e);
            }
        });
    }

    /**                      
     * Generates a standard error response format.
     *
     * @param int $code
     * @param string $error
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function errorResponse(int $code, string $error, string $message)
    {
        return response()->json([
            'success' => false,
            'code' => $code,
            'data' => null,
            'error' => $error,
            'message' => $message,
        ], $code);
    }
}
