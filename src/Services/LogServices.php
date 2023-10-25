<?php

namespace Latent\ElAdmin\Services;

use Latent\ElAdmin\Models\ModelTraits;

class LogServices
{
    use ModelTraits;

    protected array $params = [];

    public function handler($params): array
    {
        $this->params = $params;

        $query = $this->getLogModel();

        $query->when(!empty($this->params['user_id']), function ($q) {
            $q->where('user_id', $this->params['user_id']);
        })
            ->when(!empty($this->params['ip']), function ($q) {
                $q->where('ip', ip2long($this->params['ip']));
            });

        return [
            'list' => $query->forPage($params['page'] ?? 1, $params['page_size'] ?? 10)->get()?->toArray(),
            'total' => $query->count(),
            'page' => (int) ($params['page'] ?? 1),
        ];
    }
}
