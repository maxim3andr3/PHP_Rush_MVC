<?php

namespace App\Controllers;

use WebFramework\AppController;
use WebFramework\Router;
use WebFramework\Request;

use App\Models\User;

class LoginController extends AppController
{
  public function login_view(Request $request)
  {
    return $this->render('register/true_register.html.twig', ['base' => $request->base,
      'error' => $this->flashError]);
  }

  public function login(Request $request) { 
    $user = new User();
    $user->setEmail($request->params['email']);
    $user->setPassword($request->params['password']);

    try {
      $user->validate();
    } catch (\Exception $e) {
      $this->flashError->set($e->getMessage());
      $this->redirect('/' . $request->base . 'register/true_register', '302');
      return;
    }

    die();
  }
}