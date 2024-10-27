<?php


class Controller
{
  protected function model(string $modelName)
  {
    // Assumes the model class file is included and available
    if (class_exists($modelName)) {
      return new $modelName();
    }
    throw new Exception("Model $modelName not found");
  }

  protected function service(string $serviceName)
  {
    // Assumes the service class file is included and available
    if (class_exists($serviceName)) {
      return new $serviceName();
    }
    throw new Exception("Service $serviceName not found");
  }

  protected function view(string $viewPath, array $data = [])
  {
    View::render($viewPath, $data);
//    extract($data);
//    require_once "views/$viewPath.php";
  }

  protected function redirect(string $url, $data = [])
  {
//    extract($data);
    if (!empty($data)) {
      $_SESSION['redirect_data'] = $data;
    }
//    print_r($_SESSION['redirect_data']);
    header("Location: $url");
    exit;
  }

  /**
   * @param Exception $e
   * @return array|string
   */
  public function getError(Exception $e): string|array
  {
    $errors = unserialize($e->getMessage());
    if (is_array($errors)) {
      return $errors;
    } else {
      return $e->getMessage();
    }
  }
}
