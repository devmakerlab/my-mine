<?php

declare(strict_types=1);

namespace DevMakerLab\MyMine\Statuses;

use DevMakerLab\Entity;

class StatusEntity extends Entity
{
    public int $id;
    public string $name;
    public bool $is_closed;
}
