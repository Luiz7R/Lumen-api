<?php

namespace Features\app\Http\Controllers;

use App\Models\Todo;
use Database\Factories\TodoFactory;
use Tests\TestCase;
use Laravel\Lumen\Testing\DatabaseMigrations;

class TodosControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testUserCanListTodos()
    {
        // Prepare
            Todo::factory()->count(5)->create();

        // Act
           $response = $this->get('/todos');    
        
        // Assert
           $response->assertResponseOk();
           $response->seeJsonStructure(['current_page']);
    }

    public function testUserCanCreateATodo()
    {
        // Prepare
            $payload = [
                'title' => 'Tirar o Lixo',
                'description' => 'Não esquecer de tirar o lixo amanhã as 08:00'
            ];
        
        // Act
           $result = $this->post('/todos', $payload);     
        
        // Assert
           $result->assertResponseStatus(201); // 201 = CREATED
           
           $result->seeInDatabase('todos', $payload);
    }

    public function testUserShouldSendTitleAndDescription()
    {
        // Prepare
           $payload = [
               'varios' => 'nada' 
           ];

        // Act
           $result = $this->post('/todos', $payload);

        // Assert
           $result->assertResponseStatus(422); // 422 = UNPROCESSABLE ENTITY
    } 

    public function testUserCanRetriveASpecificTodo()
    {
         // Prepare
            $todo = Todo::factory()->create();

         // Act
            $uri = '/todos/' . $todo->id;
            $response = $this->get($uri); 

         // Assert
            $response->assertResponseOk();
            $response->seeJsonContains(['title' => $todo->title]);
    }    

    public function testUserShouldReceive404WhenSearchSomethingThatDoenstExists()
    {
        // Prepare


        // Act
           $response = $this->get('/todos/5');

        // Assert
           $response->assertResponseStatus(404);
           $response->seeJsonContains(['error' => 'not found']);
    }

    public function testUserCanDeleteATodo() 
    {
        // Prepare
           $model = Todo::factory()->create();

        // Act
           $response = $this->delete('/todos/' . $model->id);

        // Assert
           $response->assertResponseStatus(204); // 204 - No Content
           $response->notSeeInDatabase('todos', [
               'id' => $model->id
           ]);
    }

    public function testUserCanSetTodoDone()
    {
        // Prepare
           $model = Todo::factory()->create(); 

        // Act
           $response = $this->post('/todos/' . $model->id . '/status/done');
           
           $response->assertResponseStatus(200);
           $this->seeInDatabase('todos', [
               'id' => $model->id,
               'done' => true 
           ]);
    }

    public function testUserCanSetTodoUndone()
    {
        // Prepare
        $model = Todo::factory()->create(['done' => true]); 

        // Act
           $response = $this->post('/todos/' . $model->id . '/status/undone');
           
           $response->assertResponseStatus(200);
           $this->seeInDatabase('todos', [
               'id' => $model->id,
               'done' => false 
           ]);        
    }
}
