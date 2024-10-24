<style>
    #tar_com~.note-editor .note-editable {
        min-height: 300px !important;
        height: 300px !important;
    }
</style>

<div id="modaltarea" class="modal fade bd-example-modal" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                    <i class="font-icon-close-2"></i>
                </button>
                <h4 class="modal-title" id="mdltitulo"></h4>
            </div>

            <form method="post" id="tarea_form">

                <div class="modal-body">
                    <input type="hidden" id="tar_id" name="tar_id">

                    <div class="row">

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label semibold" for="tar_titulo">Título</label>
                                <input type="text" class="form-control" name="tar_titulo" id="tar_titulo" placeholder="Agregar Título" oninput="this.value = this.value.toUpperCase()" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label semibold" for="tar_des">Descripción</label>
                                <div class="summernote-theme-1">
                                    <textarea id="tar_des" name="tar_des" class="summernote" name="name"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-label semibold" for="tar_cat">Categoria</label>
                                <select class="form-control" id="tar_cat" name="tar_cat">
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-label semibold" for="tar_est">Estado</label>
                                <select id="tar_est" name="tar_est" class="form-control">
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-label semibold" for="tar_pri">Prioridad</label>
                                <div class="btn-group" data-toggle="buttons">
                                    <label class="btn btn-sm active" id="label-bajo">
                                        <input type="radio" name="tar_pri" id="Bajo" value="Bajo" autocomplete="off" checked> BAJO
                                    </label>
                                    <label class="btn btn-sm" id="label-medio">
                                        <input type="radio" name="tar_pri" id="Medio" value="Medio" autocomplete="off"> MEDIO
                                    </label>
                                    <label class="btn btn-sm" id="label-alto">
                                        <input type="radio" name="tar_pri" id="Alto" value="Alto" autocomplete="off"> ALTO
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                        </div>

                        <div class="col-lg-12">
                            <div class="checkbox-toggle">
                                <input type="checkbox" id="check-toggle-1" name="todo_dia" style="cursor: pointer;">
                                <label for="check-toggle-1">Todo el día</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group date">
                                    <input id="tar_fcierre" name="tar_fcierre" type="text" class="form-control" required>
                                    <span class="input-group-addon">
                                        <i id="calen" class="font-icon font-icon-calend"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="input-group date datetimepicker-2">
                                    <input type="hidden" name="horaini_hidden" id="horaini_hidden" value="">
                                    <input type="text" class="form-control" id="campo1" name="horaini">
                                    <span class="input-group-addon">
                                        <i class="font-icon font-icon-clock"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="input-group date datetimepicker-2">
                                    <input type="hidden" name="horafin_hidden" id="horafin_hidden" value="">
                                    <input type="text" class="form-control" id="campo2" name="horafin">
                                    <span class="input-group-addon">
                                        <i class="font-icon font-icon-clock"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label semibold" for="tar_ubi">Ubicación</label>
                                <input type="text" class="form-control" id="tar_ubi" name="tar_ubi">
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label semibold" for="tar_cal">Calendario</label>
                                <select class="form-control" id="tar_cal" name="tar_cal">
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <label class="form-label semibold" for="tar_not">Notificaciones</label>
                        </div>

                        <div class="col-lg-5">
                            <div class="form-group">
                                <select class="form-control" id="tar_not" name="tar_not_1">
                                    <option data-icon="font-icon-home" value="Notificacion">Notificación</option>
                                    <option data-icon="font-icon-cart" value="Correo Electronico">Correo Electronico</option>
                                    <option data-icon="font-icon-cart" value="Whatsapp">Whatsapp</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-2">
                            <div class="form-group">
                                <input type="text" class="form-control" id="tar_min" name="tar_min_1" maxlength="3" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="form-group">
                                <select class="form-control" id="tar_tie" name="tar_tie_1">
                                    <option data-icon="font-icon-home">Minutos</option>
                                    <option data-icon="font-icon-cart">Horas</option>
                                    <option data-icon="font-icon-cart">Dias</option>
                                    <option data-icon="font-icon-cart">Semana</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-2" id="div_agrnot">
                            <div class="form-group">
                                <button type="button" class="btn btn-primary" id="AgrNot">Agregar</button>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <label class="form-label semibold" for="tar_par1">Participantes</label>
                        </div>

                        <div class="col-lg-3">
                            <div class="form-group">
                                <select class="form-control" id="tar_par_1" name="tar_par_1">
                                    <option data-icon="font-icon-home">Usuario</option>
                                    <option data-icon="font-icon-cart">Externo</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-5">
                            <div class="form-group">
                                <select class="form-control" id="tar_dat_1" name="tar_dat_1" disabled>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-2">
                            <div class="form-group">
                                <select class="form-control" id="tar_edit_1" name="tar_edit_1">
                                    <option data-icon="font-icon-home" value="Si">Sí</option>
                                    <option data-icon="font-icon-cart" value="No">No</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-2" id="div_agrpar">
                            <div class="form-group">
                                <button type="button" class="btn btn-success" id="AgrPar">Agregar</button>
                            </div>
                        </div>


                        <div class="col-lg-12" id="descrip">
                            <label class="form-label semibold" for="tar_com">Comentarios</label>
                            <textarea rows="5" class="form-control" id="tar_comant" name=""></textarea>
                            <div class="summernote-theme-1" id="Com_tarcom">
                                <textarea id="tar_com" name="tar_com" class="summernote"></textarea>
                            </div>
                        </div>

                        <div class="col-lg-12" id="divcreado">
                            <label class="form-control-label semibold"><span id="creado"></span></label>
                            <br>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" name="action" id="botonguardar" value="add" class="btn btn-primary" disabled>Guardar</button>
                </div>

            </form>
        </div>
    </div>
</div>

<!-- Include Select2 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/js/select2.min.js"></script>