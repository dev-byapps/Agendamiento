<div id="modalmantenimiento" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                    <i class="font-icon-close-2"></i>
                </button>
                <h4 class="modal-title" id="mdltitulo"></h4>
            </div>
            <form method="post" id="sucent_form">
                <div class="modal-body">
                    <input type="hidden" id="suc_id" name="suc_id">
                    <input type="hidden" id="ent_id" name="ent_id" value="<?php echo htmlspecialchars($_GET['ent_id'] ?? ''); ?>">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="cod_suc">Codigo sucursal</label>
                                <input type="text" class="form-control" id="cod_suc" name="cod_suc" placeholder="Ingrese Codigo de Sucursal" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="nom_suc">Nombre Sucursal</label>
                                <input type="text" class="form-control" id="nom_suc" name="nom_suc" placeholder="Ingrese Nombre de Sucursal" oninput="this.value = this.value.toUpperCase()" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="dept_suc">Departamento</label>
                                <!-- <select id="dept_suc" name="dept_suc" class="form-control"></select> -->
                                <input type="text" class="form-control" id="dept_suc" name="dept_suc" placeholder="Ingrese Departamento" oninput="this.value = this.value.toUpperCase()" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="city_suc">Ciudad</label>
                                <!-- <select id="city_suc" name="city_suc" class="form-control"></select> -->
                                <input type="text" class="form-control" id="city_suc" name="city_suc" placeholder="Ingrese ciudad" oninput="this.value = this.value.toUpperCase()" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="est_suc">Estado</label>
                                <select id="est_suc" name="est_suc" class="form-control">
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