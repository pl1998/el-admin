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

namespace Latent\ElAdmin\Traits;

use Illuminate\Http\JsonResponse;
use Latent\ElAdmin\Enum\Status;

trait Response
{
    public int $code;

    public null|int $status;

    public null|string $message;

    public $data;

    /**
     * @return $this
     */
    public function withHttpCode(int $code = Status::SUCCESS_STATUS): static
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return $this
     */
    public function withStatus(int $status = Status::SUCCESS_STATUS): static
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return $this
     */
    public function setMessage(string $message): static
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return $this
     */
    public function setData(array $data): static
    {
        $this->data = $data;

        return $this;
    }

    /**
     * success response.
     */
    public function success($data = [], string $message = 'success', int $status = Status::SUCCESS_STATUS): JsonResponse
    {
        return response()->json([
            'data' => $this->data ?? $data,
            'message' => $this->message ?? $message,
            'status' => $this->status ?? $status,
        ]);
    }

    /**
     * fail response.
     */
    public function fail(string $message = 'error', int $status = Status::FAIL_STATUS, $data = [], int $code = Status::SUCCESS_STATUS): JsonResponse
    {
        return response()->json([
            'data' => $this->data ?? $data,
            'message' => $this->message ?? $message,
            'status' => $this->status ?? $status,
        ], $code);
    }
}
