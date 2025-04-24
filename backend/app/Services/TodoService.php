<?php
namespace App\Services;

use App\Jobs\SendTodoCompletedMail;
use App\Repositories\TodoRepository;
use Illuminate\Support\Facades\Log;

class TodoService {
    protected $todoRepository;
    public function __construct(TodoRepository $todoRepository)
    {
        $this->todoRepository = $todoRepository;
    }

    public function getTodos($priority = null) {
        return $this->todoRepository->all($priority);
    }

    public function createTodo($data) {
        return $this->todoRepository->create($data);
    }

    public function updateTodo($todo, $data) {
    $originalStatus = $todo->status;
    $updatedTodo = $this->todoRepository->update($todo, $data);
    if ($originalStatus === 'doing' && isset($data['status']) && $data['status'] === 'done') {
        dispatch(new SendTodoCompletedMail($updatedTodo));
    }

    return $updatedTodo;
    }

    public function deleteTodo($todo) {
        return $this->todoRepository->delete($todo);
    }
}
