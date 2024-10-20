<?php
// index.php - Front Controller
//require_once 'config/config.php';
require_once 'config/route.php';
//require_once 'core/Controller.php';
//require_once 'core/Database.php';



// Start session
session_start();

// Instantiate Router
$router = new Router();

// Define routes
$router->addRoute('GET', '/', 'HomeController@index');
$router->addRoute('GET', '/about', 'HomeController@about');
$router->addRoute('GET', '/users', 'UserController@index');
$router->addRoute('GET', '/users/create', 'UserController@create');
$router->addRoute('POST', '/users/store', 'UserController@store');

// Dispatch the route
$router->dispatch();

