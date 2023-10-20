<?php

declare(strict_types=1);

namespace Latent\ElAdmin\Services;

use Jenssegers\Agent\Agent;
use Latent\ElAdmin\Enum\MethodEnum;
use Latent\ElAdmin\Models\GetModelTraits;
use Latent\ElAdmin\Support\Helpers;

class LogWriteService
{
    use GetModelTraits;

    /** @var string[] filter keys maps */
    protected $filters = ['password'];

    /** @var Agent */
    protected $agent;

    public function __construct()
    {
        $this->agent = new Agent();
    }

    public function handle(): void
    {
        if (!config('el_admin.log')) {
            return;
        }

        $user = auth(config('el_admin.guard'))->user();
        $params = request()->all();

        $this->getLogModel()
            ->create([
                'user_id' => $user->id ?? 0,
                'user_name' => $user->name ?? '未知',
                'param' => Helpers::filterParams($params, $this->filters),
                'method' => MethodEnum::METHOD[strtolower(request()->method())],
                'ip' => ip2long(request()->ip()),
                'path' => request()->path(),
                'device_info' => json_encode([
                    'device' => $this->agent->device(),
                    'platform' => $this->agent->platform(),
                    'browser' => $this->agent->browser(),
                ], JSON_UNESCAPED_UNICODE),
            ]);
    }
}
