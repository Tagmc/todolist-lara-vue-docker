<?php

namespace Tests\Unit;

use App\Jobs\SendTodoCompletedMail;
use App\Models\Todo;
use App\Repositories\TodoRepository;
use App\Services\TodoService;
use Illuminate\Support\Facades\Bus;
use Mockery;
use Tests\TestCase;

class TodoServiceTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_get_todos_returns_all_todos()
    {
        $mockRepo = Mockery::mock(TodoRepository::class);
        $mockRepo->shouldReceive('all')
            ->with(null)
            ->andReturn(collect(['todo1', 'todo2']));
        $service = new TodoService($mockRepo);
        $result = $service->getTodos();
        $this->assertEquals(['todo1', 'todo2'], $result->all());
    }

    public function test_create_todo_calls_repository_create()
    {
        $mockRepo = Mockery::mock(TodoRepository::class);
        $data = ['title' => 'Test', 'priority' => 3];
        $mockRepo->shouldReceive('create')
            ->with($data)
            ->once()
            ->andReturn((object) $data);
        $service = new TodoService($mockRepo);
        $result = $service->createTodo($data);
        $this->assertEquals('Test', $result->title);
    }

    public function test_update_todo_dispatches_job_when_status_done()
    {
        Bus::fake();
        $todo = Todo::factory()->create(['status' => 'doing']);
        $updatedTodo = clone $todo;
        $updatedTodo->status = 'done';
        $mockRepo = Mockery::mock(TodoRepository::class);
        $mockRepo->shouldReceive('update')
            ->with($todo, ['status' => 'done'])
            ->andReturn($updatedTodo);
        $service = new TodoService($mockRepo);
        $result = $service->updateTodo($todo, ['status' => 'done']);
        Bus::assertDispatched(SendTodoCompletedMail::class);
        $this->assertEquals('done', $result->status);
    }

    public function test_delete_todo_calls_repository_delete()
    {
        $mockRepo = Mockery::mock(TodoRepository::class);
        $todo = new Todo();
        $mockRepo->shouldReceive('delete')
            ->with($todo)
            ->once();
        $service = new TodoService($mockRepo);
        $service->deleteTodo($todo);
        $this->assertTrue(true);
    }
}
