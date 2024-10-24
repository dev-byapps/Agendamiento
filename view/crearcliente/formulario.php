<form method="post" id="cliente_form">
    <div class="row">

        <div class="col-lg-4">
            <fieldset class="form-group">
                <label class="form-label semibold" for="tipo_cc">Tipo Doc</label>
                <select id="tipo_cc" name="tipo_cc" class="form-control">
                    <option>CC</option>
                </select>
            </fieldset>
        </div>

        <div class="col-lg-4">
            <fieldset class="form-group">
                <label class="form-label semibold" for="cli_cc">Identificación</label>
                <input type="text" class="form-control" id="cli_cc" name="cli_cc" placeholder="" oninput="this.value = this.value.replace(/[^0-9]/g, '')" maxlength="15" required>
            </fieldset>
        </div>

        <div class="col-lg-4">
            <fieldset class="form-group">
                <label class="form-label semibold" for="cli_nombre">Nombre Completo</label>
                <input type="text" class="form-control" id="cli_nombre" name="cli_nombre" placeholder="" oninput="this.value = this.value.replace(/[^A-Za-z ]/g, '').toUpperCase()" style="text-transform: uppercase;" required>
            </fieldset>
        </div>

    </div>

    <div class="row">

        <div class="col-lg-4">
            <fieldset class="form-group">
                <label class="form-label semibold" for="cli_edad">Fecha Nacimiento</label>
                <div class="input-group date">
                    <input id="cli_edad" name="cli_edad" type="text" class="form-control">
                    <span class="input-group-addon">
                        <i class="font-icon font-icon-calend"></i>
                    </span>
                </div>
            </fieldset>
        </div>

        <div class="col-lg-4">
            <fieldset class="form-group">
                <label class="form-label semibold" for="cli_telefono">Teléfono</label>
                <input type="text" class="form-control" id="cli_telefono" name="cli_telefono" placeholder="" oninput="this.value = this.value.replace(/[^0-9]/g, '')" maxlength="12" required>
            </fieldset>
        </div>

        <div class="col-lg-4">
            <fieldset class="form-group">
                <label class="form-label semibold" for="tel_alternativo">Tel. Alternativo</label>
                <input type="text" class="form-control" id="tel_alternativo" name="tel_alternativo" placeholder="" oninput="this.value = this.value.replace(/[^0-9]/g, '')" maxlength="12">
            </fieldset>
        </div>

    </div>

    <div class="row">

        <div class="col-lg-4">
            <fieldset class="form-group">
                <label class="form-label semibold" for="cli_mail">Correo</label>
                <input type="email" class="form-control" id="cli_mail" name="cli_mail" size="30" style="text-transform: lowercase;">
            </fieldset>
        </div>

        <div class="col-lg-4">
            <fieldset class="form-group">
                <label class="form-label semibold" for="cli_ciudad">Ciudad</label>
                <select class="form-control" id="cli_ciudad" name="cli_ciudad" style="width: 100%;" required>
                    <option value="" disabled selected>Escribe una ciudad</option>
				</select>
                <ul id="suggestions" class="list-group" style="display: none; position: absolute; z-index: 1000; width: 100%; text-transform: uppercase;"></ul>
            </fieldset>
        </div>

        <div class="col-lg-4">
            <fieldset class="form-group">
                <label class="form-label semibold" for="cli_depa">Departamento</label>
                <input type="text" class="form-control" id="cli_depa" name="cli_depa" style="text-transform: uppercase;" oninput="this.value = this.value.replace(/[^A-Za-z ]/g, '').toUpperCase()" readonly>
            </fieldset>
        </div>

    </div>

    <div class="row">

        <div class="col-lg-4">
            <fieldset class="form-group">
                <label class="form-label semibold" for="cli_entidad">Entidad</label>
                <select id="cli_entidad" name="cli_entidad" class="form-control"style="width: 100%;">
                <option value="" disabled selected>Selecciona una entidad</option>
                </select>
            </fieldset>
        </div>

        <div class="col-lg-4">
            <fieldset class="form-group">
                <label class="form-label semibold" for="cli_estado">Estado</label>
                <select id="cli_estado" name="cli_estado" class="form-control">
                    <option>Interesado</option>
                    <option>Analisis</option>
                    <option>Cita</option>
                    <?php if ($_SESSION['usu_perfil'] != "Asesor" && $_SESSION['usu_perfil'] != "Coordinador") {?>
                    <option>Consulta</option>
                    <option>Cerrado</option>
                    <option>No interesado</option>
                    <option>No viable</option>
                    <option>Oferta</option>
                    <option>Operacion</option>
                    <option>Viable</option>
                    <option>Retoma</option>
                    <?php }?>
                </select>
            </fieldset>
        </div>
    </div>

    <h5 class="m-t-lg with-border">Información Laboral</h5>
    <div class="row">

        <div class="col-lg-4">
            <fieldset class="form-group">
                <label class="form-label semibold" for="cli_convenio">Convenio</label>
                <select class="form-control" id="cli_convenio" name="cli_convenio" style="width: 100%;" required>
                    <option value="" disabled selected>Escribe un convenio</option>
				</select>
                <ul id="suggestionsconvenio" class="list-group" style="display: none; position: absolute; z-index: 1000; width: 100%; text-transform: uppercase;"></ul>
            </fieldset>
        </div>

        <div class="col-lg-4">
            <fieldset class="form-group">
                <label class="form-label semibold" for="est_laboral">Estado Laboral</label>
                <select id="est_laboral" name="est_laboral" class="form-control">
                    <option>ACTIVO</option>
                    <option>PENSIONADO</option>
                    <option>PENSIONADO/ACTIVO</option>
                </select>
            </fieldset>
        </div>

        <div class="col-lg-4">
            <fieldset class="form-group">
                <label class="form-label semibold" for="tipo_contrato">Tipo de Contrato</label>
                <select id="tipo_contrato" name="tipo_contrato" class="form-control" >
                    <option></option>
                    <option>FIJO</option>
                    <option>INDEFINIDO</option>
                    <option>CARRERA ADMINISTRATIVA</option>
                    <option>LIBRE NOMBRAMIENTO</option>
                    <option>REOMOCION</option>
                    <option>PROVISIONAL</option>
                    <option>OTRO</option>
                </select>
            </fieldset>
        </div>

    </div>

    <div class="row">

        <div class="col-lg-4">
            <fieldset class="form-group">
                <label class="form-label semibold" for="cli_cargo">Cargo</label>
                <input type="text" class="form-control" id="cli_cargo" name="cli_cargo" placeholder="" size="40" style="text-transform: uppercase;" oninput="this.value = this.value.toUpperCase()">
            </fieldset>
        </div>

        <div class="col-lg-4">
            <fieldset class="form-group">
                <label class="form-label semibold" for="tiem_servicio">Fecha / Tiempo</label>
                <input type="text" class="form-control" id="tiem_servicio" name="tiem_servicio" placeholder="" size="30" style="text-transform: uppercase;" oninput="this.value = this.value.toUpperCase()">
            </fieldset>
        </div>

        <div class="col-lg-4">
            <fieldset class="form-group">
                <label class="form-label semibold" for="tipo_pension">Tipo de Pensión</label>
                <select id="tipo_pension" name="tipo_pension" class="form-control" disabled="true">
                    <option></option>
                    <option>VEJEZ</option>
                    <option>INVALIDEZ</option>
                    <option>SUSTITUCIÓN</option>
                </select>
            </fieldset>
        </div>

    </div>

    <h5 class="m-t-lg with-border">Información Contácto</h5>
    <div class="row" id="ultimo">

        <div class="col-lg-4">
            <fieldset class="form-group">
                <label class="form-label semibold" for="toma-contac">Toma de Contácto</label>
                <select id="toma-contac" name="toma_contac" class="form-control"></select>
            </fieldset>
        </div>

        <div class="col-lg-4">
            <fieldset class="form-group">
                <label class="form-label semibold" for="cli_agente">Agente Contácto</label>
                <select id="cli_agente" name="cli_agente" class="form-control">
                </select>
            </fieldset>
        </div>

        <div class="col-lg-4">
            <fieldset class="form-group">
                <label class="form-label semibold" for="exampleInput">Asesor Comercial</label>
                <select id="cli_asesor" name="cli_asesor" class="form-control">
                </select>
            </fieldset>
        </div>

    </div>

    <h5 class="m-t-lg with-border" id="linea"></h5>
    <div class="row" id="buttonG">
        <div class="col-lg-12">
            <fieldset class="form-group">
                <button type="submit" name="action" value="add" class="btn btn-rounded btn-inline" id="crear">Crear Cliente</button>
            </fieldset>
        </div>
    </div>

</form>