<?php
  /**
   * Classe de manipulação da tabela de usuários
   */
  class usersDB extends model
  {
    // Setando sessão principal do sistema
    private $core_session = 'beanphp_session_log';

    // Setando campos da tabela do banco de dados
    private $dbf_table = 'users';
    private $dbf_id = 'id_usu';
    private $dbf_login = 'login';
    private $dbf_pass = 'pass';
    private $dbf_name = 'name';
    private $dbf_birthday = 'birthday';
    private $dbf_image = 'image';
    private $dbf_blocked = 'blocked';
    private $dbf_active = 'active';

    //QUERIES DE LEITURA
    public function users_check_session(){
      if (!isset($_SESSION[$this->core_session]) || (isset($_SESSION[$this->core_session])) && empty($_SESSION[$this->core_session])) {
        header("Location: " . BASEURL . "welcome");
        exit();
      }
    }

    public function getUsers(){
      try {

        // Iniciando transação
        $this->db->beginTransaction();
        $returner = array();
        $query = "SELECT LPAD(". $this->dbf_id .",3,'0') AS cod_usu, usu.* FROM ". $this->dbf_table ." usu ORDER BY cod_usu";
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

    public function getUserSelected($id){

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

    public function logIn($login, $pass){

      try {

        // Iniciando transação
        $this->db->beginTransaction();
        $query = "SELECT * FROM ". $this->dbf_table ." WHERE " . $this->dbf_login . " = :login";
        $query = $this->db->prepare($query);
        $query->bindValue(":login", $login);
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
          $returner = $query->fetch();
          if ($returner[$this->dbf_blocked] == "N") {
            $query = "SELECT * FROM ". $this->dbf_table ." WHERE " . $this->dbf_login . " = :login AND " . $this->dbf_active . " = 'Y'";
            $query = $this->db->prepare($query);
            $query->bindValue(":login", $login);
            $query->execute();
            if ($query->rowCount() > 0) {
              $query = $query->fetch();
              if (password_verify($pass, $query[$this->dbf_pass])) {
                $_SESSION[$this->core_session] = $query[$this->dbf_id];
                $response = array(
                  "code" => "08",
                  "message" => "[Acesso permitido]"
                );
                echo json_encode($response);
                exit();
              } else {
                unset($_SESSION[$this->core_session]);
                $response = array(
                  "code" => "09",
                  "message" => "Senha informada incorreta!"
                );
                echo json_encode($response);
                exit();
              }
            } else {
              unset($_SESSION[$this->core_session]);
              $response = array(
                "code" => "10",
                "message" => "Conta inativa!"
              );
              echo json_encode($response);
              exit();
            }
          } else {
              $response = array(
                "code" => "11",
                "message" => "Conta bloqueada!"
              );
              echo json_encode($response);
              exit();
          }
        } else {
          unset($_SESSION[$this->core_session]);
          $response = array(
            "code" => "12",
            "message" => "login não cadastrado no sistema!"
          );
          echo json_encode($response);
          exit();
        }

      }

    }

    public function logOff(){
      unset($_SESSION[$this->core_session]);
      header("Location: " . BASEURL);
    }

    //QUERIES DE MODIFICAÇÃO
    public function setNewUser($name_nu, $login_nu, $birthday_nu, $pass_nu){

      try {

        // Iniciando transação
        $this->db->beginTransaction();
        $query = "SELECT * FROM ". $this->dbf_table ." WHERE " . $this->dbf_login . " = :login_nu";
        // echo $query;exit;
        $query = $this->db->prepare($query);
        $query->bindValue(":login_nu", $login_nu);
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
            "message" => "login já existe no sistema!"
          );
          echo json_encode($response);
          exit();
        } else {
          $query = "INSERT INTO ". $this->dbf_table ." SET " . $this->dbf_name . " = :name_nu, " . $this->dbf_login . " = :login_nu, " . $this->dbf_pass . " = :pass_nu, " . $this->dbf_birthday . " = :birthday_nu, " . $this->dbf_blocked . " = 'N', " . $this->dbf_active . " = 'Y'";
          //echo $query;exit;
          $query = $this->db->prepare($query);
          $query->bindValue(":name_nu", $name_nu);
          $query->bindValue(":login_nu", $login_nu);
          $query->bindValue(":pass_nu", $pass_nu);
          $query->bindValue(":birthday_nu", $birthday_nu);
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

    public function setEditUser($user_active, $user_name, $user_login, $user_birthday, $user_pass, $id_usu){

      try {

        // Iniciando transação
        $this->db->beginTransaction();
        $query = "SELECT * FROM ". $this->dbf_table ." WHERE " . $this->dbf_login . " = :user_login AND " . $this->dbf_id . " != :id_usu";
        //echo $query;exit;
        $query = $this->db->prepare($query);
        $query->bindValue(":user_login", $user_login);
        $query->bindValue(":id_usu", $id_usu);
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
            "message" => "Outro usuário com este login!"
          );
          echo json_encode($response);
          exit();
        } else {
          if ($user_pass !== '') {
            $query = "UPDATE ". $this->dbf_table ." SET " . $this->dbf_active . " = :user_active, " . $this->dbf_name . " = :user_name, " . $this->dbf_login . " = :user_login, " . $this->dbf_birthday . " = :user_birthday, " . $this->dbf_pass . " = :user_pass WHERE " . $this->dbf_id . " = :id_usu";
          } else {
            $query = "UPDATE ". $this->dbf_table ." SET " . $this->dbf_active . " = :user_active, " . $this->dbf_name . " = :user_name, " . $this->dbf_login . " = :user_login, " . $this->dbf_birthday . " = :user_birthday WHERE " . $this->dbf_id . " = :id_usu";
          }
          // echo $query;exit;
          $query = $this->db->prepare($query);
          $query->bindValue(":user_active", $user_active);
          $query->bindValue(":user_name", $user_name);
          $query->bindValue(":user_login", $user_login);
          $query->bindValue(":user_birthday", $user_birthday);
          if ($user_pass !== '') {
            $query->bindValue(":user_pass", $user_pass);
          }
          $query->bindValue(":id_usu", $id_usu);
          $query->execute();
          $response = array(
            "code" => "14",
            "message" => "Usuário atualizado com sucesso!"
          );
          echo json_encode($response);
          exit();
        }

      }

    }

    public function setUserImg($image, $id_usu){
      if (count($image) > 0) {
        $user_folder = 'uploads/user/' . $id_usu;
        if (is_dir($user_folder)) {
            chmod($user_folder, 0777);
        } else {
            mkdir($user_folder, 0777);
            chmod($user_folder, 0777);
        }
        $query = "SELECT " . $this->dbf_image . " FROM ". $this->dbf_table ." WHERE " . $this->dbf_id . " = :id";
        $query = $this->db->prepare($query);
        $query->bindValue(":id", $id_usu);
        $query->execute();
        $oldpic = $query->fetch();
        if (!empty($oldpic)) {
          chmod($user_folder, 0777);
          @array_map("unlink", glob($user_folder . "/" . $oldpic[$this->dbf_image]));
        }
        $type = $image['type'];
        if (in_array($type, array('image/jpeg', 'image/png'))) {
          $tmpname = md5(time().rand(0, 999)) . '.jpg';
          $tmppath = $user_folder . "/" . $tmpname;
          move_uploaded_file($image['tmp_name'], $tmppath);
          list($width_orig, $height_orig) = getimagesize($tmppath);
          $ratio = $width_orig / $height_orig;
          $width = 150;
          $height = 150;
          if (($width / $height) > $ratio) {
              $width = $height * $ratio;
          } else {
              $height = $width / $ratio;
          }
          $img = imagecreatetruecolor($width, $height);
          $origin = imagecreatefromjpeg($tmppath);
          imagecopyresampled($img, $origin, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
          imagejpeg($img, $tmppath, 80);
          $query = "UPDATE ". $this->dbf_table ." SET " . $this->dbf_image . " = :image WHERE " . $this->dbf_id . " = :id";
          //echo $query;exit;
          $query = $this->db->prepare($query);
          $query->bindValue(":image", $tmpname);
          $query->bindValue(":id", $id_usu);
          $query->execute();
          $response = array(
            "code" => "17",
            "message" => "Imagem do registro atualizada com sucesso!"
          );
          echo json_encode($response);
          exit();
        } else {
          $response = array(
            "code" => "17",
            "message" => "Envie apenas imagens JPG ou JPEG!"
          );
          echo json_encode($response);
          exit();
          }
      }
    }

    public function setNewPass($login_np, $pass_np){

      try {

        // Iniciando transação
        $this->db->beginTransaction();
        $query = "SELECT * FROM ". $this->dbf_table ." WHERE " . $this->dbf_login . " = :login_np";
        //echo $query;exit;
        $query = $this->db->prepare($query);
        $query->bindValue(":login_np", $login_np);
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
          $query = "UPDATE ". $this->dbf_table ." SET " . $this->dbf_pass . " = :pass_np WHERE " . $this->dbf_login . " = :login_np";
          //echo $query;exit;
          $query = $this->db->prepare($query);
          $query->bindValue(":pass_np", $pass_np);
          $query->bindValue(":login_np", $login_np);
          $query->execute();
          $response = array(
            "code" => "06",
            "message" => "#06 - Senha gravada com sucesso!"
          );
          echo json_encode($response);
          exit();
        } else {
          $response = array(
            "code" => "07",
            "message" => "#07 - login não cadastrado no sistema!"
          );
          echo json_encode($response);
          exit();
        }

      }

    }

    public function setDelUser($id_usu){

      try {

        // Iniciando transação
        $this->db->beginTransaction();
        $query = "DELETE FROM ". $this->dbf_table ." WHERE " . $this->dbf_id . " = '$id_usu'";
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

        if ($_SESSION[$this->core_session] === $id_usu) {
          unset($_SESSION[$this->core_session]);
          $response = array(
            "code" => "15",
            "message" => "Registro deletado com sucesso!"
          );
          echo json_encode($response);
          exit();
        } else {
          $response = array(
            "code" => "16",
            "message" => "Registro deletado com sucesso!"
          );
          echo json_encode($response);
          exit();
        }

      }

    }

  }

?>
