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
                <input type="text" class="form-control" id="cli_mail" name="cli_mail" size="30" style="text-transform: lowercase;">
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
                <input type="text" class="form-control" id="cli_depa" name="cli_depa" style="text-transform: uppercase;" readonly>
            </fieldset>
        </div>

    </div>

    <div class="row">

        <div class="col-lg-4">
            <fieldset class="form-group">
                <label class="form-label semibold" for="cli_dir">Dirección</label>
                <input type="text" class="form-control" id="cli_dir" name="cli_dir" size="30" oninput="this.value = this.value.toUpperCase()" required>
            </fieldset>
        </div>

        <div class="col-lg-4">
            <fieldset class="form-group">
                <label class="form-label semibold" for="estado_civil">Estado Civil</label>
                <select id="estado_civil" name="estado_civil" class="form-control" required>
                    <option>CASADO(A)</option>
                    <option>SOLTERO(A)</option>
                    <option>VIUDO(A)</option>
                    <option>SEPARADO(A)</option>
                    <option>DIVORCIADO(A)</option>
                </select>
            </fieldset>
        </div>

        <div class="col-lg-4">
            <fieldset class="form-group">
                <label class="form-label semibold" for="per_acargo">Personas a Cargo</label>
                <select id="per_acargo" name="per_acargo" class="form-control" required>
                    <option>0</option>
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                </select>
            </fieldset>
        </div>



    </div>

    <h5 class="m-t-lg with-border">Información Laboral</h5>

    <div class="row">

        <div class="col-lg-4">
            <fieldset class="form-group">
                <label class="form-label semibold" for="cli_entidad">Entidad</label>
                <select id="cli_entidad" name="cli_entidad" class="form-control" style="width: 100%;">
                    <option value="" disabled selected>Selecciona una entidad</option>
                </select>
            </fieldset>
        </div>

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
                <select id="est_laboral" name="est_laboral" class="form-control" required>
                    <option></option>
                    <option>ACTIVO</option>
                    <option>PENSIONADO</option>
                    <option>PENSIONADO/ACTIVO</option>
                </select>
            </fieldset>
        </div>

    </div>

    <div class="row">

        <div class="col-lg-4">
            <fieldset class="form-group">
                <label class="form-label semibold" for="tipo_contrato">Tipo de Contrato</label>
                <select id="tipo_contrato" name="tipo_contrato" class="form-control" disabled="true">
                    <option></option>
                    <option>FIJO</option>
                    <option>INDEFINIDO</option>
                    <option>CARRERA ADMIN</option>
                    <option>LIBRE NOMBRAMIENTO</option>
                    <option>REOMOCIÓN</option>
                    <option>PROVISIONAL</option>
                    <option>OTRO</option>
                </select>
            </fieldset>
        </div>

        <div class="col-lg-4">
            <fieldset class="form-group">
                <label class="form-label semibold" for="cli_cargo">Cargo</label>
                <input type="text" class="form-control" id="cli_cargo" name="cli_cargo" placeholder="" size="40" style="text-transform: uppercase;" disabled="true">
            </fieldset>
        </div>

        <div class="col-lg-4">
            <fieldset class="form-group">
                <label class="form-label semibold" for="tiem_servicio">Fecha / Tiempo</label>
                <input type="text" class="form-control" id="tiem_servicio" name="tiem_servicio" placeholder="" size="30" style="text-transform: uppercase;"  oninput="this.value = this.value.toUpperCase()" disabled="true">
            </fieldset>
        </div>
    </div>

    <div class="row">

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
        <div class="col-lg-4">
            <fieldset class="form-group">
                <label class="form-label semibold" for="ing_adici">Ingresos Adicionales</label>
                <input type="text" class="form-control" id="ing_adici" name="ing_adici" placeholder="" size="40" style="text-transform: uppercase;" oninput="this.value = '$' + (this.value.replace(/\D/g,'').substring(0, 9)).replace(/\B(?=(\d{3})+(?!\d))/g, '.')" placeholder="$0">
            </fieldset>
        </div>

        <div class="col-lg-4">
            <fieldset class="form-group">
                <label class="form-label semibold" for="ori_ingres">Origen de Ingresos</label>
                <input type="text" class="form-control" id="ori_ingres" name="ori_ingres" placeholder="" size="40" style="text-transform: uppercase;" oninput="this.value = this.value.toUpperCase()">
            </fieldset>
        </div>
    </div>

    <h5 class="m-t-lg with-border">Información Consulta</h5>

    <div class="row" id="ultimo">

        <div class="col-lg-4">
            <fieldset class="form-group">
                <label class="form-label semibold" for="tipocre">Tipo Credito</label>
                <select id="tipocre" name="tipocre" class="form-control" style="width: 100%;" required>
                    <option>COMPRA DE CARTERA</option>
                    <option>LIBRE INVERSIÓN</option>
                </select>
            </fieldset>
        </div>

        <div class="col-lg-4">
            <fieldset class="form-group">
                <label class="form-label semibold" for="val_credit">Valor del Crédito</label>
                <input type="text" class="form-control" id="val_credit" name="val_credit" size="40" style="text-transform: uppercase;" oninput="this.value = '$' + (this.value.replace(/\D/g,'').substring(0, 9)).replace(/\B(?=(\d{3})+(?!\d))/g, '.')" placeholder="$0">
            </fieldset>
        </div>

        <div class="col-lg-4">
            <fieldset class="form-group">
                <label class="form-label semibold" for="tasa_plazo">Tasa / Plazo</label>
                <input type="text" class="form-control" id="tasa_plazo" name="tasa_plazo" placeholder="" size="40" style="text-transform: uppercase;" oninput="this.value = this.value.toUpperCase()">
            </fieldset>
        </div>

        <div class="col-lg-12">
            <table id="incrementableTable" class="display table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 35%;">Compra de Cartera</th>
                        <th style="width: 10%;">Plazo</th> <!-- 3 dígitos -->
                        <th style="width: 10%;">Tasa</th> <!-- 3 números con punto decimal -->
                        <th style="width: 20%;">Valor</th> <!-- Número -->
                        <th style="width: 10%;">Desprendible</th> <!-- Checkbox -->
                        <th style="width: 5%; text-align: center;"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td contenteditable="false">
                        <input type="text" oninput="this.value = this.value.toUpperCase()" style="border: none; outline: none; width: 100%; background-color: transparent;" id="entidad1">
                        </td>
                        <td class="editable-cell" contenteditable="false">
                            <input type="text" maxlength="3" oninput="this.value = this.value.replace(/\D/g,'').substring(0, 3)" style="border: none; outline: none; width: 100%; background-color: transparent;" id="plazo1">
                        </td>
                        <td class="editable-cell" contenteditable="false">
                            <input type="text" maxlength="4" oninput="this.value = formatTasa(this.value)" style="border: none; outline: none; width: 100%; background-color: transparent;" id="tasa1">
                        </td>
                        <td class="editable-cell" contenteditable="false">
                            <input type="text" oninput="this.value = formatValor(this.value)" maxlength="12" style="border: none; outline: none; width: 100%; background-color: transparent;" id="cuota1">
                        </td>
                        <td class="checkbox-toggle" style="position: relative;">
                            <input type="checkbox" class="check-toggle" data-num="1" id="check1">
                            <label for="check1">No</label>
                        </td>
                        <td style="width: 70px; text-align: center;">
                            <button class="btn btn-primary-outline addRowButton" style="font-size: 10px; border: none; margin-bottom: 8px;"><i class="fa fa-plus"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-lg-12 mb-10"></div>
    <h5 class="m-t-lg with-border">Documentos</h5>

    <div class="row">

        <!-- Documentos -->
        <div class="col-lg-4" id="sel_cc" style="margin-bottom: 15px;">
            <div style="display: flex; align-items: center;">
                <label class="form-label" style="margin-right: 10px;">Soportes:</label>
                <span class="btn btn-rounded btn-file btn-sm">
                    <span><i class="font-icon-left font-icon-upload-2"></i>Cargar</span>
                    <input type="file" name="cedula" multiple="" id="cedula">
                </span>
                <div id="loadingCircle" style="display:none;border: 8px solid #f3f3f3; border-radius: 50%; border-top: 8px solid #3498db;width: 40px; height: 40px; animation: spin 2s linear infinite; margin-top: 10px;"></div>
                <div id="fileIcons"></div>
            </div>
        </div>

        <!-- <div class="col-lg-4" id="sel_des" style="margin-bottom: 15px;">
            <div style="display: flex; align-items: center;">
                <label class="form-label" style="margin-right: 10px;">AyudaVenta:</label>
                <span class="btn btn-rounded btn-file btn-sm">
                    <span><i class="font-icon-left font-icon-upload-2"></i>Cargar</span>
                    <input type="file" name="desprendible" multiple="" id="desprendible"">
                </span>
                <div id=" loadingCircle2" style="display:none;border: 8px solid #f3f3f3; border-radius: 50%; border-top: 8px solid #3498db;width: 40px; height: 40px; animation: spin 2s linear infinite; margin-top: 10px;">
            </div>
            <div id="fileIcons2"></div>
        </div> -->

        <div class=" col-lg-4" id="sel_auto" style="margin-bottom: 15px;">
        <div style="display: flex; align-items: center;">
            <label class="form-label" style="margin-right: 10px;">Autorización de consulta:</label>
            <span class="btn btn-rounded btn-file btn-sm">
                <span><i class="font-icon-left font-icon-upload-2"></i>Cargar</span>
                <input type="file" name="autorizacion" multiple="" id="autorizacion">
            </span>
            <div id="loadingCircle3" style="display:none;border: 8px solid #f3f3f3; border-radius: 50%; border-top: 8px solid #3498db;width: 40px; height: 40px; animation: spin 2s linear infinite; margin-top: 10px;"></div>
            <div id="fileIcons3"></div>
        </div>
    </div>


    
    </div>

    <h5 class="m-t-lg with-border">Información Contácto</h5>
    <div class="row" id="ultimo">

        <div class="col-lg-4">
            <fieldset class="form-group">
                <label class="form-label semibold" for="toma-contac">Toma de Contácto</label>
                <select id="toma-contac" name="toma_contac" class="form-control" required></select>
            </fieldset>
        </div>

        <div class="col-lg-4">
            <fieldset class="form-group">
                <label class="form-label semibold" for="exampleInput">Asesor Comercial</label>
                <select id="cli_asesor" name="cli_asesor" class="form-control" required>
                </select>
            </fieldset>
        </div>

    </div>

    <h5 class="m-t-lg with-border" id="linea"></h5>
    <div class="row" id="buttonG">
        <div class="col-lg-12">
            <fieldset class="form-group">
                <button type="submit" name="action" value="add" class="btn btn-rounded btn-inline" id="crearc">Crear Consulta</button>
            </fieldset>
        </div>
    </div>
</form>
