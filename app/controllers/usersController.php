<?php
  /**
   * CONTROLADOR DA TELA USERS DO SISTEMA.
   */
  class usersController extends controller
  {

    public function __construct(){
        parent::__construct();
        $users = new usersDB();
        $users->users_check_session();
        global $user_in;
        global $core_session_ex;
        $user_in = intval($core_session_ex);
    }

    public function index(){
      $data_set = array();
      $users = new usersDB();
      $data_set['users'] = $users->getUsers();
      $this->loadTemplate('users', $data_set);
    }

    public function users_new(){
      $data_set = array('return' => '');
      $this->loadTemplate('users_new', $data_set);
    }

    public function setNewUser(){
      $name_nu = htmlspecialchars($_POST['name_nu']);
      $login_nu = htmlspecialchars($_POST['login_nu']);
      $birthday_nu = htmlspecialchars($_POST['birthday_nu']);
      $pass_get = urldecode(base64_decode($_POST['pass_nu']));
      $pass_nu = password_hash($pass_get, PASSWORD_BCRYPT);

      $users = new usersDB();
      $users->setNewUser($name_nu, $login_nu, $birthday_nu, $pass_nu);
    }

    public function setEditUser(){
      $user_login = htmlspecialchars($_POST['user_login']);
      if (isset($_POST['user_pass']) && !empty($_POST['user_pass'])) {
        $user_pass_get = urldecode(base64_decode($_POST['user_pass'])); 
        $user_pass = password_hash($user_pass_get, PASSWORD_BCRYPT);
      } else {
        $user_pass = '';
      }
      $user_active = $_POST['user_active'];
      $user_name = addslashes(htmlspecialchars($_POST['user_name']));
      $user_birthday = addslashes(htmlspecialchars($_POST['user_birthday']));
      $id_usu = $_POST['id_usu'];
      $users = new usersDB();
      $users->setEditUser($user_active, $user_name, $user_login, $user_birthday, $user_pass, $id_usu);
    }

    public function setUserImg(){
      $image = $_FILES['user_image'];
      $id_usu = $_POST['id_usu'];
      
      $users = new usersDB();
      $users->setUserImg($image, $id_usu);
    }

    public function setDelUser(){
      $id_usu = $_POST['id_usu'];
      $users = new usersDB();
      $users->setDelUser($id_usu);
    }

    public function logout(){
      $users = new usersDB();
      $users->logOff();
    }

  }

?>