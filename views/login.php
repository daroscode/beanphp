<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE-edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta http-equiv="imagetoolbar" content="no" />
        <title>beanphp framework | login</title>
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo BASEURL; ?>assets/img/icon.png">
        <link href="<?php echo BASEURL; ?>assets/lib/bootstrap-4.3.1/css/bootstrap.min.css" rel="stylesheet" />
        <link href="<?php echo BASEURL; ?>assets/lib/iziToast/dist/css/iziToast.min.css" rel="stylesheet" />
        <link href="<?php echo BASEURL; ?>assets/lib/fontawesome-free-5.10.2/css/all.css" rel="stylesheet" />
        <link href="<?php echo BASEURL; ?>assets/css/style.css" rel="stylesheet" />
    </head>
    <body oncontextmenu="return false">
        <div class="container">
            <div class="login_design">
                <p>Company login:</p>
                <form method="post">
                    <div class="form-group">
                        <label for="email">Login / Email:</label>
                        <input type="text" name="login" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label for="pass">Senha:</label>
                        <input type="password" name="pass" class="form-control" />
                    </div>
                    <button type="button" class="btn btn-success" onclick="logIn()">Entrar</button>
                    <a href="<?php echo BASEURL; ?>" class="btn btn-secondary">Voltar</a>
                </form>
                <a href="#" data-toggle="modal" data-target="#new_pass" class="btn btn-dark" title="Esqueceu a senha" style="margin-top:30px;">Esqueceu a senha?</a>
                <a href="#" data-toggle="modal" data-target="#new_user" class="btn btn-white" title="Novo usuário?">Novo usuário?</a>
            </div>
            <div class="login_links">
                <a href="https://github.com/codkrm/beanphp" target="_blank" title="Github"><i class="fab fa-github"></i> Github</a>
                <a href="https://codkr.com/" target="_blank" title="Site oficial"><i class="fas fa-globe"></i> Site oficial</a>
            </div>
        </div>
        <!-- MODAL NOVO USUARIO INICIO -->
        <div class="modal fade" id="new_user" tabindex="-1" role="dialog" aria-labelledby="NovoRegistro" data-backdrop="static">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <form method="POST" name="newUser">
                            <div class="form-group">
                                <p>Novo registro de usuário</p>
                                <label for="name">Nome:</label>
                                <input type="text" name="name_nu" class="form-control" />
                                <label for="username">Login / Email:</label>
                                <input type="text" name="login_nu" class="form-control" />
                                <label for="birthday">Idade:</label>
                                <input type="date" name="birthday_nu" class="form-control" />
                                <label for="pass">Senha:</label>
                                <input type="password" name="pass_nu" class="form-control" />
                            </div>
                            <button type="button" class="btn btn-success" onclick="setNewUser()">Confirmar</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- MODAL NOVO USUARIO FIM -->
        <!-- MODAL ESQUECEU A SENHA INICIO -->
        <div class="modal fade" id="new_pass" tabindex="-1" role="dialog" aria-labelledby="new_pass" data-backdrop="static">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <form method="POST" name="new_password">
                            <div class="form-group">
                                <p>Esqueceu sua senha?</p>
                                <label for="username">Login / Email:</label>
                                <input type="email" name="login_np" class="form-control" />
                                <label for="pass">Nova senha:</label>
                                <input type="password" name="pass_np" class="form-control" />
                            </div>
                            <button type="button" class="btn btn-warning" onclick="setNewPass()">Alterar senha</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- MODAL ESQUECEU A SENHA FIM -->
        <script type="text/javascript" src="<?php echo BASEURL; ?>assets/lib/jquery-3.4.1.min.js"></script>
        <script type="text/javascript" src="<?php echo BASEURL; ?>assets/lib/axios/dist/axios.js"></script>
        <script type="text/javascript" src="<?php echo BASEURL; ?>assets/lib/iziToast/dist/js/iziToast.min.js"></script>
        <script type="text/javascript" src="<?php echo BASEURL; ?>assets/lib/sweetalert2@8.js"></script>
        <script type="text/javascript" src="<?php echo BASEURL; ?>assets/lib/bootstrap-4.3.1/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo BASEURL; ?>assets/lib/fontawesome-free-5.10.2/js/all.js"></script>
        <script type="text/javascript" src="<?php echo BASEURL; ?>assets/js/script.js"></script>
        <script type="text/javascript">
            function logIn(){
                var login = $('input[name="login"]').val();
                var pass_set = $('input[name="pass"]').val();
                var pass = window.btoa(pass_set);
                
                if (login == "" || typeof(login) == "undefined") {
                    $('input[name="login"]').focus();
                    iziToast.error({
                        title: 'Ops',
                        message: "Campo obrigatório!"
                    });
                    return false;
                }

                if (pass_set == "" || typeof(pass_set) == "undefined") {
                    $('input[name="pass"]').focus();
                    iziToast.error({
                        title: 'Ops',
                        message: "Campo obrigatório!"
                    });
                    return false;
                }

                let items = new URLSearchParams();
                items.append("login", login);
                items.append("pass", pass);

                axios({
                    method: "POST",
                    url: "login/logIn",
                    data: items
                }).then(res => {
                    var data_return = JSON.stringify(res.data);
                        response = JSON.parse(data_return);
                    
                    if (response.code == "08") {
                        console.log(response.message);
                        window.location.href = "home";                           
                    } else if (response.code == "09") {
                        iziToast.error({
                                title: 'Ops... ',
                                message: response.message
                        });
                        return false;
                    } else if(response.code == "10"){
                        iziToast.error({
                                title: 'Ops... ',
                                message: response.message
                        });
                        return false;
                    } else if(response.code == "11"){
                        iziToast.error({
                                title: 'Ops... ',
                                message: response.message
                        });
                        return false;
                    } else if(response.code == "12"){
                        iziToast.error({
                                title: 'Ops... ',
                                message: response.message
                        });
                        return false;
                    } else {
                        iziToast.error({
                                title: 'Ops... ',
                                message: "Ocorreu algum problema!"
                        });
                        return false;
                    }

                }).catch(function(error){
                    console.log(error);
                });

            }

            function setNewUser(){
                var name_nu = $('input[name="name_nu"]').val();
                var login_nu = $('input[name="login_nu"]').val();
                var birthday_nu = $('input[name="birthday_nu"]').val();
                var pass_nu = $('input[name="pass_nu"]').val();

                if (name_nu == "" || typeof(name_nu) == "undefined") {
                    $('input[name="name_nu"]').focus();
                    iziToast.error({
                        title: 'Ops',
                        message: "Campo obrigatório!"
                    });
                    return false;
                }

                if (login_nu == "" || typeof(login_nu) == "undefined") {
                    $('input[name="login_nu"]').focus();
                    iziToast.error({
                        title: 'Ops',
                        message: "Campo obrigatório!"
                    });
                    return false;
                }

                if (birthday_nu == "" || typeof(birthday_nu) == "undefined") {
                    $('input[name="birthday_nu"]').focus();
                    iziToast.error({
                        title: 'Ops',
                        message: "Campo obrigatório!"
                    });
                    return false;
                }

                if (pass_nu == "" || typeof(pass_nu) == "undefined") {
                    $('input[name="pass_nu"]').focus();
                    iziToast.error({
                        title: 'Ops',
                        message: "Campo obrigatório!"
                    });
                    return false;
                }

                let items = new URLSearchParams();
                items.append("name_nu", name_nu);
                items.append("login_nu", login_nu);
                items.append("birthday_nu", birthday_nu);
                items.append("pass_nu", pass_nu);

                axios({
                    method: "POST",
                    url: "login/setNewUser",
                    data: items
                }).then(res => {
                    var data_return = JSON.stringify(res.data);
                        response = JSON.parse(data_return);
                    
                    if (response.code == "02") {
                        $("#new_user").modal("hide");
                        Swal.fire({
                            type: "success",
                            text: response.message
                        });                             
                    } else if (response.code == "03") {
                        iziToast.error({
                                title: 'Ops... ',
                                message: response.message
                        });
                        return false;
                    } else {
                        iziToast.error({
                                title: 'Ops... ',
                                message: "Ocorreu algum problema!"
                        });
                        return false;
                    }

                }).catch(function(error){
                    console.log(error);
                });

            }

            function setNewPass(){
                var login_np = $('input[name="login_np"]').val();
                var pass_set = $('input[name="pass_np"]').val();
                var pass_np = window.btoa(pass_set);
                
                if (login_np == "" || typeof(login_np) == "undefined") {
                    $('input[name="login_np"]').focus();
                    iziToast.error({
                        title: 'Ops',
                        message: "Campo obrigatório!"
                    });
                    return false;
                }

                if (pass_set == "" || typeof(pass_set) == "undefined") {
                    $('input[name="pass_np"]').focus();
                    iziToast.error({
                        title: 'Ops',
                        message: "Campo obrigatório!"
                    });
                    return false;
                }

                let items = new URLSearchParams();
                items.append("login_np", login_np);
                items.append("pass_np", pass_np);

                axios({
                    method: "POST",
                    url: "login/setNewPass",
                    data: items
                }).then(res => {
                    var data_return = JSON.stringify(res.data);
                        response = JSON.parse(data_return);
                    
                    if (response.code == "06") {
                        $("#new_pass").modal("hide");
                        Swal.fire({
                            type: "success",
                            text: response.message
                        }).then(() => {
                            location.reload();
                        });                             
                    } else if (response.code == "07") {
                        iziToast.error({
                                title: 'Ops... ',
                                message: response.message
                        });
                        return false;
                    } else {
                        iziToast.error({
                                title: 'Ops... ',
                                message: "Ocorreu algum problema!"
                        });
                        return false;
                    }

                }).catch(function(error){
                    console.log(error);
                });

            }
        </script>
    </body>
</html>
