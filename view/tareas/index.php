<?php
require_once "../../config/conexion.php";
if (isset($_SESSION["usu_id"])) {
?>
    <!DOCTYPE html>
    <html>
    <link rel="stylesheet" href="../../public/css/lib/datatables-net/datatables.min.css">
    <link rel="stylesheet" href="../../public/css/separate/vendor/datatables-net.min.css">
    <link rel="stylesheet" href="../../public/css/separate/vendor/bootstrap-daterangepicker.min.css">
    <link rel="stylesheet" href="../../public/css/lib/summernote/summernote.css">
    <link rel="stylesheet" href="../../public/css/separate/pages/editor.min.css">
    <link rel="stylesheet" href="../../public/css/separate/pages/widgets.min.css">
    <?php require_once "../mainhead/head.php"; ?>
    <title>CRM :: Tareas </title>
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
                        <li class="active">Tareas</li>
                    </ol>
                </div>
            </header>

            <div class="container-fluid">

                <div class="row">
                    <div class="col-xl-12">
                        <header class="widget-header-dark with-btn">Filtros
                            <button type="button" id="btntodo" class="widget-header-btn" style="background: #eceeef;">
                                <i class="font-icon font-icon-refresh"></i>
                            </button>
                        </header>
                        <div class="box-typical box-typical-padding" style="padding: 15px 10px;">
                            <form method="post" id="filtros_form">
                                <div class="row" id="viewuser">
                                    <div class="col-lg-12">

                                        <div class="col-lg-4">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold">Fechas</label>
                                                <div class="input-group date">
                                                    <input id="daterange" name="daterange" type="text" class="form-control">
                                                    <span class="input-group-addon">
                                                        <i class="font-icon font-icon-calend"></i>
                                                    </span>
                                                </div>
                                            </fieldset>
                                        </div>

                                        <div class="col-lg-4">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold">Categorias</label>
                                                <select class="select2" id="fil_cattarea" name="fil_cattarea" data-placeholder="Seleccionar">
                                                    <option label="Seleccionar"></option>
                                                </select>
                                            </fieldset>
                                        </div>

                                        <div class="col-lg-4">
                                            <fieldset class="form-group">
                                                <label class="form-label semibold">Estado</label>
                                                <select class="select2" id="fil_catestado" name="fil_catestado" data-placeholder="Seleccionar">
                                                    <option value="0">TODO</option>
                                                    <option value="1">NUEVA</option>
                                                    <option value="2">EN CURSO</option>
                                                    <option value="3">COMPLETADA</option>
                                                    <option value="4">VENCIDA</option>
                                                    <option value="5">ELIMINADA</option>
                                                </select>
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>

                <div class="box-typical box-typical-padding" id="table">
                    <button type="button" id="btnnueva" class="btn btn-inline btn-primary"><i class="fa fa-plus"></i>&nbsp;Tarea</button>
                    <table id="tarea_data" class="table table-bordered table-striped table-vcenter js-dataTable-full">
                        <thead>
                            <tr>
                                <th style="width: 30%;">Título</th>
                                <th class="d-none d-sm-table-cell" style="width: 5%;">Asignado</th>
                                <th class="d-none d-sm-table-cell" style="width: 5%;">Cliente</th>
                                <th class="d-none d-sm-table-cell" style="width: 5%;">Prioridad</th>
                                <th class="d-none d-sm-table-cell" style="width: 10%;">Categoria</th>
                                <th class="d-none d-sm-table-cell" style="width: 10%;">Estado</th>
                                <th class="d-none d-sm-table-cell" style="width: 10%;">Vencimiento</th>
                                <th style="width: 1%;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div><!--.page-content-->

        <?php require_once "modaltarea.php"; ?>
        <?php require_once "../mainjs/js.php"; ?>
        <script type="text/javascript" src="tareas.js"></script>

        <script>
            $(function() {
                $('#daterange').daterangepicker({

                    locale: {
                        format: 'DD/MM/YYYY',
                        applyLabel: "Aplicar",
                        cancelLabel: "Cancelar",
                        "customRangeLabel": "Personalizado",
                        daysOfWeek: [
                            "D",
                            "L",
                            "M",
                            "M",
                            "J",
                            "V",
                            "S"
                        ],
                        monthNames: [
                            "Enero",
                            "Febrero",
                            "Marzo",
                            "Abril",
                            "Mayo",
                            "Junio",
                            "Julio",
                            "Agosto",
                            "Septiembre",
                            "Octubre",
                            "Noviembre",
                            "Diciembre"
                        ],
                    },

                    startDate: moment().startOf('month'),
                    endDate: moment(),
                    autoApply: true,



                    ranges: {
                        'Hoy': [moment(), moment()],
                        'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Ultimos 7 Dias': [moment().subtract(6, 'days'), moment()],
                        'Ultimos 30 Dias': [moment().subtract(29, 'days'), moment()],
                        'Este Mes': [moment().startOf('month'), moment().endOf('month')],
                        'Mes Anterior': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]

                    },


                    "alwaysShowCalendars": true,

                });
                /* ============= Datepicker ====================================== */
                var currentDate = new Date();
                // Configuración regional en español
                var localeConfig = {
                    format: 'DD/MM/YYYY',
                    daysOfWeek: ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb"],
                    monthNames: [
                        "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
                        "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
                    ]
                };

                $('#tar_fcierre').daterangepicker({
                    singleDatePicker: true,
                    showDropdowns: true,
                    locale: localeConfig

                });
            });
        </script><!--.Funcion DateTIME-->
    </body>

    </html>
<?php
} else {
    header("Location:" . Conectar::ruta() . "index.php");
}
?>