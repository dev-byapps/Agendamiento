<div id="modalusuario" class="modal fade bd-example-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                    <i class="font-icon-close-2"></i>
                </button>
                <h4 class="modal-title">Perfil Usuario</h4>
            </div>
            <form method="post" id="usuario_form">
                <div class="modal-body">
                    <input type="hidden" id="usu_id" name="usu_id">
                <div class="row">
                    <div class="col-lg-6">
                    <div class="form-group">
                        <label class="form-label" for="usu_user">Usuario</label>
                        <input type="text" class="form-control" id="usu_user" name="usu_user" placeholder="Ingrese Usuario" required>
                    </div>
                    </div>
                    <div class="col-lg-6">
                    <div class="form-group">
                        <label class="form-label" for="usu_pass">ContraseÃ±a</label>
                        <input type="text" class="form-control" id="usu_pass" name="usu_pass" placeholder="************" required>
                    </div>
                    </div>
                    <div class="col-lg-6">
                    <div class="form-group">
                        <label class="form-label" for="usu_nom">Nombre</label>
                        <input type="text" class="form-control" id="usu_nom" name="usu_nom" placeholder="Ingrese Nombre" required>
                    </div>
                    </div>
                    <div class="col-lg-6">
                    <div class="form-group">
                        <label class="form-label" for="usu_cc">IdentificaciÃ³n</label>
                        <input type="text" class="form-control" id="usu_cc" name="usu_cc" placeholder="Ingrese IdentificaciÃ³n" required>
                    </div>
                    </div>
                    <div class="col-lg-12">
                    <div class="form-group">
                        <label class="form-label" for="usu_mail">Correo Electronico</label>
                        <input type="email" class="form-control" id="usu_mail" name="usu_mail" placeholder="test@test.com" required>
                    </div>
                    </div>
                    <div class="col-lg-6">
                    <div class="form-group">
                        <label class="form-label" for="usu_perfil">Perfil</label>
                        <select class="form-control" id="usu_perfil" name="usu_perfil">
                            <option value="Administrador">Administrador</option>
                            <option value="Operativo">Operativo</option>
                            <option value="Director">Director</option>
                            <option value="Asesor">Asesor</option>
                            <option value="Agente">Agente</option>
                        </select>
                    </div>
                    </div>
                    <div class="col-lg-6">
                    <div class="form-group">
                        <label class="form-label" for="usu_est">Estado</label>
                        <select id="usu_est" name="usu_est" class="form-control">
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>
                    </div>
                    <div class="col-lg-6">
                    <div class="form-group">
                        <label class="form-label" for="usu_grupocom">Grupo Comercial</label>
                        <select id="usu_grupocom" name="usu_grupocom" class="form-control">

                        </select>
                    </div>
                    </div>
                    <div class="col-lg-6">
                    <div class="form-group">
                        <label class="form-label" for="sip_cuenta">Cuenta SIP</label>
                        <select id="sip_cuenta" name="sip_cuenta" class="form-control">
						</select>
                    </div>
                    </div>
                    <div class="col-lg-6">
                    <div class="form-group">
                        <label class="form-label" for="sip_ext">Extensión SIP</label>
                        <input type="text" class="form-control" id="sip_ext" name="sip_ext" placeholder="Ingrese ExtensiÃ³n" required>
                    </div>
                    </div>
                    <div class="col-lg-6">
                    <div class="form-group">
                        <label class="form-label" for="sip_pass">Password SIP</label>
                        <input type="text" class="form-control" id="sip_pass" name="sip_pass" placeholder="Ingrese Password SIP" required>
                    </div>
                    </div>
        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-rounded btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" name="action" id="#" value="add" class="btn btn-rounded btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
