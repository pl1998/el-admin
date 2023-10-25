<?php

declare(strict_types=1);

namespace Latent\ElAdmin\Controller;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;
use Latent\ElAdmin\Exceptions\ValidateException;
use Latent\ElAdmin\Models\ModelTraits;
use Latent\ElAdmin\Services\LogServices;

class LogsController extends Controller
{
    use ModelTraits;

    /**
     * @throws BindingResolutionException
     * @throws ValidateException
     */
    public function index(): JsonResponse
    {
        $params = $this->validator([
            'ip' => 'string',
            'user_id' => 'int',
            'page' => 'int',
            'page_size' => 'int',
        ]);

        return $this->success(
            app()
                ->make(LogServices::class)
                ->handler($params)
        );
    }

    public function destroy($id): JsonResponse
    {
        $this->getLogModel()->where('id', $id)->delete();

        return $this->success();
    }
}
