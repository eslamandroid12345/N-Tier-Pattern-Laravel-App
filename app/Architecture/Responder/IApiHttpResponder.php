<?php

namespace App\Architecture\Responder;

use App\Helpers\Http;
use Symfony\Component\HttpFoundation\Response;

interface IApiHttpResponder
{
    public function sendSuccess($data = null, $message = 'Data Get Successfully',int $code = Response::HTTP_OK): mixed;
    public function sendError(string $message,$logs,int $code = Http::INTERNAL_SERVER_ERROR): mixed;
    public function sendValidationError($message);
}
