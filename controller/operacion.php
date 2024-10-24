<?php
require_once "../config/conexion.php";
require_once "../models/operacion.php";

$key = "@L1b3lul4*2024*1Nv3sT0r/By4pp5";
$cipher = "aes-256-cbc";
$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));

$operacion = new Operacion();

switch ($_GET["op"]) {

    case "listarOpe":
        $fechastar = $_POST['daterange'];
        // DIVIDIR FECHAS
        $fechas = explode(" - ", $fechastar);
        $fechaInicio = DateTime::createFromFormat('d/m/Y', $fechas[0]);
        $fechaFin = DateTime::createFromFormat('d/m/Y', $fechas[1]);
        // FORMATOS
        $fechaInicio = $fechaInicio->format('Y-m-d');
        $fechaFin = $fechaFin->format('Y-m-d');

        $datos = $operacion->listar_operaciones(
            $fechaInicio,
            $fechaFin,
            $_POST["usu_perfil"],
            $_POST["fil_entidad"],
            $_POST["fil_grupo"],
            $_POST["fil_asesor"],
            $_POST["estado"],
            $_POST["filtro"]
        );

        $data = array();
        foreach ($datos as $row) {
            $identidad = $row["ent_id"];
            $fecha1 = "";
            $fecha2 = "";
            $titulo;

            if ($row["ope_est"] = "Radicacion" || $row["ope_est"] = "Proceso" || $row["ope_est"] = "Devolucion") {
                $fecha2 = $row["ope_feradi"];
                $fecha1 = $row["ope_feest"];

                if ($fecha2 == "" || $fecha2 == null) {
                    $fecha2 = "";
                } else {
                    $fecha2 = isset($row["ope_feradi"]) ? DateTime::createFromFormat('Y-m-d', $row["ope_feradi"])->format('d/m/Y') : null;
                }

                if ($fecha1 == "" || $fecha1 == null) {
                    $fecha1 = "";
                } else {
                    $fecha1 = isset($row["ope_feest"]) ? DateTime::createFromFormat('Y-m-d', $row["ope_feest"])->format('d/m/Y') : null;
                }
            } else if ($row["ope_estope"] = "Negado" || $row["ope_estope"] = "Desembolsado") {
                $fecha1 = $row["ope_feest"];
                $fechacie = $row["ope_fecie"];

                if ($fecha1 == "" || $fecha1 == null) {
                    $fecha1 = "";
                } else {
                    $fecha1 = isset($row["ope_feest"]) ? DateTime::createFromFormat('Y-m-d', $row["ope_feest"])->format('d/m/Y') : null;
                }

                if ($fecha2 == "" || $fecha2 == null) {
                    $fecha2 = "";
                } else {
                    $fecha2 = isset($row["ope_fecie"]) ? DateTime::createFromFormat('Y-m-d', $row["ope_fecie"])->format('d/m/Y') : null;
                }
            } else {
                $fecha1 = $row["ope_feest"];
                $fecha2 = "";
            }

            $sub_array = array();
            $sub_array[] = $row["cli_doc"];
            $sub_array[] = $row["cli_nom"];
            $sub_array[] = $row["ope_ope"];
            $sub_array[] = "$" . number_format($row["ope_mon"], 0, ',', '.');
            $sub_array[] = $row["ent_nom"];
            $sub_array[] = $row["detu_nom"]." ".$row["detu_ape"];
            $sub_array[] = $row["ope_estope"];
            $sub_array[] = $row["suc_ciu"];
            $sub_array[] = $fecha1; //fecha estado
            $sub_array[] = $fecha2;

            $cifrado = openssl_encrypt($row["cli_id"], $cipher, $key, OPENSSL_RAW_DATA, $iv);
            $textocifrado = base64_encode($iv . $cifrado);

            $sub_array[] = '<button name="ver" type="button" data-ope="' . $textocifrado . '" id="' . $textocifrado . '" class="btn btn-inline btn-primary btn-sm ladda-button"><div><i class="fa fa-eye"></i></button>';

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

    case "filtrarOpe":
        $fechastar = $_POST['daterange'];
        $fechas = explode(" - ", $fechastar);
        $fechaInicio = DateTime::createFromFormat('d/m/Y', $fechas[0]);
        $fechaInicio = $fechaInicio->format('Y-m-d');
        $fechaFin = DateTime::createFromFormat('d/m/Y', $fechas[1]);
        $fechaFin = $fechaFin->format('Y-m-d');

        $datos = $operacion->filtrar_ope(
            $fechaInicio,
            $fechaFin,
            $_POST["usu_perfil"],
            $_POST["fil_entidad"],
            $_POST["fil_grupo"],
            $_POST["fil_asesor"],
            $_POST["filtro"]
        );
        $output = array(
            "radicacion" => 0,
            "devolucion" => 0,
            "negado" => 0,
            "desembolsados" => 0,
            "proceso" => 0,
        );
        if (isset($datos[0])) {
            $output["radicacion"] = isset($datos[0]['radicacion']) ? $datos[0]['radicacion'] : 0;
            $output["devolucion"] = isset($datos[0]['devolucion']) ? $datos[0]['devolucion'] : 0;
            $output["negado"] = isset($datos[0]['negado']) ? $datos[0]['negado'] : 0;
            $output["desembolsados"] = isset($datos[0]['desembolsados']) ? $datos[0]['desembolsados'] : 0;
            $output["proceso"] = isset($datos[0]['proceso']) ? $datos[0]['proceso'] : 0;
        }
        echo json_encode($output);
        break;

    case "filtrarsumaOpe":
        $fechastar = $_POST['daterange'];
        $fechas = explode(" - ", $fechastar);
        $fechaInicio = DateTime::createFromFormat('d/m/Y', $fechas[0]);
        $fechaInicio = $fechaInicio->format('Y-m-d');
        $fechaFin = DateTime::createFromFormat('d/m/Y', $fechas[1]);
        $fechaFin = $fechaFin->format('Y-m-d');

        $datos = $operacion->filtrar_suma_ope(
            $fechaInicio,
            $fechaFin,
            $_POST["usu_perfil"],
            $_POST["fil_entidad"],
            $_POST["fil_grupo"],
            $_POST["fil_asesor"],
            $_POST["filtro"]
        );
        $output = array(
            "vradicacion" => 0,
            "vDevoluciones" => 0,
            "vDesembolsados" => 0,
            "vnegado" => 0,
            "vProceso" => 0,
        );
        if (isset($datos[0])) {
            $output["vradicacion"] = isset($datos[0]['vradicacion']) ? $datos[0]['vradicacion'] : 0;
            $output["vDevoluciones"] = isset($datos[0]['vdevolucion']) ? $datos[0]['vdevolucion'] : 0;
            $output["vnegado"] = isset($datos[0]['vnegado']) ? $datos[0]['vnegado'] : 0;
            $output["vDesembolsados"] = isset($datos[0]['vdesembolsados']) ? $datos[0]['vdesembolsados'] : 0;
            $output["vProceso"] = isset($datos[0]['vProceso']) ? $datos[0]['vProceso'] : 0;

        }
        echo json_encode($output);
        break;

//---------------------------

    case "listaropexcliente":
        $perfil = $_SESSION['usu_perfil'];

        $iv_dec = substr(base64_decode($_POST["cli_id"]), 0, openssl_cipher_iv_length($cipher));
        $cifradosinIV = substr(base64_decode($_POST["cli_id"]), openssl_cipher_iv_length($cipher));
        $decifrado = openssl_decrypt($cifradosinIV, $cipher, $key, OPENSSL_RAW_DATA, $iv_dec);
        $decifrado = str_replace(['"', "'"], '', $decifrado);
        $decifrado = (int)$decifrado;

        $datos = $operacion->listar_operaciones_x_cliente($decifrado);

        $data = array();
        $tituloFecha = 'Fecha Estado'; // Valor por defecto

        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["ope_cod"];
            $sub_array[] = $row["ope_ope"];
            $sub_array[] = $row["ent_nom"];
            $sub_array[] = "$" . number_format($row["ope_mon"], 0, ',', '.');
            $sub_array[] = $row["ope_estope"];

            //fechas
            if($row["ope_est"] == "Radicacion"){
                $tituloFecha = "Fecha Radicacion";
                $festado = isset($row["ope_feradi"]) ? DateTime::createFromFormat('Y-m-d', $row["ope_feradi"])->format('d/m/Y') : null;

            }else if($row["ope_est"] == "Proceso" || $row["ope_est"] == "Devolucion"){
                $tituloFecha = "Fecha Estado";
                $festado = isset($row["ope_feest"]) ? DateTime::createFromFormat('Y-m-d', $row["ope_feest"])->format('d/m/Y') : null;

            }else if($row["ope_est"] == "Negado" || $row["ope_est"] == "Desembolsado"){
                $tituloFecha = "Fecha de Cierre";
                $festado = isset($row["ope_fecie"]) ? DateTime::createFromFormat('Y-m-d', $row["ope_fecie"])->format('d/m/Y') : null;
            }            
            $sub_array[] = $festado;

            if ($perfil != "Asesor" && $perfil != "Coordinador") {
                $sub_array[] = '
                <button type="button" onClick="editarope(' . $row["ope_id"] . ');"  id="' . $row["ope_id"] . '" class="btn btn-inline btn-warning btn-sm ladda-button"><i class="fa fa-edit"></i></button>
                <button type="button" onClick="eliminar(' . $row["ope_id"] . ');"  id="eliminarope" class="btn btn-inline btn-danger btn-sm ladda-button"><i class="fa fa-trash"></i></button>
                ';
            }

            $data[] = $sub_array;
        }
        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data,
            "tituloFecha" => $tituloFecha, 
        );
        echo json_encode($results);
        break;

    case "validarope":
        $datos = $operacion->validarDato($_POST["ope_numero"], $_POST["ope_entidad"]);
        echo json_encode($datos);
        break;

    case "guardaryeditar":
        $iv_dec = substr(base64_decode($_POST["id_cli"]), 0, openssl_cipher_iv_length($cipher));
        $cifradosinIV = substr(base64_decode($_POST["id_cli"]), openssl_cipher_iv_length($cipher));
        $decifrado = openssl_decrypt($cifradosinIV, $cipher, $key, OPENSSL_RAW_DATA, $iv_dec);
        $decifrado = str_replace(['"', "'"], '', $decifrado);
        $decifrado = (int)$decifrado;

        $ope_feradicacion = "0000-00-00";
        $ope_fcierre = "0000-00-00";
        $ope_festado = new DateTime();
        $ope_festado = $ope_festado->format('Y-m-d');

        if ($_POST["ope_estado"] == 'Radicacion') {
            if (!empty($_POST["ope_feradicacion"])) {
                $dateInput = $_POST["ope_feradicacion"]; // Formato DD/MM/YYYY
                $date = DateTime::createFromFormat('d/m/Y', $dateInput);
                $ope_feradicacion = $date->format('Y-m-d');
            } else {
                $ope_feradicacion = $ope_festado;
            }
        } elseif ($_POST["ope_estado"] == 'Desembolsado' || $_POST["ope_estado"] == 'Negado') {
            if (!empty($_POST["ope_fcierre"])) {
                $dateInput = $_POST["ope_fcierre"]; // Formato DD/MM/YYYY
                $date = DateTime::createFromFormat('d/m/Y', $dateInput);
                $ope_fcierre = $date->format('Y-m-d');
            } else {
                $ope_fcierre = $ope_festado;
            }
        } else {
            if (!empty($_POST["ope_festado"])) {
                $dateInput = $_POST["ope_festado"]; // Formato DD/MM/YYYY
                $date = DateTime::createFromFormat('d/m/Y', $dateInput);
                $ope_festado = $date->format('Y-m-d');
            }
        }

        $ope_monto = preg_replace('/[^\d]/', '', $_POST["ope_monto"]); // Elimina todo lo que no sea un dígito
        $ope_maprobado = preg_replace('/[^\d]/', '', $_POST["ope_maprobado"]); // Elimina todo lo que no sea un dígito

        if (empty($_POST["ope_id"])) {
            $operacion->insert_ope($_POST["ope_numero"], $_POST["ope_operacion"], $_POST["ident"], $_POST["ope_sucursal"], $ope_monto, $ope_maprobado, $_POST["ope_plazo"], $_POST["ope_tasa"], $_POST["ope_estadoOP"], $_POST["ope_estado"], $ope_feradicacion, $decifrado);
            echo "1";
        } else {
            $operacion->update_operacion($_POST["ope_id"], $_POST["ope_numero"], $_POST["ope_operacion"], $_POST["ope_sucursal"], $ope_monto, $ope_maprobado, $_POST["ope_plazo"], $_POST["ope_tasa"], $_POST["ope_estadoOP"], $_POST["ope_estado"], $ope_festado, $ope_fcierre);
            echo "2";
        }

        break;

    case "mostrar":
        $datos = $operacion->mostrar($_POST["op_id"]);
        echo json_encode($datos);
        break;

    //------------------------------------------
    case "bopexno":
        $datos = $operacion->bopexno($_POST["noope"], $_POST["ident"]);
        echo json_encode($datos);
        break;

    case "insert_ope":
        $datos = $operacion->insert_ope(
            $_POST["ope_numero"],
            $_POST["ope_operacion"],
            $_POST["ope_entidad"],
            $_POST["ope_monto"],
            $_POST["ope_maprobado"],
            $_POST["ope_plazo"],
            $_POST["ope_estadoOP"],
            $_POST["ope_estado"],
            $_POST["ope_festado"],
            $_POST["ope_fcierre"],
            $_POST["ope_fcreacion"],
            $_POST["id_cli"],
            $_POST["tasa"],
            // $_POST["suc_id"]
        );
        echo json_encode($datos);
        break;

    // case "editar_ope":
    //     $datos = $operacion->update_operacion(
    //         $_POST["ope_id"],
    //         $_POST["ope_numero"],
    //         $_POST["ope_operacion"],
    //         $_POST["ope_entidad"],
    //         $_POST["ope_monto"],
    //         $_POST["ope_maprobado"],
    //         $_POST["ope_plazo"],
    //         $_POST["ope_estadoOP"],
    //         $_POST["ope_estado"],
    //         $_POST["ope_festado"],
    //         $_POST["ope_fcierre"],
    //     );
    //     echo json_encode($datos);
    //     break;

    case "idoperacion":
        $datos = $operacion->idoperacion($_POST["nooperacion"], $_POST["ident"]);
        echo json_encode($datos);
        break;

}
