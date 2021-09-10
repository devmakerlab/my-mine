<?php

declare(strict_types=1);

namespace DevMakerLab\MyMine\Tickets;

use DateTime;
use DevMakerLab\MyMine\AbstractService;

class TicketService extends AbstractService
{
    public function getTicket(int $id): TicketEntity
    {
        $result = $this->fetch("issues/$id.json");

        return $this->toEntity($result['issue']);
    }

    public function get(): TicketEntityList
    {
        $result = $this->fetch('issues.json');

        $tickets = $this->transform($result['issues'], function ($ticket) {
            return $this->toEntity($ticket);
        });

        return new TicketEntityList($tickets);
    }

    public function addJournals(): self
    {
        $existingIncludes = null;
        if (isset($this->filters['include'])) {
            $existingIncludes = explode(',', $this->filters['include']);
        }

        $existingIncludes[] = 'journals';

        $this->filters['include'] = implode(',', $existingIncludes);

        return $this;
    }

    public function inRange(DateTime $min, DateTime $max): self
    {
        $this->addFilter('created_on', '><' . $min->format('Y-m-d') . '|' . $max->format('Y-m-d'));

        return $this;
    }

    public function toEntity(array $ticket): TicketEntity
    {
        return new TicketEntity([
            'id' => $ticket['id'],
            'subject' => $ticket['subject'],
            'description' => $ticket['description'],
            'start_date' => isset($ticket['start_date']) ? new DateTime($ticket['start_date']) : null,
            'due_date' => isset($ticket['due_date']) ? new DateTime($ticket['due_date']) : null,
            'tracker_id' => $ticket['tracker']['id'],
            'tracker_name' => $ticket['tracker']['name'],
            'project_id' => $ticket['project']['id'],
            'project_name' => $ticket['project']['name'],
            'status_id' => $ticket['status']['id'],
            'status_name' => $ticket['status']['name'],
            'author_id' => $ticket['author']['id'],
            'author_name' => $ticket['author']['name'],
            'assigned_to_id' => $ticket['assigned_to']['id'] ?? null,
            'assigned_to_name' => $ticket['assigned_to']['name'] ?? null,
            'category_id' => $ticket['category']['id'],
            'category_name' => $ticket['category']['name'],
            'priority_id' => $ticket['priority']['id'],
            'priority_name' => $ticket['priority']['name'],
            'created_on' => $this->convertToTz($ticket['created_on'], 'Europe/Paris'),
            'updated_on' => isset($ticket['updated_on']) ? $this->convertToTz($ticket['updated_on'], 'Europe/Paris'): null,
            'closed_on' => isset($ticket['closed_on']) ? $this->convertToTz($ticket['closed_on'], 'Europe/Paris') : null,
            'journals' => $ticket['journals'] ?? [],
            'custom_fields' => $ticket['custom_fields'] ?? [],
            'changesets' => $ticket['changesets'] ?? [],
        ]);
    }
}
