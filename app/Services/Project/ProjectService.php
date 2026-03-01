<?php

namespace App\Services\Project;

use App\DTOs\Project\StoreProjectDTO;
use App\DTOs\Project\UpdateProjectDTO;
use App\Models\Project;

class ProjectService
{
    public function store(StoreProjectDTO $storeProjectDTO): Project
    {
        $project = Project::create([
            'name' => $storeProjectDTO->name,
            'description' => $storeProjectDTO->description,
            'provider' => $storeProjectDTO->provider
        ]);

        return $project;
    }

    public function update(Project $project, UpdateProjectDTO $dto): Project
    {
        $project->update([
            'name' => $dto->name,
            'description' => $dto->description,
            'provider' => $dto->provider,
        ]);

        return $project;
    }

    public function findByApiKey(string $apiKey): ?Project
    {
        return Project::where('api_key', $apiKey)->first();
    }
}
