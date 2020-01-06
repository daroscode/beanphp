<?php
  /**
   * CLASSE CONTROLADOR DOS CONTROLADORES. AQUI É CRIADO A CHAMADA ESTRUTURAL DE PÁGINAS, TEMPLATES E VISUALIZADORES. NÃO É NECESSÁRIO MEXER NESTE ARQUIVO.
   */
  class controller extends model
  {

    public function __construct(){
      parent::__construct();
    }

    public function loadPage($viewName, $viewData_set = array()){
      extract($viewData_set);
      require 'views/' . $viewName . '.php';
    }

    public function loadTemplate($viewName, $viewData_set = array()){
      include 'views/template.php';
    }

    public function loadViewer($viewName, $viewData_set = array()){
        extract($viewData_set);
        include 'views/' . $viewName . '.php';
    }

  }

 ?>
