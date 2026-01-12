<?php
require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// require 'Router.php';
// require 'UserController.php';

$router = new Router();

$router->get('users/{id}', 'UserController@show');

$router->run();