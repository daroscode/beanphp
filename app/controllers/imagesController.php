<?php
  /**
   * CONTROLADOR DA TELA DE IMAGENS DO SISTEMA.
   */
  class imagesController extends controller
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
      global $user_in;
      $data_set = array('erro' => '');
      $img = new imagesDB();
      $data_set['my_images'] = $img->getImages($user_in);

      if(isset($_POST['img_new'])){
        $id = $user_in;
        $images = $_FILES['images'];

        $img = new imagesDB();
        $data_set['return'] = $img->addImage($images, $id);
      }

      if (isset($_POST['img_edit'])) {
        $pic_id = $_POST['id_img'];
        $name = addslashes(htmlspecialchars($_POST['name']));
        $description = addslashes(htmlspecialchars($_POST['description']));
        $img = new imagesDB();
        $data_set['return'] = $img->editImage($pic_id, $name, $description);
      }

      $this->loadTemplate('images', $data_set);
    }

    public function setDelImg(){
      $pic_id = $_POST['id_img'];
      $img = new imagesDB();
      $img->deleteImage($pic_id);
    }

  }

?>
