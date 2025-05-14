<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TaskController extends Controller
{
    protected TaskService $task;

    public function __construct(TaskService $task) 
    {
        $this->task = $task;
    }

    public static function middleware(): array
    {
        return [
            'auth',
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Gate::authorize('viewAny', Task::class);
        $tasks = $this->task->list($request->user(), $request->only(['status_id','priority']));
        return response()->json($tasks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        Gate::authorize('create', Task::class);
        $task = $this->task->create($request->user(), $request->validated());
        return response()->json($task->load('status'), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        Gate::authorize('view', $task);
        return response()->json($task->load(['user','status']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        // dd($request->validated());
        Gate::authorize('update', $task);
        $task = $this->task->update($task, $request->validated());
        return response()->json($task->load('status'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        Gate::authorize('delete', $task);
        $this->task->delete($task);
        return response()->json(['message'=>'تم الحذف']);
    }
}
