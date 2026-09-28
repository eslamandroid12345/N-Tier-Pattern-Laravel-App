<?php

namespace App\Architecture\Responder;
use App\Helpers\Http;
use Exception;
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

            return [
                'success' => true,
                'message' => $message ?? 'Data Get Successfully.',
                'code' => Http::OK,
                'data' =>  $is_paginate ? $records->response()->getData(true) : $records
            ];
        } catch (Exception $e) {

            return $this->apiHttpResponder->sendError(
                message:  $exception_message ?? 'Failed To Load Data (Error!).',
                logs: [
                    'get/get_responder_error',
                    'Failed To Load Data (Error!).',
                    $e
                ]
            );
        }
    }
}
