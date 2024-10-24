<div id="modaldocumentos" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                    <i class="font-icon-close-2"></i>
                </button>
                <h4 class="modal-title" id="titulodoc">Agregar Documentos</h4>
            </div>
            <form method="post" id="documentos_form" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" id="idcli" name="idcli">
                    <input type="hidden" id="doci_id" name="doci_id">
                    <div class="row">

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label" for="doc_nombre">Nombre</label>
                                <input type="text" class="form-control" id="doc_nombre" name="doc_nombre" placeholder="Nombre Documento" required>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="doc_clas">Clasificación</label>
                                <select id="doc_clas" name="doc_clas" class="form-control">
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="doc_cat">Categoria</label>
                                <select id="doc_cat" name="doc_cat" class="form-control">
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-12" id="sel_doc">
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
                    <button type="button" class="btn btn-rounded btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" name="action" id="guardardoc" value="add" class="btn btn-rounded btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
