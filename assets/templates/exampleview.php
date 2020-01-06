<h2>Clientes no sistema:</h2>
<hr />
<a href="<?php echo BASEURL; ?>example/parameter_page" class="btn btn-primary" title="Novo registro">
    <i class="fas fa-plus"></i>
    Novo resgistro
</a>
<hr />
<table class="table table-striped table-bordered" style="width: 100%;" id="tbData">
    <thead>
        <tr>
            <th class="header_treat">Código:</th>
            <th class="header_treat">Some:</th>
            <th class="header_treat">Data:</th>
            <th class="header_treat" style="text-align:right">Opções</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($example as $ex): ?>
            <tr>
                <td><?php echo $ex['code']; ?></td>
                <td><?php echo $ex['some']; ?></td>
                <td><?php echo $ex['data']; ?></td>
                <td style="text-align:right">
                    <a href="#" data-toggle="modal" data-target="#edit<?php echo $ex['some_id']; ?>" class="btn btn-secondary" title="Editar registro"><i class="fas fa-edit"></i></a>
                    <button type="button" class="btn btn-danger" onclick="setDelUser(<?php echo $usu['some_id']; ?>)"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
        <!-- MODAL EDITAR INICIO -->
        <div class="modal fade" id="edit<?php echo $ex['some_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="EditarRegistro" data-backdrop="static">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <form method="POST" name="editUser">
                            <div class="form-group">
                                <p>Editar registro</p>
                                <label for="some">Some:</label>
                                <input type="text" name="some_edit" class="form-control" value="<?php echo $ex['some']; ?>" />
                                <label for="data">Data:</label>
                                <input type="text" name="data_edit" class="form-control" value="<?php echo $ex['data']; ?>" />
                            </div>
                            <button type="button" class="btn btn-success" onclick="editData(<?php echo $ex['some_id']; ?>)">Confirmar</button>
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
            $('#tbData').DataTable({
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

    function editData(some_id){
        var some = $('#edit' + some_id +' input[name="some_edit"]').val();
        var data = $('#edit' + some_id +' input[name="data_edit"]').val();
        
        if (some == "" || typeof(some) == "undefined") {
            $('input[name="some_edit"]').focus();
            iziToast.error({
                title: 'Ops',
                message: "Campo obrigatório!"
            });
            return false;
        }

        if (data == "" || typeof(data) == "undefined") {
            $('input[name="data_edit"]').focus();
            iziToast.error({
                title: 'Ops',
                message: "Campo obrigatório!"
            });
            return false;
        }

        let items = new URLSearchParams();
        items.append("some_id", some_id);
        items.append("some", some);
        items.append("data", data);

        axios({
            method: "POST",
            url: "example/editData",
            data: items
        }).then(res => {
            var data_return = JSON.stringify(res.data);
				response = JSON.parse(data_return);
            
            if (response.code == "14") {
                $("#edit" + some_id).modal("hide");
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

    function delData(some_id){
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
                    items.append("some_id", some_id);

                    axios({
                        method: "POST",
                        url: "example/delData",
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
