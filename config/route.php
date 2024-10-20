<?php


// core/Router.php
class Router
{
  private array $routes = [];

  public function addRoute($method, $path, $handler)
  {
    $this->routes[] = [
      'method' => $method,
      'path' => $path,
      'handler' => $handler
    ];
  }

  public function dispatch()
  {
    $method = $_SERVER['REQUEST_METHOD'];
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    foreach ($this->routes as $route) {
      if ($route['method'] === $method && $route['path'] === $path) {
        list($controller, $action) = explode('@', $route['handler']);
        $controllerFile = "controllers/$controller.php";

        if (file_exists($controllerFile)) {
          require_once $controllerFile;
          $controllerInstance = new $controller();
          $controllerInstance->$action();
          return;
        }
      }
    }

// 404 if no route matches
    header("HTTP/1.0 404 Not Found");
    echo "404 Not Found";
  }
}
