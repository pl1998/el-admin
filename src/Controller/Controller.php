<?php

declare(strict_types=1);


namespace Latent\ElAdmin\Controller;


use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, Response;

    /**
     * check params
     * @param array $rule
     * @param array $params
     * @param array $message
     * @return JsonResponse|string|array|null
     */
    public function validator(array $rules, array $params =[], array $message=[]): JsonResponse|string|array|null
    {
        if(empty($params)) {
            $params = request()->post();
        }

        $validate = Validator::make($params,$rules,$message);
        if($validate->fails()) {
            abort(403, $validate->errors()->first());
        }
        return $params;
    }
}
