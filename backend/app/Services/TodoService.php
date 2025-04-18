<?php
namespace App\Services;

use App\Repositories\TodoRepository;

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
        return $this->todoRepository->update($todo, $data);
    }

    public function deleteTodo($todo) {
        return $this->todoRepository->delete($todo);
    }
}
