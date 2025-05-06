<?php

namespace Tests\Unit;

use App\Models\Todo;
use App\Repositories\TodoRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TodoRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     */
    protected $repo;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repo = new TodoRepository();
    }

    public function test_it_can_get_all_todos()
    {
        Todo::factory()->count(3)->create();
        $todos = $this->repo->all();
        $this->assertCount(3, $todos);
    }

    public function test_it_can_filter_todos_by_priority()
    {
        Todo::factory()->create(['priority' => 3]);
        Todo::factory()->create(['priority' => 1]);
        $filtered = $this->repo->all(3);
        $this->assertCount(1, $filtered);
        $this->assertEquals(3, $filtered->first()->priority);
    }

    public function test_it_can_create_a_todo()
    {
        $data = ['title' => 'Test Create', 'priority' => 2];
        $todo = $this->repo->create($data);
        $this->assertDatabaseHas('todos', ['title' => 'Test Create']);
        $this->assertEquals(2, $todo->priority);
    }

    public function test_it_can_update_a_todo()
    {
        $todo = Todo::factory()->create(['title' => 'Old Title']);
        $updated = $this->repo->update($todo, ['title' => 'New Title', 'priority' => 3]);
        $this->assertEquals('New Title', $updated->title);
        $this->assertEquals(3, $updated->priority);
        $this->assertDatabaseHas('todos', ['title' => 'New Title']);
    }

    public function test_it_can_delete_a_todo()
    {
        $todo = Todo::factory()->create();
        $this->repo->delete($todo);
        $this->assertDatabaseMissing('todos', ['id' => $todo->id]);
    }
}
