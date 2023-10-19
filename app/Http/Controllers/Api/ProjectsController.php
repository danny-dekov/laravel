<?php

namespace App\Http\Controllers\Api;

use App\Enums\ProjectStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

/**
 * Project related endpoints
 */
class ProjectsController extends Controller
{
    /**
     * Get single project and all it's tasks
     *
     * @param Project $project
     * @return JsonResponse
     */
    public function single(Project $project): JsonResponse
    {
        return response()->json([
            'status' => 0,
            'data' => new ProjectResource($project)
        ]);
    }

    /**
     * List all projects and their tasks
     * Default pagination of 20 items per page
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function list(Request $request): JsonResponse
    {
        $pageSize = isset($request->toArray()['pageSize']) ? $request->toArray()['pageSize'] : 20; //can be extracted in a controller constant or env variable
        $projects = Project::paginate($pageSize);

        return response()->json([
            'status' => 0,
            'pagination' => [
                'currentPage' => $projects->currentPage(),
                'totalPages' => $projects->lastPage(),
                'itemsPerPage' => $projects->perPage(),
                'totalItems' => $projects->total(),
            ],
            'data' => ProjectResource::collection($projects)
        ]);
    }

    /**
     * Create project
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $taskRules = Project::$rules;
        $statusRules = ['status' => ['required',new Enum(ProjectStatus::class)]];
        $endDateRules = ['end_date' => 'required|after_or_equal:start_date'];

        $request->validate(
            array_merge($taskRules, $statusRules, $endDateRules)
        );

        $project = Project::create($request->toArray());

        return response()->json([
            'status' => 0,
            'data' => new ProjectResource($project)
        ]);
    }

    /**
     * Update project, without changing ownership
     *
     * @param Request $request
     * @param Project $project
     * @return JsonResponse
     */
    public function update(Request $request, Project $project): JsonResponse
    {
        $taskRules = Project::$rules;
        $statusRules = ['status' => ['required',new Enum(ProjectStatus::class)]];
        $endDateRules = ['end_date' => 'required|after_or_equal:start_date'];
        //forbid updating ownership of the project
        $ownershipRules = [
            'client_id' => "sometimes|integer|exists:clients,id|in:$project->client_id",
            'company_id' => "sometimes|integer|exists:companies,id|in:$project->company_id"
        ];

        $request->validate(
            array_merge($taskRules, $statusRules, $endDateRules, $ownershipRules)
        );

        $project->update($request->toArray());

        return response()->json([
            'status' => 0,
            'data' => new ProjectResource($project)
        ]);
    }

    /**
     * Soft delete project
     *
     * @param Project $project
     * @return JsonResponse
     */
    public function delete(Project $project): JsonResponse
    {
        $project->delete();

        return response()->json([
            'status' => 0,
            'data' => 'Object deleted'
        ]);
    }
}
