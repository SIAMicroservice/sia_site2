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


$router->get('/users2',['uses' => 'UserController2@index']);                    //get all users
$router->post('/users2',['uses' => 'UserController2@add']);                     //add  users
$router->get('/users2/{id}',['uses' => 'UserController2@show']);                //get users by id
$router->put('/update/users2/{id}',['uses' => 'UserController2@updateUser']);   //UPDATE users by id
$router->delete('/users2/{id}',['uses' => 'UserController2@deleteUser']);       //delete user record


// USERJOB ROUTES

$router->get('/userjob2',['uses' => 'UserJobController@index']);             //get all jobs
$router->get('/userjob2/{id}',['uses' => 'UserJobController@show']);            //get jobs by id