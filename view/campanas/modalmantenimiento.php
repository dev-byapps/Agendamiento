<div id="modalmantenimiento" class="modal fade bd-example-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                    <i class="font-icon-close-2"></i>
                </button>
                <h4 class="modal-title" id="mdltitulo"></h4>
            </div>

            <form method="post" id="campana_form">
                <div class="modal-body">

                    <input type="hidden" id="cam_id" name="cam_id">

                    <div class="row">

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="cam_nom">Nombre</label>
                                <input type="text" class="form-control" id="cam_nom" name="cam_nom" placeholder="Ingrese Nombre" oninput="this.value = this.value.toUpperCase()" required>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="cam_est" id="estadoT">Estado</label>
                                <select id="cam_est" name="cam_est" class="form-control">
                                    <option value="1">Activa</option>
                                    <option value="2">Inactiva</option>
                                    <option value="3">Completada</option>
                                    <option value="4">Cierre completo</option>
                                    <option value="5">Terminada</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="fec_ini">Fecha Inicio</label>
                                <div class="input-group date">
                                    <input id="fec_ini" name="fec_ini" type="text" value="" class="form-control" wfd-id="id8" required>
                                    <span class="input-group-addon" style="font-size: 14px;">
                                        <i class="font-icon font-icon-calend"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="fec_fin">Fecha Final</label>
                                <div class="input-group date">
                                    <input id="fec_fin" name="fec_fin" type="text" value="" class="form-control" wfd-id="id9" required>
                                    <span class="input-group-addon" style="font-size: 14px;">
                                        <i class="font-icon font-icon-calend"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="hora_ini">Hora Inicio</label>
                                <div class="input-group clockpicker" data-autoclose="true">
                                    <input type="text" class="form-control" id="hora_ini" value="00:00" required>
                                    <span class="input-group-addon" style="font-size: 14px;">
                                        <span class="glyphicon glyphicon-time font-icon"></span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="hora_fin">Hora Final</label>
                                <div class="input-group clockpicker" data-autoclose="true">
                                    <input type="text" class="form-control" value="24:00" id="hora_fin" required>
                                    <span class="input-group-addon" style="font-size: 14px;">
                                        <span class="glyphicon glyphicon-time font-icon"></span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="grupocc">Grupo Llamada</label>
                                <select id="grupocc" name="grupocc" class="form-control">
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="cam_int">Intentos</label>
                                <div class="input-group bootstrap-touchspin">
                                    <span class="input-group-addon bootstrap-touchspin-prefix" style="display: none;"></span>
                                    <input id="cam_int" type="text" value="0" name="cam_int" class="form-control" style="display: block;" wfd-id="id24" required>
                                    <span class="input-group-addon bootstrap-touchspin-postfix" style="display: none;"></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <textarea id="cam_coment" name="cam_coment" rows="6" class="form-control" placeholder="Comentarios" oninput="this.value = this.value.toUpperCase()"></textarea>
                        </div>

                        <div class="col-lg-12">
                            <br>
                            <label class="form-label semibold" id="cuenta"></label>
                            <label class="form-label semibold" id="agente_vacios"></label>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" name="action" id="guardar" value="add" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
