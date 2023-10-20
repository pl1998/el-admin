<?php

declare(strict_types=1);

namespace Latent\ElAdmin\Services;

use Illuminate\Http\JsonResponse;
use Latent\ElAdmin\Traits\Response;

class AuthServices
{
    use Response;
    /**
     * Get the token array structure.
     */
    public function respondWithToken(string $token): JsonResponse
    {
        app()->make(LogWriteService::class)->handle();

        return  $this->success([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => (auth(config('el_admin.guard'))->factory()->getTTL() ?? 0) * 60,
        ]);
    }
}
