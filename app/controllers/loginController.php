<?php
  /**
   * CONTROLADOR DA TELA DE LOGIN
   */
  class loginController extends controller
  {

    public function __construct(){
        parent::__construct();
        //$users = new usersDB();
        //$users->users_check_session();
    }

    public function index(){
      $data_set = array('return' => '');
      $this->loadPage('login', $data_set);
    }

    public function logIn(){
      $login = htmlspecialchars($_POST['login']);
      $pass = urldecode(base64_decode($_POST['pass']));
      
      $users = new usersDB();
      $users->logIn($login, $pass);
    }

    public function setNewUser(){
      $name_nu = htmlspecialchars($_POST['name_nu']);
      $login_nu = htmlspecialchars($_POST['login_nu']);
      $birthday_nu = htmlspecialchars($_POST['birthday_nu']);
      $pass_nu = password_hash($_POST['pass_nu'], PASSWORD_BCRYPT);

      $users = new usersDB();
      $users->setNewUser($name_nu, $login_nu, $birthday_nu, $pass_nu);
    }

    public function setNewPass(){
      $login_np = htmlspecialchars($_POST['login_np']);
      $pass_get = urldecode(base64_decode($_POST['pass_np'])); 
      $pass_np = password_hash($pass_get, PASSWORD_BCRYPT);
      
      $users = new usersDB();
      $users->setNewPass($login_np, $pass_np);
    }

  }

?>
