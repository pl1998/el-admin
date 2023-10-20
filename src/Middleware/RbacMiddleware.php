<?php

declare(strict_types=1);

namespace Latent\ElAdmin\Middleware;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Closure;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Latent\ElAdmin\Services\LogWriteService;
use Latent\ElAdmin\Services\Permission;
use Latent\ElAdmin\Controller\Response as ApiResponse;

class RbacMiddleware
{
    use Permission;
    use ApiResponse;

    /**
     * @return Response|RedirectResponse|JsonResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $request->path();

        app()->make(LogWriteService::class)->handle();
        return $next($request);
        if ($this->checkApiPermission($request->path(), $request->method())) {
            return $next($request);
        }

        return $this->fail(trans('el_admin.permission_error'), 401);
    }
}
