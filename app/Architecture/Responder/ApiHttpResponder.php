<?php

namespace App\Architecture\Responder;

use App\Helpers\Http;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
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

    public function sendError(string $message,$logs,int $code = Http::INTERNAL_SERVER_ERROR): JsonResponse
    {
        $fileName = $logs[0].'-' . now()->format('Y-m-d') . '.log';

        $logMessage =
            $logs[1] . PHP_EOL .
            "========================================" . PHP_EOL .
            "Exception: " . get_class($logs[2]) . PHP_EOL .
            "Message:" . PHP_EOL .
            $logs[2]->getMessage() . PHP_EOL .
            "File: " . $logs[2]->getFile() . PHP_EOL .
            "Line: " . $logs[2]->getLine() . PHP_EOL .
            "========================================";

        Log::build([
            'driver' => 'single',
            'path'   => storage_path('logs/' . $fileName),
        ])->error($logMessage);

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
