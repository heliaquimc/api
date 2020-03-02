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

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('api/login', 'TokenController@gerarToken');

$router->group(['prefix' => 'api', 'middleware' => 'auth'], function() use($router) {

    $router->group(['prefix' => 'series'], function () use($router){
        $router->delete('{id}', 'SeriesController@destroy');
        $router->get('{id}',    'SeriesController@show');
        $router->put('{id}',    'SeriesController@update');
        $router->post('',       'SeriesController@store');
        $router->get('',        'SeriesController@index');
        $router->get('{serieId}/episodios', 'EpisodiosController@buscaPorSerie');
    });

    $router->group(['prefix' => 'episodios'], function () use($router){
        $router->delete('{id}', 'EpisodiosController@destroy');
        $router->get('{id}',    'EpisodiosController@show');
        $router->put('{id}',    'EpisodiosController@update');
        $router->post('',       'EpisodiosController@store');
        $router->get('',        'EpisodiosController@index');
    });
});
