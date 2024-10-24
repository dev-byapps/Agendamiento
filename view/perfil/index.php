<?php
require_once "../../config/conexion.php";
$usu_id = isset($_SESSION["usu_id"]) ? $_SESSION["usu_id"] : '';
if (isset($_SESSION["usu_id"])) {
?>
    <!DOCTYPE html>
    <html>
    <script>
        var usu_id = '<?php echo $usu_id; ?>';
    </script>

    <?php require_once "../mainhead/head.php"; ?>
    <title>CRM :: Perfil </title>
    </head>

    <body class="with-side-menu">
        <?php require_once "../mainheader/header.php"; ?>
        <div class="mobile-menu-left-overlay"></div>
        <?php require_once "../mainnav/nav.php"; ?>
        <div class="page-content">
            <header class="page-content-header">
                <div class="container-fluid">
                    <ol class="breadcrumb breadcrumb-simple">
                        <li><a href="../home/"><span class="material-symbols-rounded" style="color:#5B80A3; position:static; font-size:20px">home</span></a></li>
                        <li class="active">Perfil de Usuario</li>
                    </ol>
                </div>
            </header>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xxl-6 col-lg-6 col-xl-6 col-md-6">
                        <div class="box-typical box-typical-padding">
                            <h5 class="m-t-lg with-border">Información Usuario</h5>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="cli_cc">Perfil</label>
                                        <span class="label label-warning"><?php echo $_SESSION["usu_perfil"] ?></span>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="cli_cc">Estado</label>
                                        <span id="estado"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-5">
                                    <div class="form-group">
                                        <label class="form-label semibold" for="cli_cc">Identificación</label>
                                        <input type="text" disabled="" class="form-control" id="usu_cc" name="usu_cc">
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <div class="form-group">
                                        <label class="form-label semibold" for="cli_cc">Nombre</label>
                                        <input type="text" disabled="" class="form-control" id="usu_nom" name="usu_nom">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label semibold" for="cli_cargo">Cargo</label>
                                        <input type="text" disabled="" class="form-control" id="cli_cargo" name="cli_cargo">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label semibold" for="usu_gcom">Grupo Comercial</label>
                                        <input type="text" disabled="" class="form-control" id="usu_gcom" name="usu_gcom">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label semibold" for="usu_tipcontrato">Tipo de Contrato</label>
                                        <input type="text" disabled="" class="form-control" id="usu_tipcontrato" name="usu_tipcontrato">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label semibold" for="usu_feingreso">Fecha de Ingreso</label>
                                        <input type="text" disabled="" class="form-control" id="usu_feingreso" name="usu_feingreso">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="box-typical box-typical-padding">
                            <h5 class="m-t-lg with-border">Contraseña</h5>
                            <fieldset class="form-group">
                                <label class="form-label semibold" for="usu_user">Usuario</label>
                                <input type="text" disabled="" class="form-control" id="usu_user" name="usu_user">
                            </fieldset>
                            <fieldset class="form-group">
                                <label class="form-label semibold" for="n_pass">Nueva contraseña</label>
                                <input type="password" class="form-control" id="n_pass" name="n_pass" placeholder="" required>
                            </fieldset>
                            <fieldset class="form-group">
                                <label class="form-label semibold" for="rn_pass">Confirmar nueva contraseña</label>
                                <input type="password" class="form-control" id="rn_pass" name="rn_pass" placeholder="" required>
                            </fieldset>
                            <fieldset class="form-group">
                                <button type="submit" name="action" value="add" class="btn btn-rounded btn-inline" id="Cambiarpass">Cambiar contraseña</button>
                            </fieldset>
                        </div>
                    </div>

                    <div class="col-xxl-6 col-lg-6 col-xl-6 col-md-6">
                        <div class="box-typical box-typical-padding">
                            <h5 class="m-t-lg with-border">Información Personal</h5>
                            <div class="row">
                                <div class="col-lg-12 form-group">
                                    <label class="form-label semibold" for="usu_fenac">Fecha de Nacimiento</label>
                                    <input type="text" class="form-control" id="usu_fenac" name="usu_fenac" disabled>
                                </div>

                                <div class="col-lg-6 form-group">
                                    <label class="form-label semibold" for="usu_telefono">Telefono</label>
                                    <input type="text" class="form-control" id="usu_telefono" name="usu_telefono" oninput="this.value = this.value.replace(/[^0-9]/g, '')" maxlength="15" disabled>
                                </div>
                                <div class=" col-lg-6 form-group">
                                    <label class="form-label semibold" for="usu_celular">Celular</label>
                                    <input type="text" class="form-control" id="usu_celular" name="usu_celular" oninput="this.value = this.value.replace(/[^0-9]/g, '')" maxlength="15" disabled>
                                </div>
                                <div class="col-lg-12 form-group">
                                    <label class="form-label semibold" for="usu_mail">Correo</label>
                                    <input type="email" class="form-control" id="usu_mail" name="usu_mail" disabled>
                                </div>
                                <div class="col-lg-12 form-group">
                                    <label class="form-label semibold" for="usu_direccion">Direccion</label>
                                    <input type="text" class="form-control" id="usu_direccion" name="usu_direccion" disabled>
                                </div>
                                <div class="col-lg-6 form-group">
                                    <label class="form-label semibold" for="usu_ciudad">Ciudad</label>
                                    <input type="text" class="form-control" id="usu_ciudad" name="usu_ciudad" disabled>
                                </div>
                                <div class="col-lg-6 form-group">
                                    <label class="form-label semibold" for="usu_dep">Departamento</label>
                                    <input type="text" class="form-control" id="usu_dep" name="usu_dep" disabled>
                                </div>
                            </div>
                            <br>
                            <div class="form-group">
                                <button type="submit" name="action" value="add" class="btn" id="Editar">Editar</button>
                                <button type="submit" name="action" value="add" class="btn" id="Guardar" disabled>Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div><!--.container-fluid-->
        </div><!--.page-content-->

        <?php require_once "../mainjs/js.php"; ?>
        <script type="text/javascript" src="perfil.js"></script>

    </body>

    </html>

<?php
} else {
    header("Location:" . Conectar::ruta() . "index.php");
}
?>