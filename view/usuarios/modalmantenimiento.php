<div id="modalmantenimiento" class="modal fade bd-example-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                    <i class="font-icon-close-2"></i>
                </button>
                <h4 class="modal-title" id="mdltituloma"></h4>
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
                                <label class="form-label" for="usu_pass">Contraseña</label>
                                <input type="password" class="form-control" id="usu_pass" name="usu_pass" placeholder="************" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="usu_perfil">Perfil</label>
                                <select class="form-control" id="usu_perfil" name="usu_perfil">
                                    <option value="Administrador">Administrador</option>
                                    <option value="Operativo">Operativo</option>
                                    <option value="Coordinador">Coordinador</option>
                                    <option value="Asesor">Asesor</option>
                                    <option value="Agente">Agente</option>
                                    <option value="Asesor/Agente">Asesor/Agente</option>
                                    <!-- <option value="Gerencia">Gerencia</option> -->
                                    <!-- <option value="Calidad">Calidad</option> -->
                                    <!-- <option value="RRHH">RRHH</option> -->
                                    
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="usu_est">Estado</label>
                                <select id="usu_est" name="usu_est" class="form-control">
                                    <option value="1">Activo</option>
                                    <option value="2">Inactivo</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="usu_tipodoc">Tipo Doc</label>
                                <select class="form-control" id="usu_tipodoc" name="usu_tipodoc">
                                    <option value="CC">CC</option>
                                    <option value="CE">CE</option>
                                    <option value="NIT">NIT</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="usu_cc">Identificación</label>
                                <input type="text" class="form-control" id="usu_cc" name="usu_cc" placeholder="Ingrese Identificación" oninput="this.value = this.value.replace(/[^0-9]/g, '')" maxlength="15" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="usu_nom">Nombre</label>
                                <input type="text" class="form-control" id="usu_nom" name="usu_nom" placeholder="Ingrese Nombre" oninput="this.value = this.value.replace(/[^A-Za-z ]/g, '').toUpperCase()" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="usu_ape">Apellidos</label>
                                <input type="text" class="form-control" id="usu_ape" name="usu_ape" placeholder="Ingrese Apellido" oninput="this.value = this.value.replace(/[^A-Za-z ]/g, '').toUpperCase()" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="usu_mail">Correo Electronico</label>
                                <input type="email" class="form-control" id="usu_mail" name="usu_mail" placeholder="test@test.com">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="usu_car">Cargo</label>
                                <input type="text" class="form-control" id="usu_car" name="usu_car" placeholder="Ingrese Cargo" oninput="this.value = this.value.replace(/[^A-Za-z ]/g, '').toUpperCase()" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="usu_tipcontrato">Tipo de Contrato</label>
                                <select class="form-control" id="usu_tipcontrato" name="usu_tipcontrato" required>
                                    <option value="FIJO">FIJO</option>
                                    <option value="INDEFINIDO">INDEFINIDO</option>
                                    <option value="OBRA O LABOR">OBRA O LABOR</option>
                                    <option value="FREELANCE">FREELANCE</option>
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
                                <label class="form-label" for="tar_fingreso">Fecha Ingreso</label>
                                <div class="input-group date">
                                    <input id="tar_fingreso" name="tar_fingreso" type="text" value="" class="form-control" placeholder="Ingrese Fecha Ej: dd/mm/aaaa" required >
                                    <span class="input-group-addon">
                                        <i id="calen" class="font-icon font-icon-calend"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="usu_feretiro">Fecha Retiro</label>
                                <div class="input-group date">
                                    <input id="usu_feretiro" name="usu_feretiro" type="text" value="" class="form-control" placeholder="Ingrese Fecha Ej: dd/mm/aaaa">
                                    <span class="input-group-addon">
                                        <i id="calen" class="font-icon font-icon-calend"></i>
                                    </span>
                                </div>
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

<script>
            
        
        </script><!--.Funcion DateTIME-->