<?php

namespace Tests\Unit;

use App\Models\ToDo;
use App\Models\TodoMirror;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TodoTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testTodoMirrorEquality()
    {

        $todo = ToDo::create(['name'=>'Todo Task','desc'=>'add two tables']);
        $todoMirror = TodoMirror::create(['name'=>'Todo Task','desc'=>'add two tables']);
        $latestTodo = ToDo::latest()->first();

        // Then
        // assert equals: teacher is equal latest teacher
        $this->assertEquals($todoMirror->id, $latestTodo->id);
        $this->assertEquals('Todo Task', $latestTodo->name);
        $this->assertEquals('add two tables', $latestTodo->desc);

        $this->assertDatabaseHas('todos', [
            'name'  => 'Todo Task',
            'desc' => 'add two tables',
        ]);
        $this->assertDatabaseHas('todo_mirrors', [
            'name'  => 'Todo Task',
            'desc' => 'add two tables',
        ]);
    }
    public function testTodoAndTodoMirrorDelete()
    {
        ToDo::create(['name'=>'Todo Task','desc'=>'add two tables']);
        TodoMirror::create(['name'=>'Todo Task','desc'=>'add two tables']);

        // When
        // get a latest teacher created
        $latestTodo = ToDo::latest()->first();
        $latestMirror = TodoMirror::latest()->first();

        // Then
        // delete a latest teacher created and ...
        $latestTodo->delete();
        $latestMirror->delete();


        $this->assertDatabaseMissing('todos', [
            'name'  => 'Todo Task',
            'desc' => 'add two tables',
        ]);
        $this->assertDatabaseMissing('todo_mirrors', [
            'name'  => 'Todo Task',
            'desc' => 'add two tables',
        ]);
    }

}
