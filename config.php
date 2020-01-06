<?php
  require 'enviroment.php';

  // Setando sessão principal do sistema para uso externo
  global $core_session_ex;
  if (isset($_SESSION['beanphp_session_log'])) {
    $core_session_ex = $_SESSION['beanphp_session_log'];
  }

  global $config;
  $config = array();
  if (ENVIROMENT == 'development') {
    ini_set("display_errors", "On");
    define("BASEURL", "/");
    $config['dbname'] = 'beanphpdb';
    $config['host']   = 'localhost';
    $config['dbuser'] = 'root';
    $config['dbpass'] = 'root';
  } else {
    ini_set("display_errors", "Off");
    define("BASEURL", "SITENOAR");
    $config['dbname'] = 'BANCONOAR';
    $config['host']   = 'CAMINHODOBANCONOAR';
    $config['dbuser'] = 'USUARIONOAR';
    $config['dbpass'] = 'SENHANOAR';
  }

 ?>
