<?php

namespace App\Http\Controllers\Api;

use App\Enums\ProjectStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

/**
 * Task related endpoints
 */
class TasksController extends Controller
{
    /**
     * Get single task
     *
     * @param Task $task
     * @return JsonResponse
     */
    public function single(Task $task): JsonResponse
    {
        return response()->json([
            'status' => 0,
            'data' => new TaskResource($task)
        ]);
    }

    /**
     * List all tasks for a specific project
     * Default pagination of 20 items per page
     *
     * @param Request $request
     * @param int $projectId
     * @return JsonResponse
     */
    public function list(Request $request, int $projectId): JsonResponse
    {
        $pageSize = isset($request->toArray()['pageSize']) ? $request->toArray()['pageSize'] : 20; //can be extracted in a controller constant or env variable
        $tasks = Task::where('project_id',$projectId)->paginate($pageSize);

        return response()->json([
            'status' => 0,
            'pagination' => [
                'currentPage' => $tasks->currentPage(),
                'totalPages' => $tasks->lastPage(),
                'itemsPerPage' => $tasks->perPage(),
                'totalItems' => $tasks->total(),
            ],
            'data' => TaskResource::collection($tasks)
        ]);
    }

    /**
     * Create a task for a project
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $taskRules = Task::$rules;
        $statusRules = ['status' => ['required',new Enum(ProjectStatus::class)]];

        $startDateRules = [];
        $endDateRules = [];

        if(isset($request->toArray()['project_id'])){
            $project = Project::find($request->toArray()['project_id']);
            $projectStartDate = date_format($project->start_date,'Y-m-d');
            $projectEndDate = date_format($project->end_date,'Y-m-d');

            $startDateRules = ['start_date' => "after_or_equal:$projectStartDate|before_or_equal:$projectEndDate"];
            $endDateRules = ['end_date' => "after_or_equal:start_date|before_or_equal:$projectEndDate"];
        }

        $request->validate(
            array_merge($taskRules, $statusRules, $startDateRules, $endDateRules)
        );

        $task = Task::create($request->toArray());

        return response()->json([
            'status' => 0,
            'data' => new TaskResource($task)
        ]);
    }

    /**
     * Update a project task, without changing the project
     *
     * @param Request $request
     * @param Task $task
     * @return JsonResponse
     */
    public function update(Request $request, Task $task): JsonResponse
    {
        $taskRules = Task::$rules;
        $statusRules = ['status' => ['required',new Enum(ProjectStatus::class)]];
        $startDateRules = [];
        $endDateRules = [];
        if(isset($request->toArray()['project_id'])){
            $project = Project::find($task->project_id);
            $projectStartDate = date_format($project->start_date,'Y-m-d');
            $projectEndDate = date_format($project->end_date,'Y-m-d');

            $startDateRules = ['start_date' => "required|after_or_equal:$projectStartDate|before_or_equal:$projectEndDate"];
            $endDateRules = ['end_date' => "required|after_or_equal:start_date|before_or_equal:$projectEndDate"];
        }
        //forbid updating the project id
        $projectRules = ['project_id' => "sometimes|integer|exists:projects,id|in:$task->project_id"];

        $request->validate(
            array_merge($taskRules, $statusRules, $startDateRules, $endDateRules, $projectRules)
        );

        $task->update($request->toArray());

        return response()->json([
            'status' => 0,
            'data' => new TaskResource($task)
        ]);
    }

    /**
     * SOft delete task
     *
     * @param Task $task
     * @return JsonResponse
     */
    public function delete(Task $task): JsonResponse
    {
        $task->delete();

        return response()->json([
            'status' => 0,
            'data' => 'Object deleted'
        ]);
    }
}
