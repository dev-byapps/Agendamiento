<div id="modaldocumento" class="modal fade bd-example-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                    <i class="font-icon-close-2"></i>
                </button>
                <h4 class="modal-title" id="mdltitulo"></h4>
            </div>
            <form method="post" id="documentoin_form">
                <div class="modal-body">
                    <input type="hidden" id="catid" name="catid">
                    <div class="row">

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="docnom">Nombre</label>
                                <input type="text" class="form-control" id="docnom" name="docnom" placeholder="Ingrese Nombre" required>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="cat">Categoria</label>
                                <select id="cat" name="cat" class="form-control">
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="cat_est">Estado</label>
                                <select id="cat_est" name="cat_est" class="form-control">
                                    <option value="1">Activo</option>
                                    <option value="2">Inactivo</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6" id="doc">
                            <label class="form-label">Seleccionar documento</label>
                            <span class="btn btn-rounded btn-file btn-sm">
                                <span><i class="font-icon-left font-icon-upload-2"></i>Cargar</span>
                                <input type="file" name="fileTest" multiple="" id="fileTest">
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
