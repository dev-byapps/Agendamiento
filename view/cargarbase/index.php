<?php
require_once "../../config/conexion.php";
if (isset($_SESSION["usu_id"])) {
?>
    <!DOCTYPE html>
    <html>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-tabledit/1.2.3/jquery.tabledit.min.css">
    <?php require_once "../mainhead/head.php"; ?>
    <title>CRM :: Cargar Base </title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        th,
        .row-header {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .selected {
            background-color: #b3d4fc;
        }

        #overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 9999;
        }

        #overlay-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            color: white;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        #overlay-content h2,
        #overlay-content p {
            color: #333;
            text-align: center;
        }
    </style>
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
                        <li><a style="color:#5B80A3;" href="../campanas/">Campañas</a></li>
                        <li class="active" id="tlb_camp">Cargar Base</li>
                    </ol>
                </div>
            </header>

            <div class="container-fluid">
                <div class="box-typical box-typical-padding" id="table">
                    <button type="button" id="btnnueva" class="btn btn-inline btn-primary">Subir Base</button>&nbsp;&nbsp;&nbsp;&nbsp;
                    <button type="button" id="addColumn" class="btn btn-inline btn-success"><i class="fa fa-plus-circle"></i> Col</button>
                    <button type="button" id="removeColumn" class="btn btn-inline btn-danger"><i class="fa fa-minus-circle"></i> Col</button>
                    <button type="button" id="addRow" class="btn btn-inline btn-success"><i class="fa fa-plus-circle"></i> Fila</button>
                    <button type="button" id="removeRow" class="btn btn-inline btn-danger"><i class="fa fa-minus-circle"></i> Fila</button>

                    <div id="barraP" style="display: none;">
                        <progress id="progreso" value="0" max="100"></progress>
                        <span id="progreso_actual">0</span>% completado
                        <span id="total_clientes">0</span> filas
                        <span id="completado"></span>
                    </div>



                    <table id="dynamicTable" style="font-size: 14px;">
                        <thead>
                            <tr>
                                <th class="row-header" style=" width: 1%;"></th>
                                <th style=" width: 10%; background: #c5d2de;" data-value="CEDULA">Cédula</th>
                                <th style=" width: 10%; background: #c5d2de;" data-value="NOMBRE">Nombre</th>
                                <th style=" width: 10%; background: #c5d2de;" data-value="TELEFONO">Teléfono</th>
                                <th style=" width: 10%; background: #c5d2de;" data-value="CONVENIO">Convenio</th>
                                <th style=" width: 10%; background: #c5d2de;" data-value="CIUDAD">Ciudad</th>
                                <th style=" width: 10%;" data-value="DEPARTAMENTO">Departamento</th>
                                <th style=" width: 10%;" data-value="TELALTERNATIVO">Tel. Alternativo</th>
                                <th style=" width: 10%;" data-value="CORREO">Correo</th>
                                <th style=" width: 10%;" data-value="FECNACIMIENTO">F. Nacimiento</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="row-header">1</td>
                                <td contenteditable="true"></td>
                                <td contenteditable="true"></td>
                                <td contenteditable="true"></td>
                                <td contenteditable="true"></td>
                                <td contenteditable="true"></td>
                                <td contenteditable="true"></td>
                                <td contenteditable="true"></td>
                                <td contenteditable="true"></td>
                                <td contenteditable="true"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>


            </div><!--.container-fluid-->
        </div><!--.page-content-->
        <?php require_once "../mainjs/js.php"; ?>

        <script type="text/javascript" src="cargarbase.js"></script>



    </body>

    <div id="overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 1000; text-align: center;">
        <div id="overlay-content" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: #fff; padding: 20px; border-radius: 10px; width: 300px;">
            <h2 style="margin-bottom: 20px;">Procesando</h2>
            <p style="margin-bottom: 20px;">Subiendo datos...</p>
            <div style="display: flex; justify-content: center;">
                <div class="loader" style="border: 8px solid #f3f3f3; border-top: 8px solid #3498db; border-radius: 50%; width: 50px; height: 50px; animation: spin 1s linear infinite;"></div>
            </div>
        </div>
    </div>

    </html>

<?php
} else {
    header("Location:" . Conectar::ruta() . "index.php");
}
?>