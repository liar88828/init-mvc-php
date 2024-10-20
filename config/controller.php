<?php

// core/Controller.php
class Controller
{
  protected function view($view, $data = [])
  {
    extract($data);
    require_once "views/$view.php";
  }

  protected function model($model)
  {
    require_once "models/$model.php";
    return new $model();
  }
}

