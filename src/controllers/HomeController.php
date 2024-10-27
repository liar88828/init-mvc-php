<?php



// controllers/HomeController.php
class HomeController extends Controller
{
  public function index()
  {
    $data = [
      'title' => 'Welcome to Homepage',
      'description' => 'This is the homepage'
    ];
    $this->view('home/index', $data);
  }

  public function about()
  {
    $data = [
      'title' => 'About Us',
      'description' => 'Learn more about us'
    ];

    $this->view('home/about', $data);
  }
}
