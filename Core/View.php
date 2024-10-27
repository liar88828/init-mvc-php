<?php


class View
{
  public static function render(string $view, array $data = [])
  {
    extract($data);
    ob_start();
//    include __DIR__ . "/views/$view.php";
    require_once "src/views/$view.php";
    return ob_get_clean();
//    include __DIR__ . "/views/$viewPath.php";

  }
}