<?php
  /**
   * Classe de manipulação da tabela de imagens
   */
  class imagesDB extends model
  {

    // Setando campos da tabela do banco de dados
    private $dbf_table = 'images';
    private $dbf_id = 'id_img';
    private $dbf_fid_usu = 'fid_usu';
    private $dbf_name = 'name';
    private $dbf_description = 'description';
    private $dbf_addr = 'addr';

    public function getImages($id){

      try {

        // Iniciando transação
        $this->db->beginTransaction();
        $returner = array();
        $query = "SELECT LPAD(" . $this->dbf_id . ",3,'0') AS cod_img, img.* FROM " . $this->dbf_table . " img WHERE " . $this->dbf_fid_usu . " = '$id' ORDER BY cod_img DESC";
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

    //QUERIES DE MODIFICAÇÃO
    public function addImage($images, $id){
      if (count($images) > 0) {
        $user_folder = 'uploads/images/' . $id;
        if (is_dir($user_folder)) {
            chmod($user_folder, 0777);
        } else {
            mkdir($user_folder, 0777);
            chmod($user_folder, 0777);
        }
        for ($q = 0; $q < count($images['tmp_name']); $q++) {
            $type = $images['type'][$q];
            if (in_array($type, array('image/jpeg', 'image/png'))) {
              $tmpname = md5(time().rand(0, 999)) . '.jpg';
              $tmppath = $user_folder . "/" . $tmpname;
              move_uploaded_file($images['tmp_name'][$q], $tmppath);
              list($width_orig, $height_orig) = getimagesize($tmppath);
              $ratio = $width_orig / $height_orig;
              $width = 500;
              $height = 500;
              if (($width / $height) > $ratio) {
                  $width = $height * $ratio;
              } else {
                  $height = $width / $ratio;
              }
              $img = imagecreatetruecolor($width, $height);
              if ($type == 'image/jpeg') {
                  $origin = imagecreatefromjpeg($tmppath);
              } elseif ($type == 'image/png') {
                  $origin = imagecreatefrompng($tmppath);
              }
              imagecopyresampled($img, $origin, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
              imagejpeg($img, $tmppath, 80);
              $query = "INSERT INTO " . $this->dbf_table . " SET " . $this->dbf_fid_usu . " = '$id', " . $this->dbf_addr . " = '$tmpname'";
              //echo $query;exit;
              $query = $this->db->query($query);
              header("Refresh:0");
            } else {
              return "Por favor envie apenas imagens JPG ou JPEG!";
            }
        }
      }
    }

    public function editImage($pic_id, $name, $description){

      try {

        // Iniciando transação
        $this->db->beginTransaction();
        $query = "UPDATE " . $this->dbf_table . " SET " . $this->dbf_name . " = :name, " . $this->dbf_description . " = :description WHERE " . $this->dbf_id . " = :id_img";
        $query = $this->db->prepare($query);
        $query->bindValue(":name", $name);
        $query->bindValue(":description", $description);
        $query->bindValue(":id_img", $pic_id);
        $query->execute();
        // Commitando transação
        $this->db->commit();
        
      } catch (Exception $e) {

        $e->getCode();
        // Em caso de erro a transação é cancelada
        $this->db->rollBack();
        exit();
        
      } finally {

        header("Refresh:0");
        exit();

      }
    
    }

    public function deleteImage($pic_id){

      try {

        // Iniciando transação
        $this->db->beginTransaction();
        $query = "SELECT " . $this->dbf_fid_usu . ", " . $this->dbf_addr . " FROM " . $this->dbf_table . " WHERE " . $this->dbf_id . " = '$pic_id'";
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

        $array = $query->fetch();
        $user_folder = 'uploads/images/' . $array[$this->dbf_fid_usu];
        chmod($user_folder, 0777);
        $pic = $array['addr'];
        $query = "DELETE FROM " . $this->dbf_table . " WHERE " . $this->dbf_id . " = '$pic_id'";
        //echo $query;exit;
        $query = $this->db->query($query);
        array_map("unlink", glob($user_folder . "/" . $pic));
        $folder_check = scandir($user_folder);
        if (count($folder_check) > 2) {
          $response = array(
            "code" => "18",
            "message" => "Imagem deletada com sucesso!"
          );
          echo json_encode($response);
          exit();
        } else {
          rmdir($user_folder);
          $response = array(
            "code" => "18",
            "message" => "Imagem deletada com sucesso!"
          );
          echo json_encode($response);
          exit();
        }

      }

    }

  }

?>
