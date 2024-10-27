<?php
class Router {
  private array $routes = [];
  private Request $request;
  private Response $response;

  public function __construct(Request $request, Response $response) {
    $this->request = $request;
    $this->response = $response;
  }

  public function get(string $path, array $handler): void {
    $this->routes['GET'][$path] = $handler;
  }

  public function post(string $path, array $handler): void {
    $this->routes['POST'][$path] = $handler;
  }

  public function resolve() {
    $path = $this->request->getPath();
    $method = $this->request->getMethod();

    foreach ($this->routes[$method] as $routePath => $handler) {
      $routePattern = preg_replace('/\{([^}]+)\}/', '(?P<$1>[^/]+)', $routePath);
      $routePattern = "#^{$routePattern}$#";

      if (preg_match($routePattern, $path, $matches)) {
        [$controller, $method] = $handler;
        $controller = new $controller();

        // Filter only named parameters
        $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
        $this->request->setParams($params);

        return $controller->$method($this->request, $this->response);
      }
    }

    $this->response->setStatusCode(404);
    return "Not Found";
  }
}
