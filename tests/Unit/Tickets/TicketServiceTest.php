<?php

declare(strict_types=1);

namespace Tests\Unit\Tickets;

use Carbon\Carbon;
use Tests\TestCase;
use DevMakerLab\MyMine\Tickets\TicketEntity;
use DevMakerLab\MyMine\Tickets\TicketService;
use DevMakerLab\MyMine\Tickets\TicketEntityList;

class TicketServiceTest extends TestCase
{
    public function testCanGetTicket(): void
    {
        $ticketService = $this->getTicketService();
        $tickets = $ticketService->get();
        $ticket = $ticketService->getTicket($tickets[0]->id);

        $this->assertInstanceOf(TicketEntity::class, $ticket);
        $this->assertSame($tickets[0]->id, $ticket->id);
    }

    public function testCanGetTickets(): void
    {
        $tickets = $this->getTicketService()->get();

        $this->assertCount(2, $tickets);
        $this->assertInstanceOf(TicketEntityList::class, $tickets);
        $this->assertInstanceOf(TicketEntity::class, $tickets[0]);
        $this->assertInstanceOf(TicketEntity::class, $tickets[1]);
    }

    public function testCanGetTicketsInCustomDateRange(): void
    {
        $min = Carbon::parse('1999-01-01 00:00:00');
        $max = Carbon::parse('2000-01-01 00:00:00');

        $ticketService = $this->getTicketService()->inRange($min, $max);
        $this->assertInstanceOf(TicketService::class, $ticketService);

        $filters = $ticketService->getFilters();
        $this->assertSame(['created_on' => '><' . $min->format('Y-m-d') . '|' . $max->format('Y-m-d')], $filters);
    }

    public function testCanAddJournals(): void
    {
        $ticketService = $this->getTicketService();

        $ticketService->addJournals();
        $filters = $ticketService->getFilters();
        $this->assertSame(['include' => 'journals'], $filters);

        $ticketService->resetFilters();

        $ticketService->addFilter('include', 'foo');
        $filters = $ticketService->getFilters();
        $this->assertSame(['include' => 'foo'], $filters);

        $ticketService->addJournals();
        $filters = $ticketService->getFilters();
        $this->assertSame(['include' => 'foo,journals'], $filters);
    }
}
