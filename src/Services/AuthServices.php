<?php

declare(strict_types=1);

namespace Latent\ElAdmin\Services;

use Illuminate\Http\JsonResponse;

class AuthServices
{
    /**
     * Get the token array structure.
     */
    public function respondWithToken(string $token): JsonResponse
    {
        app()->make(LogWriteService::class)->handle();

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => (auth(config('el_admin.guard'))->factory()->getTTL() ?? 0) * 60,
            'status'     => 200,
            'message'    => 'Success'
        ]);
    }
}
