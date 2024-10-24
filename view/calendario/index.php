<?php
require_once "../../config/conexion.php";
if (isset($_SESSION["usu_id"])) {
?>
    <!DOCTYPE html>
    <html>
    <link rel="stylesheet" href="../../public/css/separate/vendor/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="../../public/css/separate/pages/calendar.min.css">
    <link rel="stylesheet" href="../../vendor/fullcalendar/fullcalendar.css">
    <link rel="stylesheet" href="../../public/css/lib/clockpicker/bootstrap-clockpicker.min.css">
    <link rel="stylesheet" href="../../public/css/lib/summernote/summernote.css">
    <link rel="stylesheet" href="../../public/css/lib/jquery-minicolors/jquery.minicolors.css">
    <link rel="stylesheet" href="../../public/css/separate/vendor/jquery.minicolors.min.css">

    <?php require_once "../mainhead/head.php"; ?>

    <title>CRM :: Calendario </title>
    </head>

    <style>
        .material-symbols-rounded {
            font-size: 24px;
            /* Ajusta el tamaño del ícono si es necesario */
            transition: color 0.3s ease;
            /* Añade transición al color en hover */
        }
    </style>

    <body class="with-side-menu">
        <?php require_once "../mainheader/header.php"; ?>
        <div class="mobile-menu-left-overlay"></div>
        <?php require_once "../mainnav/nav.php"; ?>
        <div class="page-content">

            <header class="page-content-header">
                <div class="container-fluid">
                    <ol class="breadcrumb breadcrumb-simple">
                        <li><a href="../home/"><span class="material-symbols-rounded" style="color:#5B80A3; position:static; font-size:20px">home</span></a></li>
                        <li class="active">Calendario</li>
                    </ol>
                </div>
            </header>

            <div class="container-fluid">
                <div class="box-typical">
                    <div class="calendar-page">

                        <div class="calendar-page-content">
                            <div class="calendar-page-title">
                                <button class="btn btn-secondary" id="add-event" type="button"><i class="fa fa-plus"></i>&nbsp;
                                    Crear
                                </button>
                            </div>
                            <div class="calendar-page-content-in">
                                <div id='calendar'></div>
                            </div><!--.calendar-page-content-in-->
                        </div><!--.calendar-page-content-->

                        <div class="calendar-page-side">
                            <section class="calendar-page-side-section">
                                <div class="calendar-page-side-section-in">
                                    <div id="side-datetimepicker"></div>
                                </div>
                            </section>

                            <section class="calendar-page-side-section">
                                <header class="box-typical-header-sm">
                                    Mis Calendarios
                                    <button id="add-calendar"
                                        style="float: right; background-color: transparent; color: #4a4a4a; font-size: 14px; font-weight: 600; cursor: pointer; border: none; outline: none;">
                                        +
                                    </button>
                                </header>
                                <div class="calendar-page-side-section-in" id="calendarios">
                                </div>
                            </section>

                            <section class="calendar-page-side-section">
                                <header class="box-typical-header-sm">
                                    Categorias
                                </header>
                                <div class="calendar-page-side-section-in" id="categorias">
                                </div>
                            </section>

                        </div><!--.calendar-page-side-->
                    </div><!--.calendar-page-->
                </div><!--.box-typical-->
            </div><!--.container-fluid-->

        </div><!--.page-content-->
        <?php require_once "modaltarea.php"; ?>
        <?php require_once "modalcalendar.php"; ?>
        <?php require_once "../mainjs/js.php"; ?>
        <script type="text/javascript" src="calendario.js"></script>
        <script src="../../public/js/lib/summernote/summernote.min.js"></script>
        <script type="text/javascript" src="../../public/js/lib/match-height/jquery.matchHeight.min.js"></script>
        <script type="text/javascript" src="../../public/js/lib/moment/moment-with-locales.min.js"></script>
        <script type="text/javascript" src="../../public/js/lib/moment/locale/es.js"></script>
        <script type="text/javascript" src="../../public/js/lib/eonasdan-bootstrap-datetimepicker/bootstrap-datetimepicker.min.js"></script>
        <script src="../../vendor/fullcalendar/index.global.min.js"></script>
        <script src="../../vendor/fullcalendar/locales/es.global.min.js"></script>
        <script src="../../public/js/lib/jquery-minicolors/jquery.minicolors.min.js"></script>

        <script>
            $(document).ready(function() {
                // -------- FECHA -------- //
                // Obtener la fecha actual y formatearla
                var currentDate = moment().format('DD/MM/YYYY');

                // Establecer la fecha en el campo
                $('#tar_fcierre').val(currentDate);

                // Inicializar el datetimepicker                    
                $('#tar_fcierre').datetimepicker({
                    format: 'DD/MM/YYYY', // Ajusta el formato según lo que necesites
                    locale: 'es', // Ajusta el idioma a español
                    showClose: true,
                    showTodayButton: true
                });

                // Mostrar el datetimepicker cuando se hace clic en el icono
                $('#calen').click(function() {
                    $('#tar_fcierre').focus(); // Forzar que se abra el calendario
                });

                // -------- HORAS -------- //
                // Función para obtener la hora actual redondeada al minuto más cercano
                function getRoundedTime() {
                    var now = new Date();
                    var hours = now.getHours();
                    var minutes = now.getMinutes();

                    // Redondear minutos a 0 o 30
                    if (minutes < 15) {
                        minutes = 0; // Redondear a la hora
                    } else if (minutes < 45) {
                        minutes = 30; // Redondear a media hora
                    } else {
                        hours = (hours + 1) % 24; // Aumentar la hora y manejar el rollover
                        minutes = 0; // Redondear a la siguiente hora
                    }

                    // Asegurar que las horas y minutos tengan dos dígitos
                    hours = (hours < 10 ? '0' : '') + hours;
                    minutes = (minutes < 10 ? '0' : '') + minutes;
                    return hours + ':' + minutes;
                }

                // Establecer la hora redondeada en los dos campos
                $('.datetimepicker-2 input').each(function() {
                    $(this).val(getRoundedTime());
                });

                // Inicializar el clockpicker para el selector de hora en formato circular
                $('.datetimepicker-2').clockpicker({
                    autoclose: true, // Cierra el reloj automáticamente después de seleccionar la hora
                    placement: 'bottom', // Posición del reloj (ajustable según tu preferencia)
                    align: 'left', // Alineación del reloj
                    donetext: 'Aceptar', // Texto del botón para confirmar la hora
                    twelvehour: false // False para formato de 24 horas, true para 12 horas con AM/PM
                });

                // Mostrar el clockpicker al hacer clic en el ícono del reloj
                $('.font-icon-clock').click(function() {
                    $(this).closest('.input-group').find('input').focus();
                });



                $('#tar_com').summernote({
                    popover: false,
                    height: 100, // altura del editor
                    lang: "es-ES",
                    toolbar: [
                        ["style", ["bold", "italic", "underline", "clear"]],
                        ["fontsize", ["fontsize"]],
                        ["color", ["color"]],
                        ["para", ["ul", "ol", "paragraph"]],
                        ["height", ["height"]],
                    ],
                });
            });
        </script>

        <script>
            (function() {
                $(document).ready(function() {
                    $('.demo').each(function() {
                        $(this).minicolors({
                            control: $(this).attr('data-control') || 'hue',
                            defaultValue: $(this).attr('data-defaultValue') || '',
                            format: $(this).attr('data-format') || 'hex',
                            keywords: $(this).attr('data-keywords') || '',
                            inline: $(this).attr('data-inline') === 'true',
                            letterCase: $(this).attr('data-letterCase') || 'lowercase',
                            opacity: $(this).attr('data-opacity'),
                            position: $(this).attr('data-position') || 'bottom left',
                            swatches: $(this).attr('data-swatches') ? $(this).attr('data-swatches').split('|') : [],
                            theme: 'bootstrap'
                        });

                    });
                });
            })();
        </script>

    </body>

    </html>

<?php
} else {
    header("Location:" . Conectar::ruta() . "index.php");
}
?>