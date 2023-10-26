<?php

declare(strict_types=1);

/*
 * This file is part of the latent/el-admin.
 *
 * (c) latent<pltrueover@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

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
     * @return JsonResponse|mixed
     *
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
