<?php

declare(strict_types=1);

namespace DevMakerLab\MyMine\Projects;

use DateTime;
use DevMakerLab\MyMine\AbstractService;

class ProjectService extends AbstractService
{
    public function getProject(int $id): ProjectEntity
    {
        $result = $this->fetch("projects/$id.json");

        return $this->toEntity($result['project']);
    }

    public function get(): ProjectEntityList
    {
        $result = $this->fetch('projects.json');

        $projects = $this->transform($result['projects'], function ($project) {
            return $this->toEntity($project);
        });

        return new ProjectEntityList($projects);
    }

    public function toEntity(array $project): ProjectEntity
    {
        return new ProjectEntity([
            'id' => $project['id'],
            'name' => $project['name'],
            'identifier' => $project['identifier'],
            'description' => $project['description'],
            'homepage' => $project['homepage'] ?? null,
            'status' => $project['status'],
            'is_public' => $project['is_public'],
            'inherit_members' => $project['inherit_members'],
            'created_on' => $this->convertToTz($project['created_on'], 'Europe/Paris'),
            'updated_on' => isset($project['updated_on']) ? $this->convertToTz($project['updated_on'], 'Europe/Paris'): null,
        ]);
    }
}
