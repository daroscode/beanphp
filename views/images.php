<?php if(count($my_images) > 0): ?>
    <div class="row">
        <h3>Imagens no sistema:</h3>
        <div class="col col-lg-4">
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="images">Escolha sua(s) imagem(ns):</label>
                    <input type="file" accept="image/*" name="images[]" id="images[]" multiple class="form-control" />
                </div>
                <input type="submit" value="Enviar" id="img_new" name="img_new" class="btn btn-primary" />
            </form>
        </div>
        <div class="col col-lg-10">
            <div class="panel panel-default">
                <div class="panel-heading">Imagens atuais</div>
                <div class="panel-body">
                    <?php foreach($my_images as $var): ?>
                        <div class="img_tweaks">
                            <?php if($var['name'] != ""): ?>
                              <h4 class=""><?php echo $var['name']; ?></h4>
                            <?php else: ?>
                              <h4>Título</h4>
                            <?php endif; ?>
                            <div class="">
                              <a href="#" data-toggle="modal" data-target="#image_edit<?php echo $var['id_img']; ?>" class="btn btn-dark" title="Editar imagem"><img src="<?php echo BASEURL; ?>uploads/images/<?php echo $var['fid_usu']; ?>/<?php echo $var['addr']; ?>" class="img-thumbnail" /></a>
                            </div>
                            <?php if($var['description'] != ""): ?>
                              <p class=""><?php echo $var['description']; ?></p>
                            <?php else: ?>
                              <p>Descrição da imagem</p>
                            <?php endif; ?>
                            <div class="">
                                <a href="#" data-toggle="modal" data-target="#image_edit<?php echo $var['id_img']; ?>" class="btn btn-dark" title="Editar imagem">Editar</a> -
                                <button type="button" class="btn btn-danger" onclick="setDelImg(<?php echo $var['id_img']; ?>)">Excluir</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php foreach($my_images as $var): ?>
            <!-- MODAL EDITAR INICIO -->
            <div class="modal fade" id="image_edit<?php echo $var['id_img']; ?>" tabindex="-1" role="dialog" aria-labelledby="EditarRegistro">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <form method="POST" name="editUser">
                                <div class="form-group">
                                    <p>Editar imagem</p>
                                    <label for="name">Nome:</label>
                                    <input type="text" id="name" name="name" class="form-control" required="required" value="<?php echo $var['name']; ?>" placeholder="Título de sua foto" />
                                    <img src="<?php echo BASEURL; ?>uploads/images/<?php echo $var['fid_usu']; ?>/<?php echo $var['addr']; ?>" class="" />
                                    <label for="description">Desrição:</label>
                                    <input type="text" id="description" name="description" class="form-control" required="required" value="<?php echo $var['description']; ?>" placeholder="Descrição de sua foto." />
                                    <input type="hidden" name="id_img" id="id_img" value="<?php echo $var['id_img']; ?>" />
                                </div>
                                <input type="submit" value="Atualizar" id="img_edit" name="img_edit" class="btn btn-primary" />
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- MODAL EDITAR FIM -->
            <?php endforeach; ?>
        </div>
    </div>
<?php else: ?>
    <div class="">
    <h3>Imagens no sistema:</h3>
    <h1>Ops! Você ainda não postou nenhuma imagem!</h1>
        <div class="col-sm-4">
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="images">Escolha sua(s) imagem(ns):</label>
                    <input type="file" accept="image/*" name="images[]" id="images[]" multiple class="form-control" />
                </div>
                <input type="submit" value="Enviar" id="img_new" name="img_new" class="btn btn-primary" />
            </form>
        </div>
    </div>
<?php endif; ?>

<script type="text/javascript">
    function setDelImg(id_img){
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
                    items.append("id_img", id_img);

                    axios({
                        method: "POST",
                        url: "images/setDelImg",
                        data: items
                    }).then(res => {
                        var data_return = JSON.stringify(res.data);
                            response = JSON.parse(data_return);

                        if (response.code == "18") {
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