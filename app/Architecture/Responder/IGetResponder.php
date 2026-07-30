<?php

namespace App\Architecture\Responder;
interface IGetResponder
{
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
    );

}
