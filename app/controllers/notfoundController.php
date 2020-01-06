<?php
  /**
   * CONTROLADOR DA PÁGINA DE ERRO. VAI SER USADO TODA VEZ QUE O USUÁRIO ACESSAR MANUALMENTE UMA TELA QUE NÃO EXISTE
   */
  class notfoundController extends controller
  {

    public function index(){
      $this->loadPage('404', $data_set = array());
    }
  }

?>
