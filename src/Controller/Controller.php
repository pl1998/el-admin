<?php

declare(strict_types=1);

namespace Latent\ElAdmin\Controller;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Latent\ElAdmin\Support\Validate;
use Latent\ElAdmin\Traits\Response;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;
    use Response;
    use Validate;

    public function mergeParams(array $params): array
    {
        return array_merge(request()->input(), $params);
    }
}
