<?php

declare(strict_types=1);

namespace Latent\ElAdmin\Traits;

use Illuminate\Http\JsonResponse;
use Latent\ElAdmin\Enum\Http;

trait Response
{
    public int $code;

    public null|int $status;

    public null|string $message;

    public $data;

    /**
     * @return $this
     */
    public function withHttpCode(int $code = Http::SUCCESS_STATUS): static
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return $this
     */
    public function withStatus(int $status = Http::SUCCESS_STATUS): static
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
    public function success($data = [], string $message = 'success', int $status = Http::SUCCESS_STATUS): JsonResponse
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
    public function fail(string $message = 'error', int $status = Http::FAIL_STATUS, $data = [], int $code = Http::SUCCESS_STATUS): JsonResponse
    {
        return response()->json([
            'data' => $this->data ?? $data,
            'message' => $this->message ?? $message,
            'status' => $this->status ?? $status,
        ], $code);
    }
}
