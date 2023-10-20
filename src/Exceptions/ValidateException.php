<?php

declare(strict_types=1);

namespace Latent\ElAdmin\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class ValidateException extends Exception
{
    public function __construct($message = '', $code = 200)
    {
        parent::__construct($message, $code);
    }

    public function render(): JsonResponse
    {
        return response()->json(
            [
                'message' => !empty($this->message) ? $this->message : '参数校验失败',
                'status' => 0,
            ],
            !empty($this->code) ? $this->code : 200
        );
    }
}
