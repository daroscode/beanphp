<?php
  /**
   * CONTROLADOR DA TELA EXAMPLE DO SISTEMA.
   */
  class exampleController extends controller
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
      $example = new exampleDB();
      $data_set['example'] = $example->getData();
      $this->loadTemplate('home', $data_set);
    }

    public function parameter_page(){
      global $user_in;
      $data_set = array('return' => '');
      $example = new exampleDB();
      $data_set['selected_data'] = $example->getDataSelected($user_in);
      $this->loadTemplate('parameter_page', $data_set);
    }

    public function addData(){
      $some = htmlspecialchars($_POST['some']);
      $data = htmlspecialchars($_POST['data']);

      $example = new exampleDB();
      $example->addData($some, $data);
    }

    public function editData(){
      $some = htmlspecialchars($_POST['some']);
      $data = htmlspecialchars($_POST['data']);
      $some_id = $_POST['some_id'];
      $example = new exampleDB();
      $example->editData($some, $data, $some_id);
    }

    public function delData(){
      $some_id = $_POST['some_id'];
      $example = new exampleDB();
      $example->delData($some_id);
    }

  }

?>
