<div id="modalmantenimiento" class="modal fade bd-example-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                    <i class="font-icon-close-2"></i>
                </button>
                <h4 class="modal-title" id="mdltitulo"></h4>
            </div>
            <form method="post" id="grupocc_form">
                <div class="modal-body">
                    <input type="hidden" id="cc_id" name="cc_id">
                    <div class="row">

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="cc_nombre">Nombre</label>
                                <input type="text" class="form-control" id="cc_nombre" name="cc_nombre" placeholder="Ingrese Nombre" oninput="this.value = this.value.toUpperCase()" required>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="cc_estado">Estado</label>
                                <select id="cc_estado" name="cc_estado" class="form-control">
                                    <option value="1">Activo</option>
                                    <option value="2">Inactivo</option>
							    </select>
                            </div>
                        </div>

                        <div class="col-lg-12">
                                <textarea id="cc_comentario" name="cc_comentario" rows="6" class="form-control" placeholder="Comentarios" oninput="this.value = this.value.toUpperCase()"></textarea>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-rounded btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" name="action" id="#" value="add" class="btn btn-rounded btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
