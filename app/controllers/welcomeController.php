<?php
  /**
   * CONTROLADOR DA TELA DE WELCOME
   */
  class welcomeController extends controller
  {

    public function __construct(){
        parent::__construct();
    }

    public function index(){
      $this->loadPage('welcome');
    }

  }

?>
