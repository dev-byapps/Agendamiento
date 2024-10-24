<div id="modalmantenimiento" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                    <i class="font-icon-close-2"></i>
                </button>
                <h4 class="modal-title" id="mdltitulo"></h4>
            </div>
            <form method="post" id="estadoent_form">
                <div class="modal-body">
                    <input type="hidden" id="est_id" name="est_id">
                    <input type="hidden" id="ent_id" name="ent_id" value="<?php echo htmlspecialchars($_GET['ent_id'] ?? ''); ?>">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label" for="est_ent">Estado Entidad</label>
                                <input type="text" class="form-control" id="est_ent" name="est_ent"placeholder="Ingrese Estado" oninput="this.value = this.value.toUpperCase()" required>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label" for="est_crm">Estado CRM</label>
                                <select id="est_crm" name="est_crm"class="form-control">
                                    <option value="Radicacion">Radicación</option>
                                    <option value="Proceso">Proceso</option>
                                    <option value="Devolucion">Devolución</option>
                                    <option value="Negado">Negado</option>
                                    <option value="Desembolsado">Desembolsado</option>
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