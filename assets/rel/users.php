<?php
    $active = $_GET['active'];

    require_once '../../config.php';
    global $config;
    $conexao = new PDO("mysql:dbname=".$config['dbname'].';host='.$config['host'], $config['dbuser'], $config['dbpass']);

    if ($active != 'A') {
        $query = "SELECT * FROM users WHERE active = '$active'";
        //echo $query;exit;
        $query = $conexao->query($query);

        if ($query->rowCount() > 0) {
            $returner = $query->fetchAll();
            $regcount = $query->rowCount();
        } else {
            $returner = "Nenhum registro encontrado!";
        }

        if ($returner != "Nenhum registro encontrado!") {
            require_once("fpdf/fpdf.php");

            class PDF extends FPDF
            {
            // Page header
            function Header()
            {
                // Logo
                $this->Image('../../assets/img/icon.png',10,6,30);
                // Arial bold 15
                $this->SetFont('Arial','B',15);
                // Move to the right
                $this->Cell(80);
                // Title
                $this->Cell(30,10,utf8_decode('Usuários do sistema'),0,0,'C');
                // Line break
                $this->Ln(20);
            }

            // Page footer
            function Footer()
            {
                // Position at 1.5 cm from bottom
                $this->SetY(-15);
                // Arial italic 8
                $this->SetFont('Arial','I',8);
                // Page number
                $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
            }
            }

            // Instanciation of inherited class
            $pdf = new PDF();
            $pdf->AliasNbPages();
            $pdf->AddPage();
            $pdf->SetFont('Times','',12);
            $pdf->Cell(10,20,'ID:',0,0,"L");
            $pdf->Cell(60,20,'Nome',0,0,"L");
            $pdf->Cell(60,20,'Login / Email',0,0,"L");
            $pdf->Cell(50,20,'Status',0,0,"L");
            $pdf->Ln(20);
            foreach ($returner as $key) {
              $pdf->Cell(10,20,$key['id_usu'],0,0,"L");
              $pdf->Cell(60,20,$key['name'],0,0,"L");
              $pdf->Cell(60,20,$key['login'],0,0,"L");
              if ($key['active'] == 'Y') {
                $pdf->Cell(50,20,'Ativo',0,0,"L");
              } else {
                $pdf->Cell(50,20,'Inativo',0,0,"L");
              }
              $pdf->Ln(7);
            }
            $pdf->Ln(10);
            $pdf->SetFont('arial','B',12);
            $pdf->Cell(0,10,'Total de registros: '. $regcount,0,1);
            $pdf->Output("usuarios.pdf","I");
        } else {
            ?>
            <h1>Nenhuma informação disponível.</h1>
            <?php
        }
    } else {
      $query = "SELECT * FROM users";
      //echo $query;exit;
      $query = $conexao->query($query);

      if ($query->rowCount() > 0) {
          $returner = $query->fetchAll();
          $regcount = $query->rowCount();
      } else {
          $returner = "Nenhum registro encontrado!";
      }

      if ($returner != "Nenhum registro encontrado!") {
          require_once("fpdf/fpdf.php");

          class PDF extends FPDF
          {
          // Page header
          function Header()
          {
              // Logo
              $this->Image('../../assets/img/icon.png',10,6,30);
              // Arial bold 15
              $this->SetFont('Arial','B',15);
              // Move to the right
              $this->Cell(80);
              // Title
              $this->Cell(30,10,utf8_decode('Usuários do sistema'),0,0,'C');
              // Line break
              $this->Ln(20);
          }

          // Page footer
          function Footer()
          {
              // Position at 1.5 cm from bottom
              $this->SetY(-15);
              // Arial italic 8
              $this->SetFont('Arial','I',8);
              // Page number
              $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
          }
          }

          // Instanciation of inherited class
          $pdf = new PDF();
          $pdf->AliasNbPages();
          $pdf->AddPage();
          $pdf->SetFont('Times','',12);
          $pdf->Cell(10,20,'ID:',0,0,"L");
          $pdf->Cell(60,20,'Nome',0,0,"L");
          $pdf->Cell(60,20,'Login / Email',0,0,"L");
          $pdf->Cell(50,20,'Status',0,0,"L");
          $pdf->Ln(20);
          foreach ($returner as $key) {
            $pdf->Cell(10,20,$key['id_usu'],0,0,"L");
            $pdf->Cell(60,20,$key['name'],0,0,"L");
            $pdf->Cell(60,20,$key['login'],0,0,"L");
            if ($key['active'] == 'Y') {
              $pdf->Cell(50,20,'Ativo',0,0,"L");
            } else {
              $pdf->Cell(50,20,'Inativo',0,0,"L");
            }
            $pdf->Ln(7);
          }
          $pdf->Ln(10);
          $pdf->SetFont('arial','B',12);
          $pdf->Cell(0,10,'Total de registros: '. $regcount,0,1);
          $pdf->Output("usuarios.pdf","I");
      } else {
          ?>
          <h1>Nenhuma informação disponível.</h1>
          <?php
      }
    }


?>
