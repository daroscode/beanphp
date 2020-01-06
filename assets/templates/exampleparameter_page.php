<div class="form_design_one">
    <form method="POST" name="newUser">
        <div class="form-group">
            <p>Novo registro</p>
            <label for="some">Some:</label>
            <input type="text" name="some_new" class="form-control" />
            <label for="data">Data:</label>
            <input type="text" name="data_new" class="form-control" />
        </div>
        <button type="button" class="btn btn-success" onclick="addData()">Confirmar</button>
        <a href="<?php echo BASEURL; ?>example" class="btn btn-secondary" title="">Voltar</a>
    </form>
</div>
<script type="text/javascript">
    function addData(){
        var some = $('input[name="some_new"]').val();
        var data = $('input[name="data_new"]').val();
        
        if (some == "" || typeof(some) == "undefined") {
            $('input[name="some_new"]').focus();
            iziToast.error({
                title: 'Ops',
                message: "Campo obrigatório!"
            });
            return false;
        }

        if (data == "" || typeof(data) == "undefined") {
            $('input[name="data_new"]').focus();
            iziToast.error({
                title: 'Ops',
                message: "Campo obrigatório!"
            });
            return false;
        }

        let items = new URLSearchParams();
        items.append("some", some);
        items.append("data", data);
        
        axios({
            method: "POST",
            url: "addData",
            data: items
        }).then(res => {
            var data_return = JSON.stringify(res.data);
                response = JSON.parse(data_return);
            
                if (response.code == "02") {
                    Swal.fire({
                        type: "success",
                        text: response.message
                    }).then(() => {
                        window.location.href = "../example";
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