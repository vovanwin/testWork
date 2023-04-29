<?php

declare(strict_types=1);

namespace App\Http\Middleware\Custom;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Closure;
use Illuminate\Http\Request;

/**
 * Для защиты api документации
 *
 * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
 *
 */
class RestrictedDocsAccess
{
    public function handle(Request $request, Closure $next): Closure|Response|JsonResponse
    {
        if (app()->environment('local')) {
            return $next($request);
        }

        if (Gate::allows('viewApiDocs')) {
            return $next($request);
        }

        abort(403);
    }
}
