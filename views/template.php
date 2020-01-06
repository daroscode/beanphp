<!DOCTYPE html>
<html lang="pt-br" dir="ltr">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE-edge" />
    <meta http-equiv="Content-Type" content="text/html; charset = UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="imagetoolbar" content="no" />
    <title>beanphp framework</title>
    <meta name="author" content="Daniel Araujo" />
    <meta name="description" content="beanphp framework.">
    <meta name="keywords" content="Framework em PHP e Javascript" />
    <meta name="revised" content="Codkr, 19/09/2019" />
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo BASEURL; ?>assets/img/icon.png">
    <link href="<?php echo BASEURL; ?>assets/lib/dataTables/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="<?php echo BASEURL; ?>assets/lib/bootstrap-4.3.1/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?php echo BASEURL; ?>assets/lib/dataTables/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link href="<?php echo BASEURL; ?>assets/lib/iziToast/dist/css/iziToast.min.css" rel="stylesheet" />
    <link href="<?php echo BASEURL; ?>assets/lib/fontawesome-free-5.10.2/css/all.css" rel="stylesheet" />
    <link href="<?php echo BASEURL; ?>assets/css/style.css" rel="stylesheet" />
    <script type="text/javascript" src="<?php echo BASEURL; ?>assets/lib/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="<?php echo BASEURL; ?>assets/lib/axios/dist/axios.js"></script>
    <script type="text/javascript" src="<?php echo BASEURL; ?>assets/lib/iziToast/dist/js/iziToast.min.js"></script>
    <script type="text/javascript" src="<?php echo BASEURL; ?>assets/lib/sweetalert2@8.js"></script>
    <script type="text/javascript" src="<?php echo BASEURL; ?>assets/lib/dataTables/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?php echo BASEURL; ?>assets/lib/dataTables/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" src="<?php echo BASEURL; ?>assets/lib/bootstrap-4.3.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo BASEURL; ?>assets/lib/fontawesome-free-5.10.2/js/all.js"></script>
    <script type="text/javascript" src="<?php echo BASEURL; ?>assets/js/script.js"></script>
  </head>
  <body oncontextmenu="return false">
  <img src="<?php echo BASEURL; ?>assets/img/loading.gif" alt="Loading page" id="loading_post" style="display: none;position: absolute;z-index: 999;width: 300px;height: 300px;top: 50%;left: 50%;" />
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
        <a href="<?php echo BASEURL; ?>" class="navbar-brand">beanphp framework</a>
        <button class="navbar-toggler" data-toggle="collapse" data-target="#ops">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="ops">
            <u class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a href="<?php echo BASEURL; ?>images" class="nav-link">Imagens</a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo BASEURL; ?>users" class="nav-link">Usuários</a>
                </li>
                <li class="nav-item">
                    <a href="#" data-toggle="modal" class="nav-link" data-target="#users" name="print_users" title="Relação de usuários">Relatório de usuários</a> 
                </li>
                <li class="nav-item">
                    <a href="<?php echo BASEURL; ?>home/logout" class="nav-link">Sair do sistema</a>
                </li>
            </u>
        </div>
    </nav>
    <!-- MODAL IMPRIMIR HISTÓRICO LIGAÇÕES INICIO -->
    <div class="modal fade" id="users" tabindex="-1" role="dialog" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Relatório de usuários cadastrado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="GET" name="usersPrint" id="usersPrint" action="<?php echo BASEURL; ?>assets/rel/users.php" target="_blank">
                    <div class="form-group col-sm-12">
                        <label for="active">Ativo:</label>
                        <input type="radio" name="active" value="Y" /> Sim
                        <input type="radio" name="active" value="N" /> Não
                        <input type="radio" name="active" value="A" checked="checked" /> Todos
                    </div>
                    <hr />
                    <input type="submit" name="print_ligacoes_enter" id="print_ligacoes_enter" value="Gerar relatório" class="btn btn-primary"/>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
            </div>
        </div>
    </div>
	<!-- MODAL IMPRIMIR HISTÓRICO LIGAÇÕES FIM -->
    <div class="container">
      <?php $this->loadViewer($viewName, $viewData_set); ?>
    </div>
  </body>
</html>
