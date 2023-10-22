<?php

declare(strict_types=1);

namespace Latent\ElAdmin\Traits;

use Illuminate\Http\JsonResponse;
use Latent\ElAdmin\Enum\Http;

trait Response
{
    /** @var int */
    public int $code;

    /** @var int|null  */
    public null|int $status;

    /** @var string|null  */
    public null|string $message;

    /** @var  */
    public  $data ;

    /**
     * @param int $code
     * @return $this
     */
    public function withHttpCode(int $code= Http::SUCCESS_STATUS): static
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @param int $status
     * @return $this
     */
    public function withStatus (int $status= Http::SUCCESS_STATUS): static
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @param string $message
     * @return $this
     */
    public function setMessage( string $message): static
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @param array $data
     * @return $this
     */
    public function setData( array $data): static
    {
        $this->data = $data;
        return $this;
    }

    /**
     * success response.
     *
     * @param  $data
     * @param string $message
     * @param int $status
     * @return JsonResponse
     */
    public function success($data = [], string $message = 'success', int $status = Http::SUCCESS_STATUS) :JsonResponse
    {
        return response()->json([
            'data'    => $this->data ?? $data,
            'message' => $this->message ?? $message,
            'status'  => $this->status ?? $status,
        ]);
    }

    /**
     * fail response.
     *
     * @param string $message
     * @param int $status
     * @param  $data
     * @param int $code
     * @return JsonResponse
     */
    public function fail(string $message = 'error', int $status = Http::FAIL_STATUS ,  $data = [], int $code = Http::SUCCESS_STATUS) :JsonResponse
    {
        return response()->json([
            'data'    => $this->data ?? $data,
            'message' => $this->message ?? $message,
            'status'  => $this->status ?? $status,
        ], $code);
    }
}
