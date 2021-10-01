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

$router->get('/', function() {
    return response(file_get_contents(__DIR__ . "/../public/swagger/v3/index.html"));
});

$router->get('server/{id}/status', 'TopicController@status');
$router->get('server/{id}/players', 'TopicController@players');
$router->get('servers', 'TopicController@servers');

$router->get('version', 'ApiController@version');

