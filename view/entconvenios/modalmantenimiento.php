<div id="modalmantenimiento" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                    <i class="font-icon-close-2"></i>
                </button>
                <h4 class="modal-title" id="mdltitulo"></h4>
            </div>
            <form method="post" id="convenio_form">
                <div class="modal-body">
                    <input type="hidden" id="con_id" name="con_id">
                    <input type="hidden" id="ent_id" name="ent_id" value="<?php echo htmlspecialchars($_GET['ent_id'] ?? ''); ?>">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label" for="nom_conv">Convenio</label>
                                <input type="text" class="form-control" id="nom_conv" name="nom_conv" placeholder="Ingrese Convenio" oninput="this.value = this.value.toUpperCase()" required>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label" for="con_est">Estado</label>
                                <select id="con_est" name="con_est" class="form-control">
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