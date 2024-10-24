<div id="modalconsulta" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                    <i class="font-icon-close-2"></i>
                </button>
                <h4 class="modal-title">Agregar Consulta</h4>
            </div>
            <div class="box-typical box-typical-padding" id="pnlcoments">
                <div class="row">
                    <?php if ($_SESSION["usu_perfil"] != "Asesor" && $_SESSION["usu_perfil"] != "Coordinador") {?>
                        <div class="col-lg-12">
                            <div class="checkbox-toggle">
                                <input type="checkbox" id="con_pri">
                                <label for="con_pri" id="con_pri_label">Publico</label>
                            </div>
                        </div>
                    <?php }?>

                    <br>

                    <div class="col-lg-12">
                        <br>
                        <label class="form-label" for="ope_feradicacion">Fecha Consulta</label>
                        <div class="input-group date">
                            <input id="ope_feconsulta" name="ope_feconsulta" type="text" value="" class="form-control" required>
                            <span class="input-group-addon">
                                <i id="calen" class="font-icon font-icon-calend"></i>
                            </span>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <br>
                        <label class="form-label" for="con_resp">Respuesta</label>
                        <select class="form-control" id="con_resp" name="con_resp" placeholder="Ingrese tipo de operacion..." required>
                            <option>VIABLE</option>
                            <option>NO VIABLE</option>
                        </select>
                    </div>

                    <br><br>

                    <div class="col-lg-12">
                        <br>
                        <label class="form-label semibold" for="com_consult">Descripción</label>
                        <div class="summernote-theme-1">
                            <textarea id="com_consult" name="com_consult" class="summernote" name="name" required></textarea>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button type="button" id="btnconsulta" class="btn btn-primary">Guardar</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>