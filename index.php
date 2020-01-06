<?php
  session_start();
  if (empty($_SESSION['master_owner'])) {
    $_SESSION['master_owner'] = md5($_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);
  }

  $token_id = md5($_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);

  if ($_SESSION['master_owner'] == $token_id) {
    setlocale(LC_TIME, 'pt_BR\ ', 'pt_BR.utf-8\ ', 'pt_BR.utf-8\ ', 'portuguese\ ');
    date_default_timezone_set('America/Sao_Paulo');
    require 'config.php';
    spl_autoload_register(function($class){
      if (file_exists('app/controllers/' . $class . '.php')) {
        require 'app/controllers/' . $class . '.php';
      } elseif (file_exists('app/models/' . $class . '.php')) {
        require 'app/models/' . $class . '.php';
      } elseif (file_exists('core/' . $class . '.php')) {
        require 'core/' . $class . '.php';
      }
    });
    $core = new core();
    $core->run();
  } else {
    echo "Muitas tentativas por sessão! Acesso bloqueado.";
    exit;
  }

 ?>
