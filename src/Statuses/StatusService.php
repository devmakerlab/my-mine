<?php

declare(strict_types=1);

namespace DevMakerLab\MyMine\Statuses;

use DevMakerLab\MyMine\AbstractService;

class StatusService extends AbstractService
{
    public function get(): StatusEntityList
    {
        $result = $this->fetch('issue_statuses.json');

        $tickets = $this->transform($result['issue_statuses'], function ($ticket) {
            return $this->toEntity($ticket);
        });

        return new StatusEntityList($tickets);
    }

    public function toEntity(array $status): StatusEntity
    {
        return new StatusEntity([
            'id' => $status['id'],
            'name' => $status['name'],
            'is_closed' => $status['is_closed'],
        ]);
    }
}
