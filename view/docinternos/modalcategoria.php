<div id="modalcategoria" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="mdltitulo2"></h4>
                <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                    <i class="font-icon-close-2"></i>
                </button>
            </div>
            <form method="post" id="categoria_form">
                <div class="modal-body">
                    <input type="hidden" id="ent_id" name="ent_id">
                    <div class="row">

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label" for="cat_nombre">Nombre</label>
                                <input type="text" class="form-control" id="cat_nombre" name="cat_nombre" placeholder="Ingrese Nombre" required>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" name="action" id="#" value="add" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
