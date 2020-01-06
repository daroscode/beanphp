<h2>Usuários no sistema:</h2>
<hr />
<a href="<?php echo BASEURL; ?>users/users_new" class="btn btn-primary" title="Novo registro">
    <i class="fas fa-plus"></i>
    Novo resgistro
</a>
<hr />
<table class="table table-striped table-bordered" style="width: 100%;" id="tbUsuarios">
    <thead>
        <tr>
            <th class="header_treat">Código:</th>
            <th class="header_treat">Foto:</th>
            <th class="header_treat">Login / Email:</th>
            <th class="header_treat">Nome:</th>
            <th class="header_treat">Dt. Nasc.:</th>
            <th class="header_treat">Ativo:</th>
            <th class="header_treat" style="text-align:right">Opções</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($users as $usu): ?>
            <tr>
                <td><?php echo $usu['cod_usu']; ?></td>
                <?php if($usu['image'] != ''): ?>
                  <td align="center"><img src="<?php echo BASEURL; ?>uploads/user/<?php echo $usu['id_usu']; ?>/<?php echo $usu['image']; ?>" class="img-thumbail" style="height:3rem;width:3rem;" /> </td>
                <?php else: ?>
                  <td title="Sem imagem disponível" align="center"><i class="fas fa-portrait"></i></td>
                <?php endif; ?>
                <td><?php echo $usu['login']; ?></td>
                <td><?php echo $usu['name']; ?></td>
                <td><?php echo date("d/m/Y", strtotime($usu['birthday'])); ?></td>
                <?php if($usu['active'] == "Y"): ?>
                  <td>Sim</td>
                <?php else: ?>
                  <td>Não</td>
                <?php endif; ?>
                <td style="text-align:right">
                    <a href="#" data-toggle="modal" data-target="#image<?php echo $usu['id_usu']; ?>" class="btn btn-info" title="Editar imagem"><i class="fas fa-user"></i></a>
                    <a href="#" data-toggle="modal" data-target="#edit<?php echo $usu['id_usu']; ?>" class="btn btn-secondary" title="Editar registro"><i class="fas fa-edit"></i></a>
                    <button type="button" class="btn btn-danger" onclick="setDelUser(<?php echo $usu['id_usu']; ?>)"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
        <!-- MODAL IMAGEM INICIO -->
        <div class="modal fade" id="image<?php echo $usu['id_usu']; ?>" tabindex="-1" role="dialog" aria-labelledby="EditarRegistro" data-backdrop="static">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <form method="POST" name="imagetUser" enctype="multipart/form-data">
                            <div class="form-group">
                                <p>Editar imagem de usuário</p>
                                <label for="name">Nome:</label>
                                <input type="text" name="user_name" class="form-control" value="<?php echo $usu['name']; ?>" readonly />
                                <label for="image">Nova imagem:</label>
                                <input type="file" accept="image/*" name="user_image" class="form-control" />
                                <input type="hidden" name="id_usu" value="<?php echo $usu['id_usu']; ?>" />
                            </div>
                            <!-- <input type="submit" value="Confirmar" name="imageUserDone" class="btn btn-success" /> -->
                            <button type="button" class="btn btn-primary" onclick="setUserImg(<?php echo $usu['id_usu']; ?>)">Confirmar</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- MODAL IMAGEM FIM -->
        <!-- MODAL EDITAR INICIO -->
        <div class="modal fade" id="edit<?php echo $usu['id_usu']; ?>" tabindex="-1" role="dialog" aria-labelledby="EditarRegistro" data-backdrop="static">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <form method="POST" name="editUser">
                            <div class="form-group">
                                <p>Editar registro de usuário</p>
                                <label for="active">Ativo:</label>
                                <input type="radio" name="user_active" value="Y" class="user_active" <?php echo ($usu['active'] == "Y"?'checked="checked"':''); ?>> Sim
                                <input type="radio" name="user_active" value="N" class="user_active" <?php echo ($usu['active'] == "N"?'checked="checked"':''); ?>> Não
                                <br />
                                <label for="name">Nome:</label>
                                <input type="text" name="user_name" class="form-control" value="<?php echo $usu['name']; ?>" />
                                <label for="username">Login / Email:</label>
                                <input type="text" name="user_login" class="form-control" value="<?php echo $usu['login']; ?>" />
                                <label for="age">Idade:</label>
                                <input type="date" name="user_birthday" class="form-control" value="<?php echo $usu['birthday']; ?>" />
                                <label for="pass">Nova senha:</label>
                                <input type="password" name="user_pass" class="form-control" placeholder="Digite nova senha se deseja alterar" />
                            </div>
                            <button type="button" class="btn btn-success" onclick="setEditUser(<?php echo $usu['id_usu']; ?>)">Confirmar</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- MODAL EDITAR FIM -->
        <?php endforeach; ?>
    </tbody>
</table>
<hr />

<script type="text/javascript">
    $(document).ready( function () {
            $('#tbUsuarios').DataTable({
            "pageLength" : 10,
            "filter" : true,
            "deferRender" : true,
            "scrollY" : 500,
            "scrollCollapse" : true,
            "scroller" : true,
            "language": {
                "lengthMenu": "Mostrando _MENU_  registros por página",
                "zeroRecords": "Nada encontrado",
                "info": "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty": "Nenhum registro disponível",
                "infoFiltered": "(filtrado de _MAX_ registros no total)"
            }
        });
    });

    function setEditUser(id_usu){
        var user_active = document.querySelector('#edit' + id_usu +' .user_active:checked').value;
        var user_name = $('#edit' + id_usu +' input[name="user_name"]').val();
        var user_login = $('#edit' + id_usu +' input[name="user_login"]').val();
        var user_birthday = $('#edit' + id_usu +' input[name="user_birthday"]').val();
        var user_pass_set = $('#edit' + id_usu +' input[name="user_pass"]').val();
        var user_pass = window.btoa(user_pass_set);
        
        if (user_name == "" || typeof(user_name) == "undefined") {
            $('input[name="user_name"]').focus();
            iziToast.error({
                title: 'Ops',
                message: "Campo obrigatório!"
            });
            return false;
        }

        if (user_login == "" || typeof(user_login) == "undefined") {
            $('input[name="user_login"]').focus();
            iziToast.error({
                title: 'Ops',
                message: "Campo obrigatório!"
            });
            return false;
        }

        if (user_birthday == "" || typeof(user_birthday) == "undefined") {
            $('input[name="user_birthday"]').focus();
            iziToast.error({
                title: 'Ops',
                message: "Campo obrigatório!"
            });
            return false;
        }

        let items = new URLSearchParams();
        items.append("id_usu", id_usu);
        items.append("user_active", user_active);
        items.append("user_name", user_name);
        items.append("user_login", user_login);
        items.append("user_birthday", user_birthday);
        items.append("user_pass", user_pass);

        axios({
            method: "POST",
            url: "users/setEditUser",
            data: items
        }).then(res => {
            var data_return = JSON.stringify(res.data);
				response = JSON.parse(data_return);
            
            if (response.code == "14") {
                $("#edit" + id_usu).modal("hide");
                Swal.fire({
                    type: "success",
                    text: response.message
                }).then(() => {
                    location.reload();
                });                             
            } else if (response.code == "13") {
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

    function setUserImg(id_usu){
        var user_image = $('#image' + id_usu +' input[name="user_image"]')[0].files[0];
        
        if (user_image == "" || typeof(user_image) == "undefined") {
            $('#image' + id_usu +' input[name="user_image"]').focus();
            iziToast.error({
                title: 'Ops',
                message: "Campo IMAGEM é obrigatório!"
            });
            return false;
        } else {
            $("#loading_post").show();
        }

        var items = new FormData();
        items.append("id_usu", id_usu);
        items.append("user_image", user_image);

        axios({
            method: "POST",
            url: "users/setUserImg",
            data: items
        }).then(res => {
            var data_return = JSON.stringify(res.data);
                response = JSON.parse(data_return);

            if (response.code == "17") {
                $("#image" + id_usu).hide();
                $("#loading_post").hide();
                Swal.fire({
                    type: "success",
                    text: response.message
                }).then(() => {
                    location.reload();
                }); 
            }

            if(response.code == "18"){
                $("#image" + id_usu).hide();
                $("#loading_post").hide();
                iziToast.error({
                    title: 'Ops... ',
                    message: response.message
                });
                return false;
            }

        }).catch(function(error){
            console.log(error);
        });


    }

    function setDelUser(id_usu){
        iziToast.question({
            timeout: 20000,
            close: false,
            overlay: true,
            displayMode: 'once',
            id: 'question',
            zindex: 999,
            title: "Deletar",
            message: 'Quer mesmo deletar este registro? Este processo não tem volta!',
            position: 'center',
            buttons: [
                ['<button>Sim, por favor!</button>', function (instance, toast) {

                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                    let items = new URLSearchParams();
                    items.append("id_usu", id_usu);

                    axios({
                        method: "POST",
                        url: "users/setDelUser",
                        data: items
                    }).then(res => {
                        var data_return = JSON.stringify(res.data);
                            response = JSON.parse(data_return);

                        if (response.code == "16") {
                            Swal.fire({
                                type: "success",
                                text: response.message
                            }).then(() => {
                                location.reload();
                            });    
                        }

                        if (response.code == "15") {
                            window.location.href = "welcome";   
                        }

                    }).catch(function(error){
                        console.log(error);
                    });

                }, true],
                ['<button><b>Não! Mudei de ideia.</b></button>', function (instance, toast) {

                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                    iziToast.info({
                        title: 'Ok! ',
                        message: "Registro mantido!"
                    });
                    return false;

                }],
            ]
        });
    }
</script>