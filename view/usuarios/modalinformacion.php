<div id="modalinformacion" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                    <i class="font-icon-close-2"></i>
                </button>
                <h4 class="modal-title" id="mdltitulo"></h4>
            </div>
            <form method="post" id="info_form">
                <div class="modal-body">
                    <input type="hidden" id="usuid" name="usuid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label" for="usu_fenac">Fecha de Nacimiento</label>
                                <div class='input-group date'>
                                    <input id="usu_fenac" name="usu_fenac" type="text" class="form-control" placeholder="dd/mm/aaaa" required>
                                    <span class="input-group-addon">
                                        <i class="font-icon font-icon-calend"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="usu_tel">Teléfono</label>
                                <input type="text" class="form-control" id="usu_tel" name="usu_tel" placeholder="Ingrese Telefono" oninput="this.value = this.value.replace(/[^0-9]/g, '')" maxlength="13" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="usu_cel">Celular</label>
                                <input type="text" class="form-control" id="usu_cel" name="usu_cel" placeholder="Ingrese Celular" oninput="this.value = this.value.replace(/[^0-9]/g, '')" maxlength="13" required>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label" for="usu_dir">Direccion</label>
                                <input type="text" class="form-control" id="usu_dir" name="usu_dir" placeholder="Ingrese Dirección" oninput="this.value = this.value.toUpperCase();" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="usu_ciu">Ciudad</label>
                                <input type="text" class="form-control" id="usu_ciu" name="usu_ciu" placeholder="Ingrese Ciudad" oninput="this.value = this.value.replace(/[^A-Za-z ]/g, '').toUpperCase()" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="usu_dep">Departamento</label>
                                <input type="text" class="form-control" id="usu_dep" name="usu_dep" placeholder="Ingrese Departamento" oninput="this.value = this.value.replace(/[^A-Za-z ]/g, '').toUpperCase()" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-rounded btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="button" name="action" id="guardarform" value="add" class="btn btn-rounded btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>