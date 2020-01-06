<?php
  /**
   * BASE DOS MODELS. O ACESSO AO BANCO É FEITO AQUI COM DADOS INSERIDOS NO CONFIG.PHP NUNCA É NECESSÁRIO ALTERAR ESTE ARQUIVO
   */
  class model
  {
    protected $db;

    function __construct()
    {
      global $config;
      try {
        $this->db = new PDO("mysql:dbname=".$config['dbname'].';host='.$config['host'], $config['dbuser'], $config['dbpass']);
      } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
        exit;
      }
    }
  }

?>
