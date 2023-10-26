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
        app()->make(config('el_admin.log_class'))->handle();

        return $this->success([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => (auth(config('el_admin.guard'))->factory()->getTTL() ?? 0) * 60,
        ]);
    }
}
