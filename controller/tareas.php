<?php
require_once "../config/conexion.php";
require_once "../models/tareas.php";

$key = "@L1b3lul4*2024*1Nv3sT0r/By4pp5";
$cipher = "aes-256-cbc";
$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));

$tareas = new Tareas();

switch ($_GET["op"]) {
        //TAREA
    case "guardaryeditar":
        $fecha = DateTime::createFromFormat('d/m/Y', $_POST["tar_fcierre"]);
        $fecha = $fecha->format('Y-m-d');

        if (empty($_POST["tar_id"])) {
            $tareas->crear_tarea($_POST["tar_asun"], $_POST["tar_det"], $_POST["tar_com"], $_POST["tar_asig"], $_POST["tar_cli"], $_POST["tar_cat"], $_POST["tar_pri"], $fecha, $_POST["tar_est"], $_SESSION["usu_id"]);
            echo "1";
        } else {
            $asunto = isset($_POST["tar_asun"]) ? $_POST["tar_asun"] : 0;
            $detalle = isset($_POST["tar_det"]) ? $_POST["tar_det"] : 0;
            $cliente = isset($_POST["tar_cli"]) ? $_POST["tar_cli"] : 0;

            $tareas->editar_tarea($_POST["tar_id"], $asunto, $detalle, $_POST["tar_com"], $cliente, $_POST["tar_cat"], $_POST["tar_pri"], $fecha,  $_POST["tar_est"]);
            echo "2";
        }
        break;
    case "listartareas":
        // DIVIDIR FECHAS
        $fechastar = $_POST['daterange'];
        $fechas = explode(" - ", $fechastar);
        $fechaInicio = DateTime::createFromFormat('d/m/Y', $fechas[0]);
        $fechaInicio = $fechaInicio->format('Y-m-d');
        $fechaFin = DateTime::createFromFormat('d/m/Y', $fechas[1]);
        $fechaFin = $fechaFin->format('Y-m-d');

        $datos = $tareas->listartareas($_SESSION["usu_id"], $fechaInicio, $fechaFin, $_POST["fil_cattarea"], $_POST["fil_catestado"]);

        $data = array();
        $prioridad = "";
        $estado = "";

        date_default_timezone_set('America/Bogota');
        $hoy = date("d/m/Y");

        foreach ($datos as $row) {

            $sub_array = array();
            $sub_array[] = $row["tar_asun"];

            $nombre_asignado = $row["asignadoa"];
            $asignado = '
                <img src="../../public/img/avatar-2-32.png" class="label2mg" alt="Prioridad Baja" title="' . $nombre_asignado . '">';
            $sub_array[] = $asignado;

            $nombre_cliente = $row["cli_nom"];
            $cliente = '
                <img src="../../public/img/avatar-1-32.png" class="label2mg" alt="Prioridad Baja" title="' . $nombre_cliente . '">';
            $sub_array[] = $cliente;

            // Prioridad
            $prioridad = $row["tar_pri"];
            if ($prioridad == "1") {
                $prioridad = '<div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;">
                                <div style="width: 15px; height: 15px; background-color: green; border-radius: 50%;" title="BAJO"></div>
                            </div>';
            } else if ($prioridad == "2") {
                $prioridad = '<div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;">
                                <div style="width: 15px; height: 15px; background-color: orange; border-radius: 50%;" title="MEDIO"></div>
                            </div>';
            } else {
                $prioridad = '<div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;">
                                <div style="width: 15px; height: 15px; background-color: red; border-radius: 50%;" title="ALTO"></div>
                            </div>';
            }
            $sub_array[] = $prioridad;

            $sub_array[] = $row["clasta_nom"];

            //estado
            $estado = $row["tar_est"];
            if ($estado == "1") {
                $estado = '<span class="label label-primary label2mg">NUEVA</span>';
            } else if ($estado == "2") {
                $estado = '<span class="label label-warning label2mg">EN CURSO</span>';
            } else if ($estado == "3") {
                $estado = '<span class="label label-success label2mg">COMPLETADA</span>';
            } else if ($estado == "4") {
                $estado = '<span class="label label-danger label2mg">VENCIDA</span>';
            } else if ($estado == "5") {
                $estado = '<span class="label label-danger label2mg">ELIMINADA</span>';
            } else {
                $estado = "";
            }
            $sub_array[] = $estado;

            //vencimiento            
            $fecha_evento = $row["tar_feven"];
            $fecha_evento = date("d/m/Y", strtotime($fecha_evento));
            if ($fecha_evento == $hoy) {
                // Si la fecha es igual a hoy
                $mensaje_fecha = '<span class="label label-warning" style="font-size:12px;">HOY</span>';
            } elseif ($fecha_evento == date("d/m/Y", strtotime("-1 day"))) {
                // Si la fecha es igual a ayer
                $mensaje_fecha = '<span class="label label-danger" style="font-size:12px;">AYER</span>';
            } elseif ($fecha_evento < date("d/m/Y", strtotime("-1 day"))) {
                // Si la fecha ya pasó de ayer
                $mensaje_fecha = '<span class="label label-danger" style="font-size:12px;">' . $fecha_evento . '</span>';
            } elseif ($fecha_evento == date("d/m/Y", strtotime("+1 day"))) {
                // Si la fecha es la de mañana
                $mensaje_fecha = '<span class="label label-primary" style="font-size:12px;">MAÑANA</span>';
            } else {
                // Para cualquier otro día
                $mensaje_fecha = '<span class="label label-primary" style="font-size:12px;">' . $fecha_evento . '</span>';
            }
            $sub_array[] = $mensaje_fecha;

            $comenEscapado = htmlspecialchars($row["tar_com"], ENT_QUOTES, 'UTF-8');
            $comenEscapado = str_replace(["\r\n", "\r", "\n"], '<br>', $comenEscapado);

            if ($_POST["fil_catestado"] == 5) {
                $sub_array[] = '
                <button type="button" onClick="editar(\'' .
                    $row["tar_id"] . '\', \'' .
                    $row["tar_asun"] . '\', \'' .
                    $row["tar_det"] . '\', \'' .
                    $comenEscapado . '\', \'' .
                    $row["usu_id"] . '\', \'' . //asignapo por
                    $row["asignadopor"] . '\', \'' . //asignapo por
                    $row["tar_usu"] . '\', \'' . //asignapo a
                    $row["asignadoa"] . '\', \'' . //asignapo a
                    $row["cli_id"] . '\', \'' . //cliente
                    $row["cli_nom"] . '\', \'' . //cliente
                    $row["clasta_id"] . '\', \'' .
                    $row["tar_pri"] . '\', \'' .
                    $fecha_evento . '\', \'' .
                    $_SESSION["usu_id"] . '\', \'' .
                    $row["tar_est"] .
                    '\');" id="' . $row["tar_id"] . '" class="btn btn-inline btn-warning btn-sm ladda-button" title="Editar"><i class="glyphicon glyphicon-edit"></i></button>';
            } else {
                $sub_array[] = '
                <button type="button" onClick="editar(\'' .
                    $row["tar_id"] . '\', \'' .
                    $row["tar_asun"] . '\', \'' .
                    $row["tar_det"] . '\', \'' .
                    $comenEscapado . '\', \'' .
                    $row["usu_id"] . '\', \'' . //asignapo por
                    $row["asignadopor"] . '\', \'' . //asignapo por
                    $row["tar_usu"] . '\', \'' . //asignapo a
                    $row["asignadoa"] . '\', \'' . //asignapo a
                    $row["cli_id"] . '\', \'' . //cliente
                    $row["cli_nom"] . '\', \'' . //cliente
                    $row["clasta_id"] . '\', \'' .
                    $row["tar_pri"] . '\', \'' .
                    $fecha_evento . '\', \'' .
                    $_SESSION["usu_id"] . '\', \'' .
                    $row["tar_est"] .
                    '\');" id="' . $row["tar_id"] . '" class="btn btn-inline btn-warning btn-sm ladda-button" title="Editar"><i class="glyphicon glyphicon-edit"></i>
                </button>

                <button type="button" onClick="eliminar(' . $row["tar_id"] . ');"  id="' . $row["tar_id"] . '" class="btn btn-inline btn-danger btn-sm ladda-button" title="Eliminar"><i class="glyphicon glyphicon-trash"></i></button>';
            }

            $data[] = $sub_array;
        }
        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "fecha" => $hoy,
            "aaData" => $data,
        );
        echo json_encode($results);
        break;
    case "listartareasinicio":
        $datos = $tareas->listartareasinicio($_SESSION["usu_id"]);

        $data = array();
        $prioridad = "";
        $estado = "";

        date_default_timezone_set('America/Bogota');
        $hoy = date("d/m/Y");

        foreach ($datos as $row) {

            $sub_array = array();
            $sub_array[] = $row["tar_asun"];

            $nombre_asignado = $row["asignadoa"];
            $asignado = '<img src="../../public/img/avatar-2-32.png" class="label2mg" alt="Prioridad Baja" title="' . $nombre_asignado . '">';
            $sub_array[] = $asignado;

            $nombre_cliente = $row["cli_nom"];
            $cliente = '<img src="../../public/img/avatar-1-32.png" class="label2mg" alt="Prioridad Baja" title="' . $nombre_cliente . '">';
            $sub_array[] = $cliente;

            // Prioridad
            $prioridad = $row["tar_pri"];
            if ($prioridad == "1") {
                $prioridad = '<div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;">
                                <div style="width: 15px; height: 15px; background-color: green; border-radius: 50%;" title="BAJO"></div>
                            </div>';
            } else if ($prioridad == "2") {
                $prioridad = '<div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;">
                                <div style="width: 15px; height: 15px; background-color: orange; border-radius: 50%;" title="MEDIO"></div>
                            </div>';
            } else {
                $prioridad = '<div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;">
                                <div style="width: 15px; height: 15px; background-color: red; border-radius: 50%;" title="ALTO"></div>
                            </div>';
            }
            $sub_array[] = $prioridad;

            $sub_array[] = $row["clasta_nom"];

            //estado
            $estado = $row["tar_est"];
            if ($estado == "1") {
                $estado = '<span class="label label-primary label2mg">NUEVA</span>';
            } else if ($estado == "2") {
                $estado = '<span class="label label-warning label2mg">EN CURSO</span>';
            } else if ($estado == "3") {
                $estado = '<span class="label label-success label2mg">COMPLETADA</span>';
            } else if ($estado == "4") {
                $estado = '<span class="label label-danger label2mg">VENCIDA</span>';
            } else if ($estado == "5") {
                $estado = '<span class="label label-danger label2mg">ELIMINADA</span>';
            } else {
                $estado = "";
            }
            $sub_array[] = $estado;

            //vencimiento            
            $fecha_evento = $row["tar_feven"];
            $fecha_evento = date("d/m/Y", strtotime($fecha_evento));
            if ($fecha_evento == $hoy) {
                // Si la fecha es igual a hoy
                $mensaje_fecha = '<span class="label label-warning" style="font-size:12px;">HOY</span>';
            } elseif ($fecha_evento == date("d/m/Y", strtotime("-1 day"))) {
                // Si la fecha es igual a ayer
                $mensaje_fecha = '<span class="label label-danger" style="font-size:12px;">AYER</span>';
            } elseif ($fecha_evento < date("d/m/Y", strtotime("-1 day"))) {
                // Si la fecha ya pasó de ayer
                $mensaje_fecha = '<span class="label label-danger" style="font-size:12px;">' . $fecha_evento . '</span>';
            } elseif ($fecha_evento == date("d/m/Y", strtotime("+1 day"))) {
                // Si la fecha es la de mañana
                $mensaje_fecha = '<span class="label label-primary" style="font-size:12px;">MAÑANA</span>';
            } else {
                // Para cualquier otro día
                $mensaje_fecha = '<span class="label label-primary" style="font-size:12px;">' . $fecha_evento . '</span>';
            }
            $sub_array[] = $mensaje_fecha;

            $comenEscapado = htmlspecialchars($row["tar_com"], ENT_QUOTES, 'UTF-8');
            $comenEscapado = str_replace(["\r\n", "\r", "\n"], '<br>', $comenEscapado);

            if ($_POST["fil_catestado"] == 5) {
                $sub_array[] = '
                    <button type="button" onClick="editar(\'' .
                    $row["tar_id"] . '\', \'' .
                    $row["tar_asun"] . '\', \'' .
                    $row["tar_det"] . '\', \'' .
                    $comenEscapado . '\', \'' .
                    $row["usu_id"] . '\', \'' . //asignapo por
                    $row["asignadopor"] . '\', \'' . //asignapo por
                    $row["tar_usu"] . '\', \'' . //asignapo a
                    $row["asignadoa"] . '\', \'' . //asignapo a
                    $row["cli_id"] . '\', \'' . //cliente
                    $row["cli_nom"] . '\', \'' . //cliente
                    $row["clasta_id"] . '\', \'' .
                    $row["tar_pri"] . '\', \'' .
                    $fecha_evento . '\', \'' .
                    $_SESSION["usu_id"] . '\', \'' .
                    $row["tar_est"] .
                    '\');" id="' . $row["tar_id"] . '" class="btn btn-inline btn-warning btn-sm ladda-button" title="Editar"><i class="glyphicon glyphicon-edit"></i></button>';
            } else {
                $sub_array[] = '
                    <button type="button" onClick="editar(\'' .
                    $row["tar_id"] . '\', \'' .
                    $row["tar_asun"] . '\', \'' .
                    $row["tar_det"] . '\', \'' .
                    $comenEscapado . '\', \'' .
                    $row["usu_id"] . '\', \'' . //asignapo por
                    $row["asignadopor"] . '\', \'' . //asignapo por
                    $row["tar_usu"] . '\', \'' . //asignapo a
                    $row["asignadoa"] . '\', \'' . //asignapo a
                    $row["cli_id"] . '\', \'' . //cliente
                    $row["cli_nom"] . '\', \'' . //cliente
                    $row["clasta_id"] . '\', \'' .
                    $row["tar_pri"] . '\', \'' .
                    $fecha_evento . '\', \'' .
                    $_SESSION["usu_id"] . '\', \'' .
                    $row["tar_est"] .
                    '\');" id="' . $row["tar_id"] . '" class="btn btn-inline btn-warning btn-sm ladda-button" title="Editar"><i class="glyphicon glyphicon-edit"></i>
                    </button>
    
                    <button type="button" onClick="eliminar(' . $row["tar_id"] . ');"  id="' . $row["tar_id"] . '" class="btn btn-inline btn-danger btn-sm ladda-button" title="Eliminar"><i class="glyphicon glyphicon-trash"></i></button>';
            }

            $data[] = $sub_array;
        }
        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "fecha" => $hoy,
            "aaData" => $data,
        );
        echo json_encode($results);
        break;

    case "eliminar":
        $tareas->delete_tarea($_POST["id"]);
        break;

    case "usu":
        $response = array(
            'nom' => $_SESSION["nom"],
            'perfil' => $_SESSION["usu_perfil"],
            'id' => $_SESSION["usu_id"]
        );
        echo json_encode($response);
        break;



        //CATEGORIA
    case "listarcategoria":
        $datos = $tareas->listarcategoria();

        $data = array();
        $prioridad = "";
        $estado = "";

        date_default_timezone_set('America/Bogota');
        $hoy = date("d/m/Y");

        foreach ($datos as $row) {

            $estado = $row["clasta_est"];
            if ($estado == "1") {
                $estado = '<span class="label label-pill label-success">Activo</span>';
            } else {
                $estado = '<span class="label label-pill label-default">Desconocido</span>';
            }

            $sub_array = array();
            $sub_array[] = $row["clasta_nom"];
            $sub_array[] = $estado;

            $sub_array[] = '
            <button type="button" onClick="editar(\'' . $row["clasta_id"] . '\', \'' . $row["clasta_nom"] . '\', \'' . $row["clasta_est"] . '\');" id="' . $row["clasta_id"] . '" class="btn btn-inline btn-warning btn-sm ladda-button" title="Editar"><i class="glyphicon glyphicon-edit"></i></button>

            <button type="button" onClick="eliminar(' . $row["clasta_id"] . ');"  id="' . $row["clasta_id"] . '" class="btn btn-inline btn-danger btn-sm ladda-button" title="Eliminar"><i class="glyphicon glyphicon-trash"></i></button>
            ';

            $data[] = $sub_array;
        }
        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data,
        );
        echo json_encode($results);
        break;

    case "combocat":
        $datos = $tareas->listarcategoria();
        $html = "";
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $html .= "<option value='" . $row['clasta_id'] . "' data-nombre='" . $row['clasta_nom'] . "'>" . $row['clasta_nom'] . "</option>";
            }
            echo $html;
        }
        break;
    case "guardaryeditarcat":
        if (empty($_POST["catar_id"])) {
            $tareas->crear_categoria($_POST["cat_tar"], $_POST["est_catar"]);
            echo "1";
        } else {
            $tareas->editar_categoria($_POST["catar_id"], $_POST["cat_tar"], $_POST["est_catar"]);
            echo "2";
        }
        break;
    case "eliminarcat":
        $tareas->delete_cat($_POST["id"]);
        break;
    case "listartarInac":
        $datos = $tareas->listarcategoriaInac();
        $data = array();
        $prioridad = "";
        $estado = "";
        date_default_timezone_set('America/Bogota');
        $hoy = date("d/m/Y");
        foreach ($datos as $row) {

            $estado = $row["clasta_est"];
            if ($estado == "2") {
                $estado = '<span class="label label-pill label-danger">Inactivo</span>';
            } else {
                $estado = '<span class="label label-pill label-default">Desconocido</span>';
            }

            $sub_array = array();
            $sub_array[] = $row["clasta_nom"];
            $sub_array[] = $estado;

            $sub_array[] = '
                <button type="button" onClick="editar(\'' . $row["clasta_id"] . '\', \'' . $row["clasta_nom"] . '\', \'' . $row["clasta_est"] . '\');" id="' . $row["clasta_id"] . '" class="btn btn-inline btn-warning btn-sm ladda-button" title="Editar"><i class="glyphicon glyphicon-edit"></i></button>
            ';

            $data[] = $sub_array;
        }
        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data,
        );
        echo json_encode($results);
        break;

        //HOME
    case "numtareas":
        $res = $tareas->numtareas($_POST["usu_id"]);
        echo json_encode($res);
        break;

    case "listar":
        $datos = $tareas->listar($_SESSION["usu_id"]);

        $data = array();
        $prioridad = "";
        $estado = "";

        date_default_timezone_set('America/Bogota');
        $hoy = date("d-m-Y");

        foreach ($datos as $row) {

            $estado = $row["tar_est"];
            if ($estado == "1") {
                $estado = '<span class="label label-primary label2mg">NUEVA</span>';
            } else if ($estado == "2") {
                $estado = '<span class="label label-warning label2mg">EN CURSO</span>';
            } else if ($estado == "3") {
                $estado = '<span class="label label-success label2mg">COMPLETADA</span>';
            } else if ($estado == "4") {
                $estado = '<span class="label label-danger label2mg">VENCIDA</span>';
            } else if ($estado == "5") {
                $estado = '<span class="label label-danger label2mg">ELIMINADA</span>';
            } else {
                $estado = "";
            }

            $prioridad = $row["tar_pri"];
            if ($prioridad == "1") {
                $prioridad = '<span class="label label-success label2mg">B</span>';
            } else if ($prioridad == "2") {
                $prioridad = '<span class="label label-warning label2mg">M</span>';
            } else {
                $prioridad = '<span class="label label-danger label2mg">A</span>';
            }

            $fecha_evento = $row["tar_feven"];
            $fecha_evento = date("d/m/Y", strtotime($fecha_evento));

            if ($fecha_evento == $hoy) {
                // Si la fecha es igual a hoy
                $mensaje_fecha = '<span class="label label-warning" style="font-size:12px;">Hoy</span>';
            } elseif ($fecha_evento == date("d/m/Y", strtotime("-1 day"))) {
                // Si la fecha es igual a ayer
                $mensaje_fecha = '<span class="label label-danger" style="font-size:12px;">Ayer</span>';
            } elseif ($fecha_evento < date("d/m/Y", strtotime("-1 day"))) {
                // Si la fecha ya pasó de ayer
                $mensaje_fecha = '<span class="label label-danger" style="font-size:12px;">' . $fecha_evento . '</span>';
            } elseif ($fecha_evento == date("d/m/Y", strtotime("+1 day"))) {
                // Si la fecha es la de mañana
                $mensaje_fecha = '<span class="label label-primary" style="font-size:12px;">Mañana</span>';
            } else {
                // Para cualquier otro día
                $mensaje_fecha = '<span class="label label-primary" style="font-size:12px;">' . $fecha_evento . '</span>';
            }

            $comenEscapado = htmlspecialchars($row["tar_com"], ENT_QUOTES, 'UTF-8');
            $comenEscapado = str_replace(["\r\n", "\r", "\n"], '<br>', $comenEscapado);

            $sub_array = array();
            $sub_array[] = '
                <a href="#" onClick="editar_tarea(' . $row["tar_id"] . ', \'' .
                $row["tar_asun"] . '\', \'' .
                $row["tar_det"] . '\', \'' .
                $comenEscapado . '\', \'' .
                $row["usu_id"] . '\', \'' . //asignapo por
                $row["asignadopor"] . '\', \'' . //asignapo por
                $row["tar_usu"] . '\', \'' . //asignapo a
                $row["asignadoa"] . '\', \'' . //asignapo a
                $row["cli_id"] . '\', \'' . //cliente
                $row["cli_nom"] . '\', \'' . //cliente
                $row["clasta_id"] . '\', \'' .
                $row["tar_pri"] . '\', \'' .
                $fecha_evento . '\', \'' .
                $_SESSION["usu_id"] . '\', \'' .
                $row["tar_est"] . '\',event);"  id="' . $row["tar_id"] . '" style="color: #606060; font-weight: 500; border-bottom: none; ">' . $row["tar_asun"] . '</a>
                    ';
            $sub_array[] = $prioridad . $estado;

            $sub_array[] = $row["clasta_nom"];
            $sub_array[] = $mensaje_fecha;

            $data[] = $sub_array;
        }
        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "fecha" => $hoy,
            "aaData" => $data,
        );
        echo json_encode($results);
        break;


        //Tareas Clientes
    case "listartareasCli":
        $iv_dec = substr(base64_decode($_POST["id"]), 0, openssl_cipher_iv_length($cipher));
        $cifradosinIV = substr(base64_decode($_POST["id"]), openssl_cipher_iv_length($cipher));
        $decifrado = openssl_decrypt($cifradosinIV, $cipher, $key, OPENSSL_RAW_DATA, $iv_dec);
        $decifrado = str_replace(['"', "'"], '', $decifrado);
        $decifrado = (int)$decifrado;

        $datos = $tareas->listartareascli($decifrado, $_SESSION["usu_id"], $_SESSION["usu_perfil"]);

        $data = array();
        $prioridad = "";
        $estado = "";

        date_default_timezone_set('America/Bogota');
        $hoy = date("d/m/Y");

        foreach ($datos as $row) {

            $sub_array = array();
            $sub_array[] = $row["tar_asun"];

            $nombre_asignado = $row["asignadoa"];
            $asignado = '
                <img src="../../public/img/avatar-2-32.png" class="label2mg" alt="Prioridad Baja" title="' . $nombre_asignado . '">';
            $sub_array[] = $asignado;

            // Prioridad
            $prioridad = $row["tar_pri"];
            if ($prioridad == "1") {
                $prioridad = '<div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;">
                                <div style="width: 15px; height: 15px; background-color: green; border-radius: 50%;" title="BAJO"></div>
                            </div>';
            } else if ($prioridad == "2") {
                $prioridad = '<div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;">
                                <div style="width: 15px; height: 15px; background-color: orange; border-radius: 50%;" title="MEDIO"></div>
                            </div>';
            } else {
                $prioridad = '<div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;">
                                <div style="width: 15px; height: 15px; background-color: red; border-radius: 50%;" title="ALTO"></div>
                            </div>';
            }
            $sub_array[] = $prioridad;

            $sub_array[] = $row["clasta_nom"];

            //estado
            $estado = $row["tar_est"];
            if ($estado == "1") {
                $estado = '<span class="label label-primary label2mg">NUEVA</span>';
            } else if ($estado == "2") {
                $estado = '<span class="label label-warning label2mg">EN CURSO</span>';
            } else if ($estado == "3") {
                $estado = '<span class="label label-success label2mg">COMPLETADA</span>';
            } else if ($estado == "4") {
                $estado = '<span class="label label-danger label2mg">VENCIDA</span>';
            } else if ($estado == "5") {
                $estado = '<span class="label label-danger label2mg">ELIMINADA</span>';
            } else {
                $estado = "";
            }
            $sub_array[] = $estado;

            //vencimiento            
            $fecha_evento = $row["tar_feven"];
            $fecha_evento = date("d/m/Y", strtotime($fecha_evento));
            if ($fecha_evento == $hoy) {
                // Si la fecha es igual a hoy
                $mensaje_fecha = '<span class="label label-warning" style="font-size:12px;">HOY</span>';
            } elseif ($fecha_evento == date("d/m/Y", strtotime("-1 day"))) {
                // Si la fecha es igual a ayer
                $mensaje_fecha = '<span class="label label-danger" style="font-size:12px;">AYER</span>';
            } elseif ($fecha_evento < date("d/m/Y", strtotime("-1 day"))) {
                // Si la fecha ya pasó de ayer
                $mensaje_fecha = '<span class="label label-danger" style="font-size:12px;">' . $fecha_evento . '</span>';
            } elseif ($fecha_evento == date("d/m/Y", strtotime("+1 day"))) {
                // Si la fecha es la de mañana
                $mensaje_fecha = '<span class="label label-primary" style="font-size:12px;">MAÑANA</span>';
            } else {
                // Para cualquier otro día
                $mensaje_fecha = '<span class="label label-primary" style="font-size:12px;">' . $fecha_evento . '</span>';
            }
            $sub_array[] = $mensaje_fecha;

            $comenEscapado = htmlspecialchars($row["tar_com"], ENT_QUOTES, 'UTF-8');
            $comenEscapado = str_replace(["\r\n", "\r", "\n"], '<br>', $comenEscapado);

            if ($_SESSION["usu_perfil"] != "Administrador") {
                $sub_array[] = '
                <button type="button" onClick="editar(\'' .
                    $row["tar_id"] . '\', \'' .
                    $row["tar_asun"] . '\', \'' .
                    $row["tar_det"] . '\', \'' .
                    $comenEscapado . '\', \'' .
                    $row["usu_id"] . '\', \'' . //asignapo por
                    $row["asignadopor"] . '\', \'' . //asignapo por
                    $row["tar_usu"] . '\', \'' . //asignapo a
                    $row["asignadoa"] . '\', \'' . //asignapo a
                    $row["cli_id"] . '\', \'' . //cliente
                    $row["cli_nom"] . '\', \'' . //cliente
                    $row["clasta_id"] . '\', \'' .
                    $row["tar_pri"] . '\', \'' .
                    $fecha_evento . '\', \'' .
                    $_SESSION["usu_id"] . '\', \'' .
                    $row["tar_est"] .
                    '\');" id="' . $row["tar_id"] . '" class="btn btn-inline btn-warning btn-sm ladda-button" title="Editar"><i class="glyphicon glyphicon-edit"></i></button>';
            } else {
                $sub_array[] = '
                <button type="button" onClick="editar(\'' .
                    $row["tar_id"] . '\', \'' .
                    $row["tar_asun"] . '\', \'' .
                    $row["tar_det"] . '\', \'' .
                    $comenEscapado . '\', \'' .
                    $row["usu_id"] . '\', \'' . //asignapo por
                    $row["asignadopor"] . '\', \'' . //asignapo por
                    $row["tar_usu"] . '\', \'' . //asignapo a
                    $row["asignadoa"] . '\', \'' . //asignapo a
                    $row["cli_id"] . '\', \'' . //cliente
                    $row["cli_nom"] . '\', \'' . //cliente
                    $row["clasta_id"] . '\', \'' .
                    $row["tar_pri"] . '\', \'' .
                    $fecha_evento . '\', \'' .
                    $_SESSION["usu_id"] . '\', \'' .
                    $row["tar_est"] .
                    '\');" id="' . $row["tar_id"] . '" class="btn btn-inline btn-warning btn-sm ladda-button" title="Editar"><i class="glyphicon glyphicon-edit"></i>
                </button>

                <button type="button" onClick="eliminar(' . $row["tar_id"] . ');"  id="' . $row["tar_id"] . '" class="btn btn-inline btn-danger btn-sm ladda-button" title="Eliminar"><i class="glyphicon glyphicon-trash"></i></button>';
            }

            $data[] = $sub_array;
        }
        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "fecha" => $hoy,
            "aaData" => $data,
        );
        echo json_encode($results);
        break;
    case "cliente2":
        $iv_dec = substr(base64_decode($_POST["id"]), 0, openssl_cipher_iv_length($cipher));
        $cifradosinIV = substr(base64_decode($_POST["id"]), openssl_cipher_iv_length($cipher));
        $decifrado = openssl_decrypt($cifradosinIV, $cipher, $key, OPENSSL_RAW_DATA, $iv_dec);
        $decifrado = str_replace(['"', "'"], '', $decifrado);
        $decifrado = (int)$decifrado;

        echo $decifrado;
        break;

    case 'adminselect':
        $datos = $tareas->get_usuterm($_POST["term"], $_POST["usuPerfil"], $_SESSION["usu_id"]);
        if (is_array($datos) && count($datos) > 0) {
            echo json_encode($datos);
        } else {
            echo json_encode([]);
        }
        break;
}
