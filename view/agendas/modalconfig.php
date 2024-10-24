<div id="modalconfig" class="modal fade bd-example-modal" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                    <i class="font-icon-close-2"></i>
                </button>
                <h4 class="modal-title" id="mdltitconf"></h4>
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
                        </div>

                        <div class="col-lg-12">
                            <label class="form-label semibold" for="tar_par1">Fechas</label>
                        </div>

                        <div class="col-lg-8">
                            <fieldset class="form-group">
                                <div class="input-group date">
                                    <input id="daterange" name="daterange" type="text" class="form-control">
                                    <span class="input-group-addon">
                                        <i class="font-icon font-icon-calend"></i>
                                    </span>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-lg-3" id="div_agrpar">
                            <div class="form-group">
                                <button type="button" class="btn btn-success" id="AgrPar">Agregar</button>
                            </div>
                        </div>


                        <div class="col-md-10 col-sm-10">
                            <section class="widget widget-accordion" id="accordion" role="tablist" aria-multiselectable="true">
                                <article class="panel">
                                    <div class="panel-heading" role="tab" id="headingOne">
                                        <a data-toggle="collapse"
                                            data-parent="#accordion"
                                            href="#collapseOne"
                                            aria-expanded="true"
                                            aria-controls="collapseOne">
                                            01/10/2024 a 31/10/2024
                                            <i class="font-icon font-icon-arrow-down"></i>
                                        </a>
                                    </div>
                                    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                        <div class="panel-collapse-in">
                                            <br>
                                            <div class="row">
                                                <div class="col-md-4 col-sm-4">
                                                    <div class="checkbox">
                                                        <input type="checkbox" id="check-1">
                                                        <label for="check-1">Domingo</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-4">
                                                    <div class="input-group date datetimepicker-2">
                                                        <input type="hidden" name="horaini_hidden" id="horaini_hidden" value="">
                                                        <input type="text" class="form-control" id="campo1" name="horaini">
                                                        <span class="input-group-addon">
                                                            <i class="font-icon font-icon-clock"></i>
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="col-md-4 col-sm-4">
                                                    <div class="input-group date datetimepicker-2">
                                                        <input type="hidden" name="horafin_hidden" id="horafin_hidden" value="">
                                                        <input type="text" class="form-control" id="campo2" name="horafin">
                                                        <span class="input-group-addon">
                                                            <i class="font-icon font-icon-clock"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4 col-sm-4">
                                                    <div class="checkbox">
                                                        <input type="checkbox" id="check-2" checked>
                                                        <label for="check-2">Lunes</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-4">
                                                    <div class="input-group date datetimepicker-2">
                                                        <input type="hidden" name="horaini_hidden" id="horaini_hidden" value="">
                                                        <input type="text" class="form-control" id="campo1" name="horaini">
                                                        <span class="input-group-addon">
                                                            <i class="font-icon font-icon-clock"></i>
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="col-md-4 col-sm-4">
                                                    <div class="input-group date datetimepicker-2">
                                                        <input type="hidden" name="horafin_hidden" id="horafin_hidden" value="">
                                                        <input type="text" class="form-control" id="campo2" name="horafin">
                                                        <span class="input-group-addon">
                                                            <i class="font-icon font-icon-clock"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4 col-sm-4">
                                                    <div class="checkbox">
                                                        <input type="checkbox" id="check-3" checked>
                                                        <label for="check-3">Martes</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-4">
                                                    <div class="input-group date datetimepicker-2">
                                                        <input type="hidden" name="horaini_hidden" id="horaini_hidden" value="">
                                                        <input type="text" class="form-control" id="campo1" name="horaini">
                                                        <span class="input-group-addon">
                                                            <i class="font-icon font-icon-clock"></i>
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="col-md-4 col-sm-4">
                                                    <div class="input-group date datetimepicker-2">
                                                        <input type="hidden" name="horafin_hidden" id="horafin_hidden" value="">
                                                        <input type="text" class="form-control" id="campo2" name="horafin">
                                                        <span class="input-group-addon">
                                                            <i class="font-icon font-icon-clock"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4 col-sm-4">
                                                    <div class="checkbox">
                                                        <input type="checkbox" id="check-4" checked>
                                                        <label for="check-4">Miercoles</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-4">
                                                    <div class="input-group date datetimepicker-2">
                                                        <input type="hidden" name="horaini_hidden" id="horaini_hidden" value="">
                                                        <input type="text" class="form-control" id="campo1" name="horaini">
                                                        <span class="input-group-addon">
                                                            <i class="font-icon font-icon-clock"></i>
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="col-md-4 col-sm-4">
                                                    <div class="input-group date datetimepicker-2">
                                                        <input type="hidden" name="horafin_hidden" id="horafin_hidden" value="">
                                                        <input type="text" class="form-control" id="campo2" name="horafin">
                                                        <span class="input-group-addon">
                                                            <i class="font-icon font-icon-clock"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 col-sm-4">
                                                    <div class="checkbox">
                                                        <input type="checkbox" id="check-5" checked>
                                                        <label for="check-5">Jueves</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-4">
                                                    <div class="input-group date datetimepicker-2">
                                                        <input type="hidden" name="horaini_hidden" id="horaini_hidden" value="">
                                                        <input type="text" class="form-control" id="campo1" name="horaini">
                                                        <span class="input-group-addon">
                                                            <i class="font-icon font-icon-clock"></i>
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="col-md-4 col-sm-4">
                                                    <div class="input-group date datetimepicker-2">
                                                        <input type="hidden" name="horafin_hidden" id="horafin_hidden" value="">
                                                        <input type="text" class="form-control" id="campo2" name="horafin">
                                                        <span class="input-group-addon">
                                                            <i class="font-icon font-icon-clock"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 col-sm-4">
                                                    <div class="checkbox">
                                                        <input type="checkbox" id="check-6" checked>
                                                        <label for="check-6">Viernes</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-4">
                                                    <div class="input-group date datetimepicker-2">
                                                        <input type="hidden" name="horaini_hidden" id="horaini_hidden" value="">
                                                        <input type="text" class="form-control" id="campo1" name="horaini">
                                                        <span class="input-group-addon">
                                                            <i class="font-icon font-icon-clock"></i>
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="col-md-4 col-sm-4">
                                                    <div class="input-group date datetimepicker-2">
                                                        <input type="hidden" name="horafin_hidden" id="horafin_hidden" value="">
                                                        <input type="text" class="form-control" id="campo2" name="horafin">
                                                        <span class="input-group-addon">
                                                            <i class="font-icon font-icon-clock"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 col-sm-4">
                                                    <div class="checkbox">
                                                        <input type="checkbox" id="check-7">
                                                        <label for="check-7">Sabado</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-sm-8">
                                                    <input type="text" class="form-control" readonly="" placeholder="No disponible">
                                                </div>
                                            </div>
                                            <br><br>
                                            <div class="row">
                                                <div class="col-md-5 col-sm-5">
                                                    <label class="form-label semibold" for="cal_est">Duración de la Cita</label>
                                                </div>
                                                <div class="col-md-4 col-sm-4">
                                                    <input type="text" class="form-control" placeholder="Minutos">
                                                </div>
                                                <br><br>
                                                <div class="col-md-5 col-sm-5">
                                                    <label class="form-label semibold" for="cal_est">Margen de tiempo</label>
                                                </div>
                                                <div class="col-md-4 col-sm-4">
                                                    <input type="text" class="form-control" placeholder="Minutos">
                                                </div>
                                            </div>
                                        </div>
                                </article>
                            </section><!--.widget-accordion-->
                        </div>









                        <div class="col-lg-4">
                            <div class="">


                            </div>
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