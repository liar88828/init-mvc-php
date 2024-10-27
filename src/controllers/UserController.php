<?php

require_once 'src/models/Users.php';

class UserController extends Controller // must be extended the controller
{


  private Users $usersModel;

  //  private ImageService $imageService;

  public function __construct()

  {
    $this->usersModel = $this->model('Users');
    //    $this->imageService = $this->service('ImageService');

  }

  public function index()
  {
    $users = Users::all();
    return View::render('users/index', [
      'title' => 'Users List',
      'description' => 'users list',
      'users' => $users
    ]);
  }

  public function test()
  {
//    $users = $this->usersModel->getUsers();
//    $users = Users::query()->limit(1)->get();
    $users = Users::query()->orderBy('email','ASC')->get();
//    $users = Users::query()->where('name', 'aaaa')->get();
//    $users = Users::query()->where('name', 'aaaa')->get();
    return View::render('users/index', [
      'title' => 'Users List',
      'description' => 'users list',
      'users' => $users
    ]);
  }

  public function detail(Request $request)
  {
    $id = $request->getParam('id');
    $user = Users::find($id);
    return View::render('users/detail', ['user' => $user]);
  }

  public function delete(Request $request)
  {
    try {
      if ($request->getMethod() == 'POST') {
        $id = $request->getParam('id');

        $user = new Users(['id' => $id]);
        if ($user->delete()) {
          $this->redirect('/', ['message' => 'success delete']);
        } else {
          throw new Exception('error bos');
        }
      }
    } catch (Exception $e) {
      $this->redirect('/', ['message' => $e->getMessage()]);

    }
  }

  public function update(Request $request)
  {
    $id = $request->getParam('id');

    try {

      if ($request->getMethod() == "GET") {
        $user = Users::find($id);
        return View::render('users/update', ['user' => $user]);
      }
      if ($request->getMethod() == "POST") {
        $id = $request->getParam('id');
        $data = [
          'id' => $id,
          'name' => $_POST['name'],
          'email' => $_POST['email'],
          'message' => $_POST['message'],
          'password' => $_POST['password'],
        ];

        if (isset($data['password'])) {
          $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        $user = Users::find($id);
        $user->fill($data);
        if ($user->save()) {
          $this->redirect('/');
        } else {
          ErrorSession::whenError($user);
        }
      }
    } catch (Exception $e) {
      $this->redirect('/update/' . $id, ['errors' => $this->getError($e)]);
    }
  }


  public function create(Request $request)
  {
    try {
      if ($request->getMethod() === 'GET') {
        return View::render('/users/create');
      }
      if ($request->getMethod() === 'POST') {

        $user = new Users(
          [
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'message' => $_POST['message'],
            'password' => $_POST['password'],
          ]
        );
        if ($user->save()) {
          $this->redirect('/', ['message' => 'success to create user']);
          exit;
        } else {
          ErrorSession::whenError($user);
        }
      }
    } catch (Exception $e) {
      $this->redirect('/create', ['errors' => $this->getError($e)]);
    }
  }


  // Search for products by name and brand
  public function search(Request $request): array
  {
    $criteria = ['name' => $_POST['name'], 'email' => $_POST['email']];
    $query = Users::query();

    if (!empty($criteria['name'])) {
      $query->where('name', '%' . $criteria['name'] . '%');
    }

    if (!empty($criteria['email'])) {
      $query->where('brand', '%' . $criteria['brand'] . '%');
    }

    return $query->get();

  }

}
