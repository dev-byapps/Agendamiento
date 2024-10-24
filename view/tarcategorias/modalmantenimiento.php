<div id="modalmantenimiento" class="modal fade bd-example-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                    <i class="font-icon-close-2"></i>
                </button>
                <h4 class="modal-title" id="mdltitulo"></h4>
            </div>
            <form method="post" id="tarcat_form">
                <div class="modal-body">
                    <input type="hidden" id="catar_id" name="catar_id">
                    <div class="row">

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label" for="cat_tar">Categoria</label>
                                <input type="text" class="form-control" id="cat_tar" name="cat_tar" placeholder="Ingrese Ciudad" oninput="this.value = this.value.toUpperCase()" required>

                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label" for="est_catar">Estado</label>
                                <select id="est_catar" name="est_catar" class="form-control">
                                    <option value="1">Activo</option>
                                    <option value="2">Inactivo</option>
                                </select>
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
