<?php
require_once "config/conexion.php";

if (isset($_POST["enviar"]) and $_POST["enviar"] == "si") {
    require_once "models/usuario.php";
    $usuario = new Usuario();
    $usuario->login();
}

$usu_id = isset($_SESSION["usu_id"]) ? $_SESSION["usu_id"] : '';
echo $usu_id;
?>

<!DOCTYPE html>
<html>

<head lang="es">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>CRM :: Iniciar Sesión</title>
    <!-- Incluir usu_id en JavaScript -->
    <script>
        var usu_id = "<?php echo $usu_id ?>"
    </script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fingerprintjs/fingerprintjs@3/dist/fp.min.js"></script>
    <script>
        var visitorId = "";
        document.addEventListener("DOMContentLoaded", async function() {
            const fp = await FingerprintJS.load();
            const result = await fp.get();
            visitorId = result.visitorId;

            // Asignar visitorId al campo oculto en el formulario de inicio de sesión
            document.getElementById('visitor_id').value = visitorId;
        });
    </script>

    <link href="public/img/favicon.144x144.png" rel="apple-touch-icon" type="image/png" sizes="144x144">
    <link href="public/img/favicon.114x114.png" rel="apple-touch-icon" type="image/png" sizes="114x114">
    <link href="public/img/favicon.72x72.png" rel="apple-touch-icon" type="image/png" sizes="72x72">
    <link href="public/img/favicon.57x57.png" rel="apple-touch-icon" type="image/png">
    <link href="public/img/favicon.png" rel="icon" type="image/png">
    <link href="public/img/favicon.ico" rel="shortcut icon">

    <link rel="stylesheet" href="public/css/separate/pages/login.min.css">
    <link rel="stylesheet" href="public/css/lib/font-awesome/font-awesome.min.css">
    <link rel="stylesheet" href="public/css/lib/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="public/css/main.css">

</head>

<body>

    <div class="page-center" style="height: 720px;">
        <div class="page-center-in">
            <div class="container-fluid">
                <div class="sign-box no-padding" style="max-width: 644px; min-height: 420px">
                    <div class="col-md-5 p-x-0">
                        <div class="box-typical" style="margin: 0; width:auto; height: 420px; background: linear-gradient(-45deg, #1970e2, #4695ff);">
                            <div class="row p-a" style=" display: flex; justify-content: center;">
                                <img src="./public/img/login-lg.png">
                            </div>
                            <div class="row p-a-lg m-a-0">
                                <div style="text-align: center; color:#FFF;">Administre sus clientes, operaciones y genere llamadas a contactos efectivos para su gestión.</div>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-7 p-x-lg">

                        <form action="" method="post" id="login_form">
                            <br><br>
                            <header class="sign-title semibold" style="text-align: left; font-size: 30px;">Cuenta de Ingreso</header>
                            <br>

                            <div class="form-group">
                                <label class="form-label semibold">Usuario</label>
                                <input type="text" id="usu_user" name="usu_user" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label semibold">Contraseña</label>
                                <input type="password" id="usu_pass" name="usu_pass" class="form-control" required>
                            </div>

                            <!-- <div class="form-group">
                                <div class="float-right reset">
                                    <a id="resetpass">¿Has olvidado tu contraseña?</a>
                                </div>
                            </div> -->

                            <div class="form-group">
                                <!-- Campo oculto para visitorId -->
                                <input type="hidden" id="visitor_id" name="visitor_id" value="">
                                <input type="hidden" name="enviar" class="form-control" value="si">
                                <button type="submit" class="form-control btn btn-inline btn-primary">Acceder</button>
                            </div>

                            <!-- <div class="form-group">
                                <div class="float-right">
                                    <a id="autpc" style="color:#38BC00;"><i class="fa fa-desktop"></i>&nbsp;&nbsp;</a>
                                    <a href="2fa.php" style="color:#38BC00;"><i class="font-icon font-icon-lock"></i></a>
                                </div>
                            </div> -->

                            <?php
if (isset($_GET["m"])) {
    switch ($_GET["m"]) {
        case "1":
            echo '<script type="text/javascript">
                                            swal({
                                            title: "Error",
                                            text: "Usuario o Contraseña incorrectos.",
                                            icon: "error",
                                            button: "Aceptar"
                                            });
                                        </script>';
            break;

        case "3":
            ?>
                                        <script src="public/js/lib/jquery/jquery.min.js"></script>
                                        <script>
                                            $(document).ready(function() {
                                                $('#modalautpc').modal('show');
                                            });
                                        </script>
                            <?php
break;
    }
}
?>
                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div><!--.page-center-->

    <!-- Modal autorizacion -->
    <div class="modal fade" id="modalautpc" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" href="index.php">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Solicitar autorización de equipo</h4>
                </div>

                <div class="modal-body">
                    <form method="post" id="form_autorizacion">

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="alert alert-danger alert-icon alert-close alert-dismissible fade in" role="alert">
                                    <i class="font-icon font-icon-warning"></i>
                                    El equipo desde el cual está intentando ingresar no se encuentra autorizado. Por favor, ingrese el nombre del equipo en el campo a continuación para solicitar autorización.
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label" for="nom_pc">Nombre equipo: </label>
                                    <input type="text" class="form-control" id="nom_pc" name="nom_pc" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="action" class="btn btn-primary" id="autorizar" value="add">Autorizar</button>
                            <button type="button" id="cerrar" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> <!-- Fin del modal -->

    <?php require_once "modalresetpass.php";?>


    <script src="public/js/lib/jquery/jquery.min.js"></script>
    <script src="public/js/lib/tether/tether.min.js"></script>
    <script src="public/js/lib/bootstrap/bootstrap.min.js"></script>
    <script src="public/js/lib/bootstrap-sweetalert/sweetalert.min.js"></script>
    <script src="public/js/plugins.js"></script>
    <script type="text/javascript" src="public/js/lib/match-height/jquery.matchHeight.min.js"></script>

    <script>
        $(function() {
            $('.page-center').matchHeight({
                target: $('html')
            });

            $(window).resize(function() {
                setTimeout(function() {
                    $('.page-center').matchHeight({
                        remove: true
                    });
                    $('.page-center').matchHeight({
                        target: $('html')
                    });
                }, 100);
            });

            // cerrar modelautorizacionpc
            $('#autorizacion').on('hidden.bs.modal', function() {
                location.href = "index.php";
            });
            // cancelar modelautorizacionpc
            $('#autorizacion #cerrar').on('click', function() {
                location.href = "index.php";
            });

            // Autorizar modelautorizacionpc
            $('#autorizacion #autorizar').on('click', function(e) {
                e.preventDefault();
                var nom = $('#nom_pc').val();
                if (nom != "" && nom != null) {
                    var formData = new FormData($("#form_autorizacion")[0]);
                    formData.append('huellapc', visitorId);
                    formData.append('usu_id', usu_id);
                    // Hacer la solicitud POST utilizando jQuery
                    $.ajax({
                        url: "controller/usuario.php?op=crear_autorizacionpc",
                        type: "POST",
                        data: formData,
                        processData: false, // No procesar los datos (FormData se encarga)
                        contentType: false, // No configurar el tipo de contenido (FormData se encarga)
                        success: function(data) {
                            $('#autorizacion').modal("hide");

                            swal({
                                title: "BYAPPS::CRM",
                                text: "Autorización enviada con éxito.",
                                icon: "success",
                                button: "OK",
                            });

                        },
                        error: function(xhr, status, error) {
                            // Manejar errores de la solicitud aquí
                            swal("Error: " + error);
                        }
                    });
                }
            });

        });
    </script>

    <script src="login.js"></script>
    <script src="public/js/app.js"></script>

    <div class="responsive-bootstrap-toolkit">
        <div class="device-xs visible-xs visible-xs-block"></div>
        <div class="device-sm visible-sm visible-sm-block"></div>
        <div class="device-md visible-md visible-md-block"></div>
        <div class="device-lg visible-lg visible-lg-block"></div>
    </div>
</body>

</html>