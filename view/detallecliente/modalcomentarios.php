<div id="modalcomentarios" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                    <i class="font-icon-close-2"></i>
                </button>
                <h4 class="modal-title">Agregar Comentario</h4>
            </div>
            <div class="box-typical box-typical-padding" id="pnlcoments">
                <div class="row">

                <?php if ($_SESSION["usu_perfil"] != "Asesor" && $_SESSION["usu_perfil"] != "Coordinador") {?>
                    <div class="col-lg-12">
                        <div class="checkbox-toggle">
                            <input type="checkbox" id="com_pri">
                            <label for="com_pri" id="com_pri_label">Publico</label>
                        </div>
                    </div>
                <?php }?>

                    <div class="col-lg-12">
                        <label class="form-label semibold" for="com_coment">Descripción</label>
                        <div class="summernote-theme-1">
                            <textarea id="com_coment" name="com_coment" class="summernote" name="name"></textarea>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button type="button" id="btnenvcoment" class="btn btn-primary">Guardar</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
