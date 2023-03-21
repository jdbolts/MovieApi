<?php

/** @var Router $router */
use Laravel\Lumen\Routing\Router;

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api', 'namespace' => 'Api'], function () use ($router) {
    $router->get('movie', ['uses' => 'MovieController@list']);
    $router->get('movie/{id}', ['uses' => 'MovieController@get']);
    $router->post('movie', ['uses' => 'MovieController@create']);
    $router->delete('movie/{id}', ['uses' => 'MovieController@delete']);
});
