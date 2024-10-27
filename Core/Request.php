<?php
class Request {
  private array $params = [];
  public function getPath() {
    $path = $_SERVER['REQUEST_URI'] ?? '/';
    $position = strpos($path, '?');
    if ($position === false) {
      return $path;
    }
    return substr($path, 0, $position);
  }

  public function getMethod() {
    return $_SERVER['REQUEST_METHOD'];
  }

  public function getBody() {
    $body = [];

    if ($this->getMethod() === 'GET') {
      foreach ($_GET as $key => $value) {
        $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
      }
    }

    if ($this->getMethod() === 'POST') {
      foreach ($_POST as $key => $value) {
        $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
      }
    }

    return $body;
  }
  // Set route parameters
  public function setParams(array $params) {
    $this->params = $params;
  }

  // Retrieve a specific parameter by name
  public function getParam(string $key, $default = null) {
    return $this->params[$key] ?? $default;
  }
}