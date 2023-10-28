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

namespace Latent\ElAdmin\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Latent\ElAdmin\Enum\Status;

class ValidateException extends Exception
{
    public function __construct($message = '', $code = Status::SUCCESS_STATUS)
    {
        parent::__construct($message, $code);
    }

    public function render(): JsonResponse
    {
        return response()->json(
            [
                'message' => ! empty($this->message) ? $this->message : '参数校验失败',
                'status' => Status::FAIL_STATUS,
            ],
            ! empty($this->code) ? $this->code : Status::SUCCESS_STATUS
        );
    }
}
