<?php
  /**
   * Classe de manipulação da tabela de example
   */
  class exampleDB extends model
  {
    // Setando sessão principal do sistema
    private $core_session = 'beanphp_session_log';

    // Setando campos da tabela do banco de dados
    private $dbf_table = 'example';
    private $dbf_id = 'some_id';
    private $dbf_some = 'some';
    private $dbf_data = 'data';

    public function getData(){
      try {

        // Iniciando transação
        $this->db->beginTransaction();
        $returner = array();
        $query = "SELECT LPAD(". $this->dbf_id .",3,'0') AS code, cod.* FROM ". $this->dbf_table ." cod ORDER BY code";
        // echo $query;exit();
        $query = $this->db->query($query);
        // Commitando transação
        $this->db->commit();

      } catch (PDOException $e) {

        $e->getCode();
        // Em caso de erro a transação é cancelada
        $this->db->rollBack();
        exit();

      } finally {

         if ($query->rowCount() > 0) {
            $returner = $query->fetchAll();
         }
         return $returner;
         exit();

      }
    
    }

    public function getDataSelected($id){

      try {

        // Iniciando transação
        $this->db->beginTransaction();
        $returner = array();
        $query = "SELECT * FROM ". $this->dbf_table ." WHERE " . $this->dbf_id . " = '$id'";
        //echo $query;exit;
        $query = $this->db->query($query);
        // Commitando transação
        $this->db->commit();
        
      } catch (Exception $e) {

        $e->getCode();
        // Em caso de erro a transação é cancelada
        $this->db->rollBack();
        exit();
        
      } finally {

        if ($query->rowCount() > 0) {
          $returner = $query->fetchAll();
        }
        return $returner;
        exit();

      }

    }

    public function addData($some, $data){

      try {

        // Iniciando transação
        $this->db->beginTransaction();
        $query = "SELECT * FROM ". $this->dbf_table ." WHERE " . $this->dbf_some . " = :some";
        // echo $query;exit;
        $query = $this->db->prepare($query);
        $query->bindValue(":some", $some);
        $query->execute();
        // Commitando transação
        $this->db->commit();
        
      } catch (Exception $e) {

        $e->getCode();
        // Em caso de erro a transação é cancelada
        $this->db->rollBack();
        exit();
        
      } finally {

        if ($query->rowCount() > 0) {
          $response = array(
            "code" => "01",
            "message" => "registro já existe no sistema!"
          );
          echo json_encode($response);
          exit();
        } else {
          $query = "INSERT INTO ". $this->dbf_table ." SET " . $this->dbf_some . " = :some, " . $this->dbf_data . " = :data";
          //echo $query;exit;
          $query = $this->db->prepare($query);
          $query->bindValue(":some", $some);
          $query->bindValue(":data", $data);
          $query->execute();
          $response = array(
            "code" => "02",
            "message" => "Registro gravado com sucesso!"
          );
          echo json_encode($response);
          exit();
        }

      }

    }

    public function editData($some, $data, $some_id){

      try {

        // Iniciando transação
        $this->db->beginTransaction();
        $query = "SELECT * FROM ". $this->dbf_table ." WHERE " . $this->dbf_some . " = :some AND " . $this->dbf_id . " != :some_id";
        //echo $query;exit;
        $query = $this->db->prepare($query);
        $query->bindValue(":some", $some);
        $query->bindValue(":some_id", $some_id);
        $query->execute();
        // Commitando transação
        $this->db->commit();
        
      } catch (Exception $e) {

        $e->getCode();
        // Em caso de erro a transação é cancelada
        $this->db->rollBack();
        exit();
        
      } finally {

        if ($query->rowCount() > 0) {
          $response = array(
            "code" => "13",
            "message" => "Outro registro já existe!"
          );
          echo json_encode($response);
          exit();
        } else {
          $query = "UPDATE ". $this->dbf_table ." SET " . $this->dbf_some . " = :some, " . $this->dbf_data . " = :data WHERE " . $this->dbf_id . " = :some_id";
          // echo $query;exit;
          $query = $this->db->prepare($query);
          $query->bindValue(":some", $some);
          $query->bindValue(":data", $data);
          $query->bindValue(":some_id", $some_id);
          $query->execute();
          $response = array(
            "code" => "14",
            "message" => "Registro atualizado com sucesso!"
          );
          echo json_encode($response);
          exit();
        }

      }

    }

    public function delData($some_id){

      try {

        // Iniciando transação
        $this->db->beginTransaction();
        $query = "DELETE FROM ". $this->dbf_table ." WHERE " . $this->dbf_id . " = '$some_id'";
        //echo $query;exit;
        $query = $this->db->query($query);
        // Commitando transação
        $this->db->commit();
        
      } catch (Exception $e) {

        $e->getCode();
        // Em caso de erro a transação é cancelada
        $this->db->rollBack();
        exit();
        
      } finally {

        $response = array(
	        "code" => "16",
	        "message" => "Registro deletado com sucesso!"
	    );
        echo json_encode($response);
        exit();

      }

    }

  }

?>
