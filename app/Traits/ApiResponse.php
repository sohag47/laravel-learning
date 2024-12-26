<?php

namespace App\Traits;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait ApiResponse
{
    
    /**
     * @param $message
     * @param $successCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function jsonResponse($response_data): JsonResponse
    {
        $resource = [
            'success'   => $response_data?->success ?? true,
            'code'      => $response_data?->code ?? Response::HTTP_OK,
            'message'   => $response_data?->message ?? "Item Found Successfully",
            'data'     =>  $response_data?->data ?? null,
            'error'     => $response_data?->error ?? null,
        ];
        return response()->json($resource,  $response_data->code);
    }

    /**
     * @param $message
     * @param $successCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithSuccess($data)
    {
        $response_data = [
            'success'   => true,
            'code'      => Response::HTTP_OK,
            'message'   => "Item Found Successfully",
            'data'     =>  $data,
        ];
        return $this->jsonResponse($response_data);
    }

    protected function respondWithError($code = Response::HTTP_BAD_REQUEST, $message = "", $error = null)
    {
        $response_data = [
            'success'   => false,
            'code'      => $code,
            'message'   => $message,
            'error'     => $error,  
        ];
        return $this->jsonResponse($response_data);
    }
}