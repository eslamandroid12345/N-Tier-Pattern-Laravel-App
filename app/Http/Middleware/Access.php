<?php

namespace App\Http\Middleware;

use App\Architecture\Responder\IApiHttpResponder;
use App\Helpers\Http;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Access
{
    public function __construct(
        protected readonly IApiHttpResponder $apiHttpResponder
    ) {}

    public function handle(Request $request, Closure $next, string $section, ...$slugs): Response
    {
        try {
            $user = Auth::user();

            if (! $user || ! $user->role) {
                return $this->apiHttpResponder->sendError(
                    message: 'Unauthorized Access.',
                    code: Http::FORBIDDEN
                );
            }

            $hasPermission = $user->role()
                ->whereHas('permissions', function ($q) use ($section, $slugs) {
                    $q->where('section', $section)
                        ->whereIn('slug', $slugs);
                })
                ->exists();

            if (! $hasPermission) {
                return $this->apiHttpResponder->sendError(
                    message: 'You do not have access to this page.',
                    code: Http::FORBIDDEN
                );
            }

            return $next($request);

        } catch (Exception $e) {
            return $this->apiHttpResponder->sendError(
                message: 'An error occurred while checking permissions.',
                logs: [
                    'permissions/permissions_access_error',
                    'Permission Middleware Exception (Error!).',
                    $e
                ],
            );
        }
    }
}
