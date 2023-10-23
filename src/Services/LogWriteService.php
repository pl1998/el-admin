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

    /** @var array|mixed|string[] */
    protected $filterMethod;

    /** @var Agent */
    protected $agent;

    protected $method;

    public function __construct()
    {
        $this->agent = new Agent();
        $this->filterMethod = config('el_admin.log_filter_method') ?? [];
        $this->method = strtolower(request()->method());
    }

    public function handle(): void
    {
        if (!config('el_admin.log')) {
            return;
        }

        if (in_array($this->method, $this->filterMethod)) {
            return;
        }

        $user = auth(config('el_admin.guard'))->user();
        $params = request()->all();

        $this->getLogModel()
            ->create([
                'user_id' => $user->id ?? 0,
                'user_name' => $user->name ?? '未知',
                'param' => json_encode(Helpers::filterParams($params, $this->filters), JSON_UNESCAPED_UNICODE),
                'method' => MethodEnum::METHOD[$this->method],
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
