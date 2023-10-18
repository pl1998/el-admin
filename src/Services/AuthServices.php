<?php

declare(strict_types=1);

namespace Latent\ElAdmin\Services;

use Illuminate\Http\JsonResponse;

class AuthServices
{
    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return JsonResponse
     */
    public function respondWithToken(string $token) :JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => (auth(config('el_admin.guard'))->factory()->getTTL() ?? 0) * 60
        ]);
    }

}
