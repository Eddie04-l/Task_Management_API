<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $query = $user->tasks()->latest();

        if ($request->has('status')) {
            $query->where('status', $request->get('status'));
        }

        $perPage = (int) $request->get('per_page', 10);
        $tasks = $query->paginate($perPage);

        return $tasks;
    }


    public function store(TaskRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;
        $task = Task::create($data);
        return response()->json($task, 201);
    }

    public function show(Request $request, Task $task)
    {
        $this->authorizeTask($request, $task);
        return response()->json($task);
    }

    public function update(TaskRequest $request, Task $task)
    {
        $this->authorizeTask($request, $task);
        $task->update($request->validated());
        return response()->json($task);
    }

    public function destroy(Request $request, Task $task)
    {
        $this->authorizeTask($request, $task);
        $task->delete();
        return response()->json(['message' => 'Task deleted']);
    }

    protected function authorizeTask(Request $request, Task $task)
    {
        if ($task->user_id !== $request->user()->id) {
            abort(403, 'Unauthorized');
        }
    }
}
