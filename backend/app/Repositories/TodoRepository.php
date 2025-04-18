<?php

namespace App\Repositories;

use App\Models\Todo;

class TodoRepository
{
    public function all($priority = null)
    {
        $query = Todo::query();
        if ($priority) {
            $query->where('priority', $priority);
        }
        return $query->orderByDesc('created_at')->get();
    }

    public function create($data)
    {
        return Todo::create($data);
    }

    public function update(Todo $todo, $data)
    {
        $todo->update($data);
        return $todo;
    }

    public function delete($todo)
    {
        $todo->delete();
    }
}
