<?php
require_once 'Core/Router.php';
require_once 'Core/Request.php';
require_once 'Core/Response.php';
require_once 'Core/Controller.php';
require_once 'Core/View.php';
require_once 'Core/Database/QueryBuilder.php';
require_once 'Core/Database/Database.php';
require_once 'Core/Database/Model.php';
require_once 'Core/Attributes/Column.php';
require_once 'Core/Attributes/Validation.php';
require_once 'src/Controllers/UserController.php';
require_once 'Utils/ErrorSession.php';


class Application
{
  private Router $router;
  private Request $request;
  private Response $response;

  public function __construct()
  {
    $this->request = new Request();
    $this->response = new Response();
    $this->router = new Router($this->request, $this->response);
  }

  public function getRouter(): Router
  {
    return $this->router;
  }

  public function run()
  {
    echo $this->router->resolve();
  }
}
