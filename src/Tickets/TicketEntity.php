<?php

declare(strict_types=1);

namespace DevMakerLab\MyMine\Tickets;

use DateTime;
use DevMakerLab\Entity;

class TicketEntity extends Entity
{
    public int $id;
    public string $subject;
    public int $project_id;
    public string $project_name;
    public int $tracker_id;
    public string $tracker_name;
    public int $status_id;
    public string $status_name;
    public int $priority_id;
    public string $priority_name;
    public int $author_id;
    public string $author_name;
    public int $assigned_to_id;
    public string $assigned_to_name;
    public int $category_id;
    public string $category_name;
    public string $description;
    public DateTime $start_date;
    public ?DateTime $due_date;
    public int $done_ratio;
    public bool $is_private;
    public ?int $estimated_hours;
    public DateTime $created_on;
    public DateTime $updated_on;
    public ?DateTime $closed_on;
    public array $journals;
    public array $changesets;
    public array $custom_fields;
}
