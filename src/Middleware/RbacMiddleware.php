<?php

declare(strict_types=1);


namespace Latent\ElAdmin\Middleware;


use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Closure;
use Illuminate\Http\Response;

class RbacMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response|RedirectResponse) $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next): Response|RedirectResponse
    {
        $request->path();


        return $next($request);
    }
}
