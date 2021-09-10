<?php

declare(strict_types=1);

namespace Tests;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Handler\MockHandler;
use DevMakerLab\MyMine\HttpService;
use DevMakerLab\MyMine\AbstractService;
use DevMakerLab\MyMine\Tickets\TicketService;
use DevMakerLab\MyMine\Statuses\StatusService;
use DevMakerLab\MyMine\Projects\ProjectService;

class TestCase extends \PHPUnit\Framework\TestCase
{
    protected function getTicketService(): TicketService
    {
        $tickets = $this->getTestTickets();
        $client = $this->getGuzzleClient($tickets);
        return new TicketService($client);
    }

    protected function getStatusService(): StatusService
    {
        $statuses = $this->getTestStatuses();
        $client = $this->getGuzzleClient($statuses);
        return new StatusService($client);
    }

    protected function getProjectService(): ProjectService
    {
        $projects = $this->getTestProjects();
        $client = $this->getGuzzleClient($projects);
        return new ProjectService($client);
    }

    protected function getAbstractService(): AbstractService
    {
        return new class(new Client()) extends AbstractService {
        };
    }

    protected function getHttpService(?Client $client = null): HttpService
    {
        return new HttpService($client ?: new Client());
    }

    private function getGuzzleClient(array $responses): Client
    {
        $mockedResponses = [];
        foreach ($responses as $response) {
            $mockedResponses[] = new Response(200, [], json_encode($response));
        }

        $mock = new MockHandler($mockedResponses);
        $handler = HandlerStack::create($mock);
        return new Client(['handler' => $handler]);
    }

    private function getTestTickets(): array
    {
        $issues = [
            'issues' => [
                [
                    'id' => 1,
                    'project' => [
                        'id' => 1,
                        'name' => 'MyMine',
                    ],
                    'tracker' => [
                        'id' => 1,
                        'name' => 'Discovery',
                    ],
                    'status' => [
                        'id' => 2,
                        'name' => 'Closed',
                    ],
                    'category' => [
                        'id' => 2,
                        'name' => 'Closed',
                    ],
                    'author' => [
                        'id' => 2,
                        'name' => 'Neo',
                    ],
                    'priority' => [
                        'id' => 1,
                        'name' => 'New',
                    ],
                    'subject' => '(WOULD) Beat the f out of Morpheus',
                    'description' => '...',
                    'start_date' => '1962-03-11',
                    'due_date' => null,
                    'done_ratio' => 100,
                    'is_private' => false,
                    'estimated_hours' => null,
                    'created_on' => '1962-03-11 10:06:25',
                    'updated_on' => '1962-03-11 12:48:46',
                    'closed_on' => '1998-08-03 15:24:51',
                ],
                [
                    'id' => 1,
                    'project' => [
                        'id' => 1,
                        'name' => 'MyMine',
                    ],
                    'tracker' => [
                        'id' => 1,
                        'name' => 'Discovery',
                    ],
                    'status' => [
                        'id' => 2,
                        'name' => 'Closed',
                    ],
                    'category' => [
                        'id' => 2,
                        'name' => 'Closed',
                    ],
                    'author' => [
                        'id' => 2,
                        'name' => 'Neo',
                    ],
                    'priority' => [
                        'id' => 1,
                        'name' => 'New',
                    ],
                    'subject' => '(SHOULD) find out what\'s the matrix',
                    'description' => '...',
                    'start_date' => '1999-03-24',
                    'due_date' => null,
                    'done_ratio' => 101,
                    'is_private' => false,
                    'estimated_hours' => null,
                    'created_on' => '1999-03-24 10:06:25',
                    'updated_on' => '1999-03-24 12:48:46',
                    'closed_on' => '2003-05-07 15:24:51',
                ],
            ],
            'total_count' => 2,
            'offset' => 0,
        ];

        $issue = [
            'issue' => [
                'id' => 1,
                'project' => [
                    'id' => 1,
                    'name' => 'MyMine',
                ],
                'tracker' => [
                    'id' => 1,
                    'name' => 'Discovery',
                ],
                'status' => [
                    'id' => 2,
                    'name' => 'Closed',
                ],
                'category' => [
                    'id' => 2,
                    'name' => 'Closed',
                ],
                'author' => [
                    'id' => 2,
                    'name' => 'Neo',
                ],
                'priority' => [
                    'id' => 1,
                    'name' => 'New',
                ],
                'subject' => '(WOULD) Beat the f out of Morpheus',
                'description' => '...',
                'start_date' => '1962-03-11',
                'due_date' => null,
                'done_ratio' => 100,
                'is_private' => false,
                'estimated_hours' => null,
                'created_on' => '1962-03-11 10:06:25',
                'updated_on' => '1962-03-11 12:48:46',
                'closed_on' => '1998-08-03 15:24:51',
            ],
        ];

        return [$issues, $issue];
    }

    private function getTestStatuses(): array
    {
        $statuses = [
            'issue_statuses' => [
                [
                    'id' => 1,
                    'name' => 'Queued',
                    'is_closed' => false,
                ],
                [
                    'id' => 2,
                    'name' => 'In Progress',
                    'is_closed' => false,
                ],
                [
                    'id' => 3,
                    'name' => 'Done',
                    'is_closed' => false,
                ],
            ],
            'total_count' => 3,
            'offset' => 0,
        ];

        return [$statuses];
    }

    private function getTestProjects(): array
    {
        $projects = [
            'projects' => [
                [
                    'id' => 1,
                    'name' => 'MyMine BackLog',
                    'identifier' => 'mymine-backlog',
                    'description' => 'MyMine\'s backlog',
                    'status' => 1,
                    'is_public' => true,
                    'inherit_members' => false,
                    'created_on' => '2021-07-01-01 00:00:00',
                    'updated_on' => '2021-07-01-01 00:00:00',
                ],
                [
                    'id' => 2,
                    'name' => 'MyMine Support',
                    'identifier' => 'mymine-support',
                    'description' => 'MyMine\'s support',
                    'status' => 1,
                    'is_public' => true,
                    'inherit_members' => false,
                    'created_on' => '2021-07-01-01 00:01:00',
                    'updated_on' => '2021-07-01-01 00:01:00',
                ],
            ],
            'total_count' => 2,
            'offset' => 0,
        ];

        $project = [
            'project' => [
                'id' => 1,
                'name' => 'MyMine BackLog',
                'identifier' => 'mymine-backlog',
                'description' => 'MyMine\'s backlog',
                'homepage' => 'https://github.com/devmakerlab/my-mine',
                'status' => 1,
                'is_public' => true,
                'inherit_members' => false,
                'created_on' => '2021-07-01-01 00:00:00',
                'updated_on' => '2021-07-01-01 00:00:00',
            ],
        ];

        return [$projects, $project];
    }
}
