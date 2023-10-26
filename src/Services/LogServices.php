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
        $userId = isset($this->params['user_id']) ? (int) $this->params['user_id'] : null;
        $query = $this->getLogModel();

        $query = $query->when($userId, function ($q) use ($userId) {
            return $q->where('user_id', 'LIKE', "%{$userId}%");
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
