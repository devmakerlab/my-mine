<?php

declare(strict_types=1);

namespace Tests\Unit\Statuses;

use Tests\TestCase;
use DevMakerLab\MyMine\Statuses\StatusEntity;
use DevMakerLab\MyMine\Statuses\StatusEntityList;

class StatusServiceTest extends TestCase
{
    public function testCanGetStatuses(): void
    {
        $statuses = $this->getStatusService()->get();

        $this->assertCount(3, $statuses);
        $this->assertInstanceOf(StatusEntityList::class, $statuses);
        $this->assertInstanceOf(StatusEntity::class, $statuses[0]);
        $this->assertInstanceOf(StatusEntity::class, $statuses[1]);
        $this->assertInstanceOf(StatusEntity::class, $statuses[2]);
    }
}
