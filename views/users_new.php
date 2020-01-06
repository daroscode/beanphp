<div class="form_design_one">
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
        <a href="<?php echo BASEURL; ?>users" class="btn btn-secondary" title="">Voltar</a>
    </form>
</div>
<script type="text/javascript">
    function setNewUser(){
        var name_nu = $('input[name="name_nu"]').val();
        var login_nu = $('input[name="login_nu"]').val();
        var birthday_nu = $('input[name="birthday_nu"]').val();
        var pass_set = $('input[name="pass_nu"]').val();
        var pass_nu = window.btoa(pass_set);

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
            url: "setNewUser",
            data: items
        }).then(res => {
            var data_return = JSON.stringify(res.data);
                response = JSON.parse(data_return);
            
                if (response.code == "02") {
                    Swal.fire({
                        type: "success",
                        text: response.message
                    }).then(() => {
                        window.location.href = "../users";
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
</script>