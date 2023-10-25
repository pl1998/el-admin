<?php

declare(strict_types=1);

namespace Latent\ElAdmin\Middleware;

use Closure;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Latent\ElAdmin\Enum\Status;
use Latent\ElAdmin\Services\Permission;
use Latent\ElAdmin\Traits\Response as ApiResponse;
use Psr\SimpleCache\InvalidArgumentException;

class RbacMiddleware
{
    use Permission;
    use ApiResponse;


    /**
     * @param Request $request
     * @param Closure $next
     * @return JsonResponse|mixed
     * @throws BindingResolutionException
     * @throws InvalidArgumentException
     */
    public function handle(Request $request, Closure $next): mixed
    {
        app()->make(config('el_admin.log_class'))->handle();
        if ($this->checkApiPermission($request->route()->uri, $request->method(), $request->route()->action['as'])) {
            return $next($request);
        }

        return $this->fail(trans('el_admin.permission_error'), Status::PREM_STATUS);
    }
}
