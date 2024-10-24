<div id="modalcalendar" class="modal fade bd-example-modal" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                    <i class="font-icon-close-2"></i>
                </button>
                <h4 class="modal-title" id="mdltitcal"></h4>
            </div>

            <form method="post" id="tarea_form">

                <div class="modal-body">
                    <input type="hidden" id="tar_id" name="tar_id">

                    <div class="row">

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label semibold" for="cal_nombre">Nombre</label>
                                <input type="text" class="form-control" name="cal_nombre" id="cal_nombre" placeholder="Agregar Nombre" oninput="this.value = this.value.toUpperCase()" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label semibold" for="cal_des">Descripción</label>
                                <textarea rows="5" class="form-control" id="cal_des" name=""></textarea>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-label semibold" for="hue-demo">Estado</label>

                                <input type="text" id="hue-demo" class="form-control demo" data-control="hue" value="#ff6161">

                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-label semibold" for="cal_est">Estado</label>
                                <select id="cal_est" name="cal_est" class="form-control">
                                    <option>Activo</option>
                                    <option>Inactivo</option>
                                    <option>Eliminado</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-label semibold" for="cal_priv">Privacidad</label>
                                <select id="cal_priv" name="cal_priv" class="form-control">
                                    <option>Privado</option>
                                    <option>Compartido</option>
                                    <option>Publico</option>
                                </select>
                            </div>
                        </div>
                        <br><br>

                        <div class="col-lg-12">
                            <label class="form-label semibold" for="tar_par1">Compartido</label>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <select class="form-control" id="tar_par" name="tar_par">
                                    <option>Grupo</option>
                                    <option>Usuario</option>
                                    <option>Externo</option>
                                </select>
                            </div>
                        </div>


                        <div class="col-lg-5">
                            <div class="form-group">
                                <select class="form-control" id="tar_dat" name="tar_dat" disabled>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-3" id="div_agrpar">
                            <div class="form-group">
                                <button type="button" class="btn btn-success" id="AgrPar">Agregar</button>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <label class="form-label semibold" for="tar_par1">Notificaciones</label>
                        </div>



                        <div class="col-lg-12" id="divcreado">
                            <label class="form-control-label semibold"><span id="creadopor"></span></label>
                            <br>
                        </div>

                        <div class="col-lg-12" id="divcreado">
                            <label class="form-control-label semibold"><span id="creadoen"></span></label>
                            <br>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" name="action" id="#" value="add" class="btn btn-primary" disabled>Guardar</button>
                </div>

            </form>
        </div>
    </div>
</div>