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
