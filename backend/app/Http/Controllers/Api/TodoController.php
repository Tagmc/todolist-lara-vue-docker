<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTodoRequest;
use App\Http\Requests\UpdateTodoRequest;
use App\Models\Todo;
use App\Services\TodoService;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    protected $todoService;
    public function __construct(TodoService $todoService)
    {
        $this->todoService = $todoService;
    }

    public function index(Request $request)
    {
        $priority = $request->query('priority');
        $todos = $this->todoService->getTodos($priority);
        return response()->json($todos);
    }

    public function store(StoreTodoRequest $request)
    {
        $todo = $this->todoService->createTodo($request->only(['title', 'priority']));
        return response()->json($todo, 201);
    }

    public function update(UpdateTodoRequest $request, Todo $todo)
    {
        $updatedTodo = $this->todoService->updateTodo($todo, $request->only(['title', 'completed', 'priority', 'status', 'deadline']));
        return response()->json($updatedTodo, 200);
    }

    public function destroy(Todo $todo)
    {
        $this->todoService->deleteTodo($todo);
        return response()->json(['message' => 'Todo deleted successfully'], 204);
    }
}
