<?php
require_once "../config/conexion.php";
require_once "../models/llamada.php";
require_once "../models/usuario.php";
require_once "../models/tareas.php";

$key = "@L1b3lul4*2024*1Nv3sT0r/By4pp5";
$cipher = "aes-256-cbc";
$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));

$llamada = new Llamada();
$usuario = new Usuario();
$tareas = new Tareas();

switch ($_GET["op"]) {

    case "contactos":
        $datos = $llamada->contactos($_POST["cam_id"]);
        echo json_encode($datos);
        break;

    case "subirdatos":
        $cam_id = isset($_POST["cam_id"]) ? $_POST["cam_id"] : '';

        // Filtrar las columnas adicionales (todos los campos menos "cam_id")
        $columnasAdicionales = array_filter(array_keys($_POST), function ($key) {
            return $key !== "cam_id";
        });

        // Crear un array para los valores
        $valores = array();
        foreach ($columnasAdicionales as $columna) {
            $valores[$columna] = $_POST[$columna];
        }

        $datos = $llamada->subirdatos($cam_id, $valores);
        break;

    case "bllamada":        
        $iv_dec = substr(base64_decode($_POST["camp_id"]), 0, openssl_cipher_iv_length($cipher));
        $cifradosinIV = substr(base64_decode($_POST["camp_id"]), openssl_cipher_iv_length($cipher));
        $decifrado = openssl_decrypt($cifradosinIV, $cipher, $key, OPENSSL_RAW_DATA, $iv_dec);
        $decifrado = str_replace(['"', "'"], '', $decifrado);
        $decifrado = (int)$decifrado;

        $datos = $llamada->llamadasinUsuario($decifrado);
        echo json_encode($datos);
        break;  
    case "agenteLlamada":
        $datos = $llamada->agenteLlamada($_POST["usu_id"], $_POST["nombreTabla"]);
        echo json_encode($datos);
        break;

    case "guardarsec":
        $iv_dec = substr(base64_decode($_POST["idcam"]), 0, openssl_cipher_iv_length($cipher));
        $cifradosinIV = substr(base64_decode($_POST["idcam"]), openssl_cipher_iv_length($cipher));
        $decifrado = openssl_decrypt($cifradosinIV, $cipher, $key, OPENSSL_RAW_DATA, $iv_dec);

        $hora = isset($_POST["hora"]) ? $_POST["hora"] : '00:00:00';

        // Convertir la fecha recibida en formato d/m/Y a Y-m-d
        $fecha = DateTime::createFromFormat('d/m/Y', $_POST["agenda"]);
        if ($fecha) {
            $fecha = $fecha->format('Y-m-d');
        } else {
            // Manejo de error si la fecha no se pudo convertir
            $fecha = $_POST["agenda"];
        }       

        if ($_POST["estado"] == "Volver a llamar") {
            $asunto = "Volver a llamar cliente " . $_POST["nombre"] . " de la campaÃ±a " . $_POST["nombrecampaÃ±a"];
            $descrip = $asunto . " hora de llamada: " . $hora;

            $obser = $_POST["observaciones"] . ' Llamar el dia: '.  $fecha;

            $datos = $llamada->guardarsec(
                $obser,
                $_POST["estado"],
                $_POST["tabla"],
                $_POST["id"],
                $hora,
            );

            $llamada->crear_agenda(
                $decifrado,
                $_POST["id"],
                $_POST["conve"],
                $fecha,
                $hora,
                $_SESSION["usu_id"]
            );
        } else {
            $datos = $llamada->guardarsec(
                $_POST["observaciones"],
                $_POST["estado"],
                $_POST["tabla"],
                $_POST["id"],
                $hora,
            );
        }

        echo json_encode($datos);
        break;

    case "llamar":
        $iv_dec = substr(base64_decode($_POST["idcam"]), 0, openssl_cipher_iv_length($cipher));
        $cifradosinIV = substr(base64_decode($_POST["idcam"]), openssl_cipher_iv_length($cipher));
        $camp = openssl_decrypt($cifradosinIV, $cipher, $key, OPENSSL_RAW_DATA, $iv_dec);

        $datos = $llamada->aum_intentos($_POST["idcli"],$camp,);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {       
            $number = $_POST['number'];
            $host = '149.50.137.240';
            $port = 5038;
            $username = 'crmmyuser';
            $password = 'mypass2025**';
            $extension = $_POST['sip_ext']; // La extensiÃ³n desde la que deseas realizar la llamada

            $socket = fsockopen($host, $port, $errno, $errstr, 30);
            if (!$socket) {
                echo "Error: $errstr ($errno)";
                exit(1);
            }

            fputs($socket, "Action: Login\r\n");
            fputs($socket, "Username: $username\r\n");
            fputs($socket, "Secret: $password\r\n\r\n");

            fputs($socket, "Action: Originate\r\n");
            fputs($socket, "Channel: SIP/$extension\r\n");
            fputs($socket, "Context: from-internal\r\n");
            fputs($socket, "Exten: $number\r\n");
            fputs($socket, "Priority: 1\r\n");
            fputs($socket, "Callerid: $extension\r\n\r\n");

            fputs($socket, "Action: Logoff\r\n\r\n");
            fclose($socket);

            echo "Llamada iniciada a $number desde la extensiÃ³n $extension";
        }
        break;

    case "dashagente":
        $fechastar = $_POST['daterange'];
        // DIVIDIR FECHAS
        $fechas = explode(" - ", $fechastar);
        $fechaInicio = DateTime::createFromFormat('d/m/Y', $fechas[0]);
        // FORMATOS
        $fechaInicio = $fechaInicio->format('Y-m-d');
        $fechaFin = DateTime::createFromFormat('d/m/Y', $fechas[1]);
        $fechaFin = $fechaFin->format('Y-m-d');

        $datos = $llamada->filtrar(
            $fechaInicio,
            $fechaFin,
            $_POST["fil_campana"],
            $_POST["fil_agente"]
        );
        echo json_encode($datos);
        break;

    case "listarllamadas":
        $fechastar = isset($_POST['daterange']) ? $_POST['daterange'] : null;
        if ($fechastar) {
            // DIVIDIR FECHAS
            $fechas = explode(" - ", $fechastar);
            $fechaInicio = DateTime::createFromFormat('d/m/Y', $fechas[0]);
            $fechaFin = DateTime::createFromFormat('d/m/Y', $fechas[1]);
            if ($fechaInicio && $fechaFin) {
                // FORMATOS
                $fechaInicio = $fechaInicio->format('Y-m-d');
                $fechaFin = $fechaFin->format('Y-m-d');
                $datos = $llamada->listar_llamadas(
                    $fechaInicio,
                    $fechaFin,
                    $_POST["campana"],
                    $_POST["agente"],
                    $_POST["estado"],
                );

                $data = array();

                foreach ($datos as $row) {
                    $asesor = $row["AGENTE"];
                    if ($asesor == "" || $asesor == null) {
                        $asesor = "";
                    } else {
                        $asesor = $row["detu_nom"]." ". $row["detu_ape"];
                    }

                    $sub_array = array();
                    $sub_array[] = $row["CEDULA"];
                    $sub_array[] = $row["NOMBRE"];
                    if (isset($row["CONVENIO"])) {
                        $sub_array[] = $row["CONVENIO"];
                    } else {
                        $sub_array[] = "";
                    }
                    $sub_array[] = $asesor;
                    $sub_array[] = $row["ESTADO"];
                    $fechaCreacion = isset($row["FECHA"]) ? DateTime::createFromFormat('Y-m-d', $row["FECHA"])->format('d/m/Y') : null;
                    $sub_array[] = $fechaCreacion;

                    $cifrado = openssl_encrypt($row["id"], $cipher, $key, OPENSSL_RAW_DATA, $iv);
                    $textocifrado = base64_encode($iv . $cifrado);

                    $cifradocamp = openssl_encrypt($_POST["campana"], $cipher, $key, OPENSSL_RAW_DATA, $iv);
                    $campcifrado = base64_encode($iv . $cifradocamp);

                    $sub_array[] = '<button name="ver" type="button" data-llamada="' . $textocifrado . ',' . $campcifrado . '" id="' . $textocifrado . '" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-eye"></i></button>';

                    $sub_array[] = $row["TELEFONO"];
                    if (isset($row["CIUDAD"])) {
                        $sub_array[] = $row["CIUDAD"];
                    }
                    $sub_array[] = $row["INTENTOS"];
                    $sub_array[] = $row["HORA"];
                    $sub_array[] = $row["id"];
                    $sub_array[] = $row["OBSERVACIONES"];
                    $data[] = $sub_array;
                }

                $results = array(
                    "sEcho" => 1,
                    "iTotalRecords" => count($data),
                    "aaData" => $data,
                );

                echo json_encode($results);
            } else {
                echo json_encode(array("error" => "Error en el formato de fecha"));
            }
        } else {
            echo json_encode(array("error" => "'daterange' no estÃ¡ definido"));
        }
        break;
    case "validar_llamada":
        $iv_dec = substr(base64_decode($_POST["idcam"]), 0, openssl_cipher_iv_length($cipher));
        $cifradosinIV = substr(base64_decode($_POST["idcam"]), openssl_cipher_iv_length($cipher));
        $camp = openssl_decrypt($cifradosinIV, $cipher, $key, OPENSSL_RAW_DATA, $iv_dec);

        $datos = $llamada->validar_llamada($_POST["idcli"],$camp,);

        echo json_encode($datos);
        break;
    ///*--------------------------------------
    case "SIP":
        $datos = $llamada->SIP($_POST["usu_id"]);
        echo json_encode($datos);
        break;

    case "Bcomentario":
        $dato = $_POST["id"];
        // Divide el contenido de $dato por comas
        $ids = explode(',', $dato);
        // Asigna cada valor a una variable separada
        $id = $ids[0];
        $iv_dec = substr(base64_decode($id), 0, openssl_cipher_iv_length($cipher));
        $cifradosinIV = substr(base64_decode($id), openssl_cipher_iv_length($cipher));
        $decifrado = openssl_decrypt($cifradosinIV, $cipher, $key, OPENSSL_RAW_DATA, $iv_dec);

        $camp = $ids[1];
        $iv_camp = substr(base64_decode($camp), 0, openssl_cipher_iv_length($cipher));
        $cifradoscamp = substr(base64_decode($camp), openssl_cipher_iv_length($cipher));
        $decifradocamp = openssl_decrypt($cifradoscamp, $cipher, $key, OPENSSL_RAW_DATA, $iv_camp);

        $datos = $llamada->Bcomentario($decifrado, $decifradocamp);
        echo json_encode($datos);
        break;

    case "clillamada":
        $iv_cli = substr(base64_decode($_POST["id_cli"]), 0, openssl_cipher_iv_length($cipher));
        $cifradoscli = substr(base64_decode($_POST["id_cli"]), openssl_cipher_iv_length($cipher));
        $decifradocli = openssl_decrypt($cifradoscli, $cipher, $key, OPENSSL_RAW_DATA, $iv_cli);

        $iv_cam = substr(base64_decode($_POST["cam"]), 0, openssl_cipher_iv_length($cipher));
        $cifradoscamp = substr(base64_decode($_POST["cam"]), openssl_cipher_iv_length($cipher));
        $decifradocamp = openssl_decrypt($cifradoscamp, $cipher, $key, OPENSSL_RAW_DATA, $iv_cam);

        $datos = $llamada->clillamada($decifradocli, $decifradocamp);
        echo json_encode($datos);
        break;

    case "listaragenda":
        $datos = $llamada->listaragenda($_SESSION["usu_id"]);
        $data = array();
            
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["cam_nom"];
            $sub_array[] = $row["NOMBRE"];
            $sub_array[] = $row["age_conv"];
                
            // Formatear la fecha
            $fecha = isset($row["age_fecha"]) ? DateTime::createFromFormat('Y-m-d', $row["age_fecha"])->format('d/m/Y') : null;
            $sub_array[] = $fecha ." - ". $row["age_hora"];

            // cifrar camp
            $iv_camp = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));
            $cifrado_camp = openssl_encrypt($row["cam_id"], $cipher, $key, OPENSSL_RAW_DATA, $iv_camp);
            $cifradocamp = base64_encode($iv_camp . $cifrado_camp);

            // cifrar cli
            $iv_cli = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));
            $cifrado_cli = openssl_encrypt($row["cli_id"], $cipher, $key, OPENSSL_RAW_DATA, $iv_cli);
            $cifradocli = base64_encode($iv_cli . $cifrado_cli);
                
            $sub_array[] = '<button name="ver" type="button" data-agenda="' . $cifradocli . ',' . $cifradocamp . '" id="' . $cifradocli . '" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-eye"></i></button>';
                
            // Agregar el sub_array a data
            $data[] = $sub_array;
        }
        
        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "aaData" => $data,
        );
        
        echo json_encode($results);
        break;
    case "ingresoConsola":
        $datos = $llamada->ingresoConsola($_SESSION["usu_id"]); 
        echo json_encode($datos);
        break;
    case "campid":
        
        $cifrado_camp = openssl_encrypt($row["cam_id"], $cipher, $key, OPENSSL_RAW_DATA, $iv);
        $cifradocamp = base64_encode($iv . $cifrado_camp);
        echo $cifradocamp;
        break;


        
        
        

}
