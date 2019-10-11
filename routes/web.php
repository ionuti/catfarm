<?php

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

$router->group(['prefix'=>'api/v1'], function() use($router){
    $router->get('/cats', 'CatController@index');
    $router->post('/cat', 'CatController@create');
    $router->get('/cat/{id}', 'CatController@show');
    $router->put('/cat/{id}', 'CatController@update');
    $router->put('/cat/{id}/feed', 'CatController@feed');
    $router->delete('/cat/{id}', 'CatController@destroy');
    $router->get('/cat/{id}/status', 'CatController@status');

});
$router->get('/', 'CatController@index');