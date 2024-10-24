<div id="modalcomunicado" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                    <i class="font-icon-close-2"></i>
                </button>
                <h4 class="modal-title" id="mdltitulo"></h4>
            </div>
            <form method="post" id="com_form">
                <div class="modal-body">
                    <input type="hidden" id="com_id" name="com_id">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label semibold" for="com_asunto">Asunto</label>
                                <input type="text" class="form-control" id="com_asunto" name="com_asunto" placeholder="Ingrese Asunto" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label semibold" for="com_clas">Clasificación</label>
                                <select id="com_clas" name="com_clas" class="form-control">
                                    <option value="1">Bajo</option>
                                    <option value="2">Medio</option>
                                    <option value="3">Alto</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="com_fcierre">Fecha Vencimiento</label>
                                <div class="input-group date">
                                    <input id="com_fcierre" name="com_fcierre" type="text" value="" class="form-control" required>
                                    <span class="input-group-addon">
                                        <i id="calen" class="font-icon font-icon-calend"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label semibold" for="com_estado">Estado</label>
                                <select id="com_estado" name="com_estado" class="form-control">
                                    <option value="1">Activo</option>
                                    <option value="2">Inactivo</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <label class="form-label semibold" for="com_coment">Descripción</label>
                            <div class="summernote-theme-1">
                                <textarea id="com_coment" name="com_coment" class="summernote" name="name"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-12" style="display: none;" id="img_sel">
                            <label class="form-label semibold">Seleccionar imagen</label>
                            <span class="btn btn-rounded btn-file btn-sm">
                                <span><i class="font-icon-left font-icon-upload-2"></i>Cargar</span>
                                <input type="file" name="fileTest" multiple="" id="fileTest" accept="image/*">
                            </span>
                            <div id="loadingCircle" style="display:none;border: 8px solid #f3f3f3; border-radius: 50%; border-top: 8px solid #3498db;width: 40px; height: 40px; animation: spin 2s linear infinite; margin-top: 10px;"></div>
                            <div id="fileIcons"></div>
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
