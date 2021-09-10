<?php

declare(strict_types=1);

namespace DevMakerLab\MyMine\Projects;

use DateTime;
use DevMakerLab\Entity;

class ProjectEntity extends Entity
{
    public int $id;
    public string $name;
    public string $identifier;
    public string $description;
    public ?string $homepage;
    public int $status;
    public bool $is_public;
    public bool $inherit_members;
    public DateTime $created_on;
    public DateTime $updated_on;
}
