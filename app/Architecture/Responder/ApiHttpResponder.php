<?php

namespace App\Architecture\Responder;

use App\Helpers\Http;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ApiHttpResponder implements IApiHttpResponder
{
    public function sendSuccess($data = null,$message = 'Data Get Successfully', int $code = Response::HTTP_OK): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'code' => $code,
            'data' => $data
        ], $code);
    }

    public function sendError(string $message,int $code = Http::INTERNAL_SERVER_ERROR): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'error' => [
                'code' => $code,
            ]
        ], $code);
    }

    public function sendValidationError($message): JsonResponse
    {
        return response()->json([
            'message' =>  $message,
            'errors' =>  [
                'status' =>  [
                    $message
                ]
            ]
        ],Http::UNPROCESSABLE_ENTITY);
    }
}
