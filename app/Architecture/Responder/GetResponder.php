<?php

namespace App\Architecture\Responder;
use App\Helpers\Http;
use Exception;
use Illuminate\Support\Facades\Log;
use ReflectionMethod;

class GetResponder implements IGetResponder
{
    public function __construct(
       protected readonly IApiHttpResponder $apiHttpResponder
    )
    {
    }
    public function handle(
        $resource,
        $repository,
        $message = null,
        $exception_message = null,
        $method = 'all',
        $parameters = [],
        $is_instance = false,
        $resource_parameters = [],
        $is_paginate = false,
    )
    {
        try {
            $reflection = new ReflectionMethod($repository, $method);
            $args = [];

            foreach ($reflection->getParameters() as $param) {
                $name = $param->getName();
                $args[] = $parameters[$name] ?? $param->getDefaultValue();
            }

            $executable = $repository->$method(...$args);
            $records = $is_instance ? new $resource($executable, ...$resource_parameters) : $resource::collection($executable);

            $responseData = [
                'success' => true,
                'message' => $message ?? __('messages.data_get'),
                'code' => Http::OK,
                'data' => $records,
            ];
            return $is_paginate ? $records->response()->getData(true) : $responseData;
        } catch (Exception $e) {
            Log::error('CATCH::: '.now() . $e);
//            return $e;
            return $this->apiHttpResponder->sendError(message: $exception_message ?? __('messages.data_get_error'));
        }
    }
}
