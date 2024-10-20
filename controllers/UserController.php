<?php
require 'config/controller.php';
require 'models/user.php';
// controllers/UserController.php

class UserController extends Controller {
  private User $userModel;

  public function __construct() {
    $this->userModel = $this->model('User');
  }

  public function index() {
    $users = $this->userModel->getUsers();
    $data = ['users' => $users];

     $this->view('users/index', $data);
  }

  public function create() {
    $this->view('users/create');
  }

  public function store() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // Process form
      $data = [
        'name' => trim($_POST['name']),
        'email' => trim($_POST['email'])
      ];

      if ($this->userModel->create($data)) {
        header('Location: /users');
      } else {
        $this->view('users/create', ['error' => 'Something went wrong']);
      }
    }
  }
}
