<?php

declare(strict_types=1);


namespace Latent\ElAdmin\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
use Latent\ElAdmin\Enum\MethodEnum;
use Latent\ElAdmin\Models\GetModelTraits;
use Latent\ElAdmin\Services\LogServices;

class LogsController extends Controller
{
    use GetModelTraits;

    public function index()
    {
        $params = $this->validator([
            'ip'         => 'string',
            'method'     => ['int',Rule::in(array_values(MethodEnum::METHOD))],
            'user_id'    => 'int',
            'page'       => 'int',
            'page_size'  => 'int',
        ]);
        return $this->success(
            app()
                ->make(LogServices::class)
                ->handler($params)
        );
    }
    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy( $id) :JsonResponse
    {
        $this->getLogModel()->where('id',$id)->delete();
        return $this->success();
    }
}
