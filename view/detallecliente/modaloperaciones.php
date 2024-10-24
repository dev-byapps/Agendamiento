<div id="modaloperaciones" class="modal fade bd-example-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close" id="close">
                    <i class="font-icon-close-2"></i>
                </button>
                <h4 class="modal-title" id="mdltitulop"></h4>
            </div>
            <form method="post" id="operaciones_form">
                <div class="modal-body">
                    <input type="hidden" id="ope_id" name="ope_id" maxlength="20">
                    <div class="row">

                        <div class="col-lg-3">
                            <div class="form-group">
                                <label class="form-label" for="ope_numero">Numero OP</label>
                                <input type="text" class="form-control" id="ope_numero" name="ope_numero" placeholder="Ingrese Numero Operación">
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="form-group">
                                <label class="form-label" for="ope_operacion">Tipo Operación</label>
                                <select class="form-control" id="ope_operacion" name="ope_operacion" placeholder="Ingrese tipo de operacion..." required>
                                    <option value="LIBRE INVERSION">LIBRE INVERSION</option>
                                    <option value="COMPRA DE CARTERA">COMPRA DE CARTERA</option>
                                    <option value="RETANQUEO">RETANQUEO</option>
                                    <option value="SANEAMIENTO">SANEAMIENTO</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="form-group">
                                <label class="form-label" for="ope_entidad">Entidad</label>
                                <select id="ope_entidad" name="ope_entidad" class="form-control">
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="form-group">
                                <label class="form-label" for="ope_sucursal">Sucursal</label>
                                <select id="ope_sucursal" name="ope_sucursal" class="form-control">
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="form-group">
                                <label class="form-label" for="ope_monto">Monto Radicado</label>
                                <input type="text" class="form-control" id="ope_monto" name="ope_monto" placeholder="Ingrese Monto" oninput="this.value = this.value.replace(/[^0-9$.]/g, '')" maxlength="20" required>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="form-group">
                                <label class="form-label" for="ope_maprobado">Monto Desembolsado</label>
                                <input type="text" class="form-control" id="ope_maprobado" name="ope_maprobado" placeholder="Ingrese Monto Aprobado" oninput="this.value = this.value.replace(/[^0-9$.]/g, '')" maxlength="20">
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="form-group">
                                <label class="form-label" for="ope_plazo">Plazo</label>
                                <input type="text" class="form-control" id="ope_plazo" name="ope_plazo" placeholder="Ingrese Monto" oninput="this.value = this.value.replace(/[^0-9]/g, '')" maxlength="3">
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="form-group">
                                <label class="form-label" for="ope_tasa">Tasa</label>
                                <input type="text" class="form-control" id="ope_tasa" name="ope_tasa" placeholder="Ingrese Tasa" oninput="this.value = this.value.replace(/[^0-9.]/g, '')" maxlength="4">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="ope_estadoOP">Estado Entidad</label>
                                <select id="ope_estadoOP" name="ope_estadoOP" class="form-control"></select>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="ope_estado">Estado CRM</label>
                                <input type="text" class="form-control" id="ope_estado" name="ope_estado" required>
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-lg-6" id="cam_fera" hidden="true">
                            <div class="form-group">
                                <label class="form-label" for="ope_feradicacion">Fecha Radicación</label>
                                <div class="input-group date">
                                    <input id="ope_feradicacion" name="ope_feradicacion" type="text" value="" class="form-control" required>
                                    <span class="input-group-addon">
                                        <i id="calen" class="font-icon font-icon-calend"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6" id="cam_feest" hidden="true">
                            <div class="form-group">
                                <label class="form-label" for="ope_festado" >Fecha Estado</label>
                                <div class="input-group date">
                                    <input id="ope_festado" name="ope_festado" type="text" value="" class="form-control" required>
                                    <span class="input-group-addon">
                                        <i id="calen" class="font-icon font-icon-calend"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6" id="fechacierre" hidden="true">
                            <div class="form-group">
                                <label class="form-label" for="ope_fcierre" >Fecha Cierre</label>
                                <div class="input-group date">
                                    <input id="ope_fcierre" type="text" value="" class="form-control" name="ope_fcierre">
                                    <span class="input-group-addon" >
                                        <i class="font-icon font-icon-calend"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-rounded btn-default" data-dismiss="modal" id="btncerrar">Cerrar</button>
                    <button type="submit" name="action" id="btnguardar" value="add" class="btn btn-rounded btn-primary" disable>Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
