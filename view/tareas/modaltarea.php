<style>
#tar_com ~ .note-editor .note-editable {
    min-height: 300px !important;
    height: 300px !important;
}
</style>



<div id="modaltarea" class="modal fade bd-example-modal"  role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
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
                                <label class="form-label semibold" for="tar_asun">Asunto</label>
                                <input type="text" class="form-control" id="tar_asun" name="tar_asun" placeholder="Ingrese Asunto" oninput="this.value = this.value.toUpperCase()" required>
                            </div>
                        </div>


                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label semibold" for="tar_det">Detalle</label>
                                <textarea rows="5" class="form-control" id="tar_det" name="tar_det"></textarea>
                            </div>
                        </div>

                        <div class="col-lg-12" id="descrip">
                            <label class="form-label semibold" for="tar_com">Comentarios</label>
                            <div id="protected-content-container" class="protected-content-container">
                            <textarea id="protected-summernote" name="protected-summernote" ></textarea>
                            </div>

                            <div class="summernote-theme-1">
                                <textarea id="tar_com" name="tar_com" class="summernote" name="name"></textarea>
                            </div>
                        </div>

                        <div class="col-lg-12" id="divcreado">
                            <label class="form-control-label semibold">Creado por: &nbsp;<span id="creado"></span></label>
                            <br>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-label semibold" for="tar_asig">Asignado a</label>
                                <select class="form-control" id="tar_asig" name="tar_asig" style="width: 100%;">
                                    <option value="" disabled selected>Asigna a un Usuario</option>
                                </select>
                                
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-label semibold" for="tar_cli">Cliente</label>
                                <select class="form-control" id="tar_cli" name="tar_cli" style="width: 100%;" >
                                    <option value="" disabled selected>Relaciona un cliente</option>
                                </select>
                                
                            </div>
                        </div>


                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-label semibold" for="tar_cat">Categoria</label>
                                <select id="tar_cat" name="tar_cat" class="form-control">
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="form-label semibold" for="tar_pri">Prioridad</label>
                                <select id="tar_pri" name="tar_pri" class="form-control">
                                    <option value="1">BAJO</option>
                                    <option value="2">MEDIO</option>
                                    <option value="3">ALTO</option>
                                </select>
                            </div>
                        </div>


                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="form-label semibold" for="tar_fcierre">Vencimiento</label>
                                <div class="input-group date">
                                    <input id="tar_fcierre" name="tar_fcierre" type="text" value="" class="form-control" required>
                                    <span class="input-group-addon">
                                        <i id="calen" class="font-icon font-icon-calend"></i>
                                    </span>
                                </div>
                            </div>
                        </div>



                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="form-label semibold" for="tar_est">Estado</label>
                                <select id="tar_est" name="tar_est" class="form-control">
                                    <option value="1">NUEVA</option>
                                    <option value="2">EN CURSO</option>
                                    <option value="3">COMPLETADA</option>
                                    <option value="4">VENCIDA</option>
                                    <option value="5">ELIMINADA</option>
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

<!-- Include Select2 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/js/select2.min.js"></script>