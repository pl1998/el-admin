<?php

declare(strict_types=1);

namespace Latent\ElAdmin\Traits;

use Illuminate\Http\JsonResponse;

trait Response
{
    /** @var int  */
    public null|int $code;

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
    public function withHttpCode(int $code=200)
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @param int $status
     * @return $this
     */
    public function withStatus (int $status=200) {
        $this->status = $status;
        return $this;
    }

    /**
     * @param string $message
     * @return $this
     */
    public function setMessage( string $message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @param array $data
     * @return $this
     */
    public function setData( array $data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * success response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function success($data = [], string $message = 'success', int $status = 200) :JsonResponse
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function fail(string $message = 'error', int $status = 0, array|object $data = [], int $code = 200) :JsonResponse
    {
        return response()->json([
            'data'    => $this->data,
            'message' => $this->message ?? $message,
            'status'  => $this->status ?? $status,
        ], $code);
    }
}
