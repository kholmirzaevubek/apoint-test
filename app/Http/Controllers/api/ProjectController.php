<?php

namespace App\Http\Controllers\Api;

use App\DTOs\Project\StoreProjectDTO;
use App\DTOs\Project\UpdateProjectDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Services\Project\ProjectService;
use Exception;
use Illuminate\Http\JsonResponse;

class ProjectController extends Controller
{
    public function __construct(
        private ProjectService $projectService
    ) {
    }

    public function index(): JsonResponse
    {
        return response()->json(Project::query()->latest()->paginate(15));
    }

    public function store(StoreProjectRequest $request): JsonResponse
    {
        try {
            $project = $this->projectService->store(StoreProjectDTO::fromRequest($request));

            return (new ProjectResource($project))
                ->response()
                ->setStatusCode(201);
        } catch (Exception $e) {
            return response()->json([
                'name' => 'Server Error'
            ], 500);
        }


    }

    public function update(
        UpdateProjectRequest $request,
        Project $project
    ): JsonResponse {
        try {

            $project = $this->projectService->update(
                $project,
                UpdateProjectDTO::fromRequest($request)
            );

            return (new ProjectResource($project))
                ->response()
                ->setStatusCode(201);
        } catch (Exception $e) {
            return response()->json([
                'name' => 'Server Error'
            ], 500);
        }
    }
}
