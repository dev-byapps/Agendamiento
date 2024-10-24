<div id="modalpausa" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                    <i class="font-icon-close-2"></i>
                </button>
                <h4 class="modal-title">Pausa</h4>
            </div>
            <form method="post" id="pausa_form">
                <div class="modal-body">                

                    <div class="row">

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label" for="mot_pau">Motivo</label>
                                <select id="mot_pau" name="mot_pau" class="form-control">
                                    <option value="1">Break</option>
                                    <option value="2">Ausencia</option>
                                    <option value="3">Supervisor</option>
                                    <option value="4">Llamada en Espera</option>
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