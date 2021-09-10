<?php

declare(strict_types=1);

namespace Tests\Unit\Projects;

use Tests\TestCase;
use DevMakerLab\MyMine\Projects\ProjectEntity;
use DevMakerLab\MyMine\Projects\ProjectEntityList;

class ProjectServiceTest extends TestCase
{
    public function testCanGetProject(): void
    {
        $projectService = $this->getProjectService();
        $projects = $projectService->get();
        $project = $projectService->getProject($projects[0]->id);

        $this->assertInstanceOf(ProjectEntity::class, $project);
        $this->assertSame($projects[0]->id, $project->id);
    }

    public function testCanGetProjects(): void
    {
        $statuses = $this->getProjectService()->get();

        $this->assertCount(2, $statuses);
        $this->assertInstanceOf(ProjectEntityList::class, $statuses);
        $this->assertInstanceOf(ProjectEntity::class, $statuses[0]);
        $this->assertInstanceOf(ProjectEntity::class, $statuses[1]);
    }
}
