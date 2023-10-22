<?php

declare(strict_types=1);

namespace Latent\ElAdmin\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Latent\ElAdmin\Enum\Http;

class ValidateException extends Exception
{
    /**
     * @param $message
     * @param $code
     */
    public function __construct($message = '', $code = Http::SUCCESS_STATUS)
    {
        parent::__construct($message, $code);
    }

    /**
     * @return JsonResponse
     */
    public function render(): JsonResponse
    {
        return response()->json(
            [
                'message' => !empty($this->message) ? $this->message : '参数校验失败',
                'status' => Http::FAIL_STATUS,
            ],
            !empty($this->code) ? $this->code : Http::SUCCESS_STATUS
        );
    }
}
