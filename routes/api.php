<?php

use App\Http\Controllers\Api\ProjectsController;
use App\Http\Controllers\Api\TasksController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the 'api' middleware group. Make something great!
|
*/

Route::post('register', [ApiController::class, 'register']);
Route::post('login', [ApiController::class, 'login']);

Route::group([
    'middleware' => ['auth:api']
], function(){

    Route::get('profile', [ApiController::class, 'profile']);
    Route::get('refresh', [ApiController::class, 'refreshToken']);
    Route::get('logout', [ApiController::class, 'logout']);

    Route::get('projects', [ProjectsController::class, 'list']);
    Route::get('projects/{project}', [ProjectsController::class, 'single']);
    Route::post('project', [ProjectsController::class, 'create']);
    Route::put('project/{project}', [ProjectsController::class, 'update']);
    Route::patch('project/{project}/delete', [ProjectsController::class, 'delete']);

    Route::get('projects/{projectId}/tasks', [TasksController::class, 'list']);
    Route::get('tasks/{task}', [TasksController::class, 'single']);
    Route::post('task', [TasksController::class, 'create']);
    Route::put('task/{task}', [TasksController::class, 'update']);
    Route::patch('task/{task}/delete', [TasksController::class, 'delete']);
});
