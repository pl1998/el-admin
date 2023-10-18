<?php

declare(strict_types=1);


namespace Latent\ElAdmin\Controller;

trait Response
{
    /**
     * success response
     * @param array|object $data
     * @param string $message
     * @param int $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function success(array|object $data = [],string $message = 'success', int $status = 200)
    {
        return response()->json([
            'data'    => $data,
            'message' => $message,
            'status'  => $status
        ]);
    }


    /**
     * fail response
     * @param string $message
     * @param int $status
     * @param array|object $data
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function fail(string $message = 'error', int $status = 0,array|object $data = [],int $code = 200)
    {
        return response()->json([
            'data'    => $data,
            'message' => $message,
            'status'  => $status
        ],$code);
    }
}
