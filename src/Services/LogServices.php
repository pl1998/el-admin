<?php

namespace Latent\ElAdmin\Services;

use Latent\ElAdmin\Models\GetModelTraits;

class LogServices
{
    use GetModelTraits;

    /** @var array */
    protected $params = [];

    public function handler($params): array
    {
        $this->params = $params;

        $query = $this->getLogModel();

        $query->when(!empty($this->params['user_id']), function ($q) {
            $q->where('user_id', $this->params['user_id']);
        })
            ->when(!empty($this->params['method']), function ($q) {
                $q->where('method', $this->params['method']);
            })
            ->when(!empty($this->params['ip']), function ($q) {
                $q->where('ip', ip2long($this->params['method']));
            });

        return [
            'list' => $query->page($params['page'] ?? 1, $params['page_size'])->get()?->toArray(),
            'total' => $query->count(),
            'page' => (int) ($params['page'] ?? 1),
        ];
    }
}
