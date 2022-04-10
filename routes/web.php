<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/todos/{todoId}', 'TodosController@getTodo');
$router->get('/todos', 'TodosController@getTodos');
$router->post('/todos', 'TodosController@postTodo');
$router->post('/todos/{todo}/status/{status}', 'TodosController@postTodoStatus');
$router->delete('/todos/{todoId}', 'TodosController@deleteTodo');
