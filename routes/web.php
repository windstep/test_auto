<?php

/** @var \Laravel\Lumen\Routing\Router $router */
use App\Http\Controllers\HealthCheckController;

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('healthcheck', 'HealthCheckController@healthcheck');

    $router->get('users', 'UserController@get');
    $router->get('cars', 'CarController@get');
    $router->post('usage', 'CarUsageController@create');
});
