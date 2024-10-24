<?php
require_once "../config/conexion.php";
require_once "../models/campana.php";
require_once "../models/usuario.php";

$key = "@L1b3lul4*2024*1Nv3sT0r/By4pp5";
$cipher = "aes-256-cbc";
$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));

$campana = new Campana();
$usuario = new Usuario();

switch ($_GET["op"]) {

    case "guardaryeditar":
        $finicio = DateTime::createFromFormat('d/m/Y', $_POST["fec_ini"]);
        $finicio = $finicio ? $finicio->format('Y-m-d') : null;
        $ffin = DateTime::createFromFormat('d/m/Y', $_POST["fec_fin"]);
        $ffin = $ffin ? $ffin->format('Y-m-d') : null;
        
        if (empty($_POST["cam_id"])) {
            $campana->insert_campana($_POST["cam_nom"], $finicio, $ffin, $_POST["hora_ini"], $_POST["hora_fin"], $_POST["grupocc"], $_POST["cam_int"], $_POST["cam_coment"]);
            echo "1";
        } else {
            $campana->update_campana($_POST["cam_id"], $_POST["cam_nom"], $finicio, $ffin, $_POST["hora_ini"], $_POST["hora_fin"], $_POST["grupocc"], $_POST["cam_int"], $_POST["cam_coment"], $_POST["cam_est"]);
            echo "2";
        }
        break;

    case "listar":
        $datos = $campana->get_campana_all();
        $data = array();

        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["cam_nom"];
            $sub_array[] = date('d/m/Y', strtotime($row["cam_fecini"])) . ' - ' . date('d/m/Y', strtotime($row["cam_fecfin"]));
            $sub_array[] = date('H:i', strtotime($row["cam_hoini"])) . ' - ' . date('H:i', strtotime($row["cam_hofin"]));
            $sub_array[] = $row["gcc_nom"];

            if ($row["cam_est"] == "1") {
                $sub_array[] = '<span class="label label-pill label-success">Activa</span>';
            } else if ($row["cam_est"] == "2") {
                $sub_array[] = '<span class="label label-pill label-undefined">Inactiva</span>';
            } else if ($row["cam_est"] == "3") {
                $sub_array[] = '<span class="label label-pill label-info">Completada</span>';
            } else if ($row["cam_est"] == "4") {
                $sub_array[] = '<span class="label label-pill label-danger">Cierre completo</span>';
            } else if ($row["cam_est"] == "5") {
                $sub_array[] = '<span class="label label-pill label-warning">Terminada</span>';
            } 

            $cam_id = $row["cam_id"];
            $cifrado = openssl_encrypt($cam_id, $cipher, $key, OPENSSL_RAW_DATA, $iv);
            $textocifrado = base64_encode($iv . $cifrado);

            if ($row["record_count"] == 0) {
                $sub_array[] = '
                <button type="button" onClick="editar(\'' . $row["cam_id"] . '\',
                    \'' . $row["cam_nom"] . '\',
                    \'' . date('d/m/Y', strtotime($row["cam_fecini"])) . '\',
                    \'' . date('d/m/Y', strtotime($row["cam_fecfin"])) . '\',
                    \'' . date('H:i', strtotime($row["cam_hoini"])) . '\',
                    \'' . date('H:i', strtotime($row["cam_hofin"])) . '\',
                    \'' . $row["cam_est"] . '\',
                    \'' . $row["cam_com"] . '\',
                    \'' . $row["cam_int"] . '\',
                    \'' . $row["gcc_nom"] . '\',
                    \'' . $row["agent_empty_count"] . '\'
                    );"  id="' . $row["cam_id"] . '" class="btn btn-inline btn-warning btn-sm ladda-button"><i class="fa fa-edit"></i></button>

                <button name="dcamp" type="button" data-datocamp="' . $textocifrado . '|' . $row["cam_nom"] . '" id="c" class="btn btn-inline btn-info btn-sm ladda-button"><i class="fa fa-file-text"></i></button>

                <button type="button" onClick="eliminar(' . $row["cam_id"] . ');"  id="' . $row["cam_id"] . '" class="btn btn-inline btn-danger btn-sm ladda-button"><i class="fa fa-trash"></i></button>
                ';
            } else {
                $sub_array[] = '
                <button type="button" onClick="editar(\'' . $row["cam_id"] . '\',
                    \'' . $row["cam_nom"] . '\',
                    \'' . date('d/m/Y', strtotime($row["cam_fecini"])) . '\',
                    \'' . date('d/m/Y', strtotime($row["cam_fecfin"])) . '\',
                    \'' . date('H:i', strtotime($row["cam_hoini"])) . '\',
                    \'' . date('H:i', strtotime($row["cam_hofin"])) . '\',
                    \'' . $row["cam_est"] . '\',
                    \'' . $row["cam_com"] . '\',
                    \'' . $row["cam_int"] . '\',
                    \'' . $row["gcc_nom"] . '\',
                    \'' . $row["agent_empty_count"] . '\'
                    );"  id="' . $row["cam_id"] . '" class="btn btn-inline btn-warning btn-sm ladda-button"><i class="fa fa-edit"></i></button>

                <button type="button" onClick="eliminar(' . $row["cam_id"] . ');"  id="' . $row["cam_id"] . '" class="btn btn-inline btn-danger btn-sm ladda-button"><i class="fa fa-trash"></i></button>
                ';
            }

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

    case "listarInactivos":
        $datos = $campana->get_campana_all_Inactivas();
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["cam_nom"];
            $sub_array[] = date('d/m/Y', strtotime($row["cam_fecini"])) . ' - ' . date('d/m/Y', strtotime($row["cam_fecfin"]));
            $sub_array[] = date('H:i', strtotime($row["cam_hoini"])) . ' - ' . date('H:i', strtotime($row["cam_hofin"]));
            $sub_array[] = $row["cam_nom"];
            if($row["cam_est"] == 4){
                $sub_array[] = '<span class="label label-pill label-danger">Cierre completo</span>';
            }else if($row["cam_est"] == 5){
                $sub_array[] = '<span class="label label-pill label-warning">Terminado</span>';
            }else{
                $sub_array[] = '<span class="label label-pill label-warning"></span>';
            }
            $sub_array[] = '
                <button type="button" onClick="editar(\'' . $row["cam_id"] . '\',
                 \'' . $row["cam_nom"] . '\',
                 \'' . date('d/m/Y', strtotime($row["cam_fecini"])) . '\',
                 \'' . date('d/m/Y', strtotime($row["cam_fecfin"])) . '\',
                 \'' . date('H:i', strtotime($row["cam_hoini"])) . '\',
                 \'' . date('H:i', strtotime($row["cam_hofin"])) . '\',
                 \'' . $row["cam_est"] . '\',
                 \'' . $row["cam_com"] . '\',
                 \'' . $row["cam_int"] . '\',
                 \'' . $row["gcc_nom"] . '\'
                 );"  id="' . $row["cam_id"] . '" class="btn btn-inline btn-warning btn-sm ladda-button"><i class="fa fa-edit"></i></button>

                 <button type="button" onClick="eliminar(' . $row["cam_id"] . ');"  id="' . $row["cam_id"] . '" class="btn btn-inline btn-danger btn-sm ladda-button"><i class="fa fa-trash"></i></button>
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

    case "eliminardef":
        $campana->delete_campanadef($_POST["cam_id"]);
        break;

        case "columnas":
            // Obtener la variable camp
            $iv_camp = substr(base64_decode($_POST['camp']), 0, openssl_cipher_iv_length($cipher));
            $cifradosinIV = substr(base64_decode($_POST['camp']), openssl_cipher_iv_length($cipher));
            $campanaId = openssl_decrypt($cifradosinIV, $cipher, $key, OPENSSL_RAW_DATA, $iv_camp);
    
            // Obtener los datos de las columnas y valores
            $columns = $_POST['columns'];
            $values = $_POST['values'];
    
            if (empty($columns) || empty($values)) {
                echo json_encode(["error" => "No se recibieron datos de columnas o valores."]);
                exit;
            }
    
            // Verificar si columns y values son cadenas JSON vÃ¡lidas
            $columnsDecoded = json_decode($columns, true);
            $valuesDecoded = json_decode($values, true);
    
            if (json_last_error() !== JSON_ERROR_NONE) {
                echo json_encode(["error" => "Error al decodificar JSON: " . json_last_error_msg()]);
                exit;
            }
    
            // Llamar al mÃ©todo agregarcolumnas
            $datos = $campana->agregarcolumnas($campanaId, $columnsDecoded, $valuesDecoded);
    
            echo json_encode($datos);
            break;
    

    case "cambiarestado":
        $campana->cambiarestado($_POST["cam_id"]);
        break;

        case "editarestado":
            $iv_dec = substr(base64_decode($_POST["cam_id"]), 0, openssl_cipher_iv_length($cipher));
            $cifradosinIV = substr(base64_decode($_POST["cam_id"]), openssl_cipher_iv_length($cipher));
            $decifrado = openssl_decrypt($cifradosinIV, $cipher, $key, OPENSSL_RAW_DATA, $iv_dec);
            $datos = $campana->buscarcampana($decifrado);
    
            $campana->cambiarestado($decifrado);
            echo $decifrado;
            break;
    

    case "campanasAdmin":
        $datos = $campana->campanasAdmin();

        foreach ($datos as &$dato) {
            $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));

            $cam_id = $dato['cam_id'];
            $cifrado = openssl_encrypt($cam_id, $cipher, $key, OPENSSL_RAW_DATA, $iv);
            $textocifrado = base64_encode($iv . $cifrado);

            $dato['cam_id'] = $textocifrado;
        }
        echo json_encode($datos);
        break;

    case "campanasActivas":
            $usu_id = $_POST["usu_id"];
            $datos = $campana->campanasxusuarioActivas($usu_id);
        
            $iv_length = openssl_cipher_iv_length($cipher);        
            $datos_procesados = [];
            
            foreach ($datos as $dato) {
                // Obtén la cadena de datos
                $cadena = $dato['rcampanas']; // Asumiendo que rcampanas es el nombre del campo
        
                // Divide la cadena por cada `;` para manejar múltiples conjuntos de datos
                $conjuntos = explode(';', $cadena);
        
                foreach ($conjuntos as $conjunto) {
                    // Elimina espacios en blanco y puntos y comas innecesarios
                    $conjunto = trim($conjunto);
                    if ($conjunto === '') {
                        continue; // Saltar si la cadena está vacía
                    }
        
                    // Convierte la cadena en un array asociativo
                    parse_str(str_replace(', ', '&', $conjunto), $array_datos);
        
                    // Verifica y cifra el cam_id
                    if (isset($array_datos['cam_id']) && $array_datos['cam_id'] !== null) {
                        $cam_id = $array_datos['cam_id'];
        
                        // Genera un IV aleatorio
                        $iv = openssl_random_pseudo_bytes($iv_length);
        
                        // Cifra el cam_id
                        $cifrado = openssl_encrypt($cam_id, $cipher, $key, OPENSSL_RAW_DATA, $iv);
        
                        // Codifica el resultado para almacenar en JSON
                        $array_datos['cam_id'] = base64_encode($iv . $cifrado);
                    }
        
                    // Agrega el array procesado al array de resultados
                    $datos_procesados[] = $array_datos;
                }
            }
        
            // Envía la respuesta como JSON
            echo json_encode($datos_procesados);
            break;
        
        

    case "bcampana":
        $iv_dec = substr(base64_decode($_POST["camp_id"]), 0, openssl_cipher_iv_length($cipher));
        $cifradosinIV = substr(base64_decode($_POST["camp_id"]), openssl_cipher_iv_length($cipher));
        $decifrado = openssl_decrypt($cifradosinIV, $cipher, $key, OPENSSL_RAW_DATA, $iv_dec);

        $datos = $campana->buscarcampana($decifrado);

        $output = array();
        foreach ($datos as $row) {
            $fechaInicio = new DateTime($row["cam_fecini"]);
            $fechaFinal = new DateTime($row["cam_fecfin"]);
            $output[] = array(
                "fInicio" => $fechaInicio->format('d/m/Y'),
                "fFinal" => $fechaFinal->format('d/m/Y'),
                "hora_ini" => $row["cam_hoini"],
                "hora_fin" => $row["cam_hofin"],
                "cam_coment" => $row["cam_com"],
                "cam_int" => $row["cam_int"],
                "nombreTabla" => $row["cam_tabla"],
                "nombrecamp" => $row["cam_nom"],

            );
        }
        echo json_encode($output);
        break;

        case 'todasCampanas':
            $html = '';
            $datos = $campana->todasCampanas();
            
            if (is_array($datos) == true && count($datos) > 0) {
                foreach ($datos as $row) {
                    $estado = "";
        
                    if($row['cam_est'] == 1){
                        $estado = "Activa";
                    } else if($row['cam_est'] == 2){
                        $estado = "Inactiva";
                    } else if($row['cam_est'] == 3){
                        $estado = "Completada";
                    } else if($row['cam_est'] == 4){
                        $estado = "Cierre completo";
                    } else if($row['cam_est'] == 5){
                        $estado = "Terminada";
                    }
        
                    $html .= "<option value='" . $row['cam_id'] . "'>" . $row['cam_nom'] . " - " . $estado . "</option>";
                }
            } else {
                // Si no hay datos, agregar una opción con valor 0 y texto "No hay campañas"
                $html .= "<option value='0'>No hay campañas</option>";
            }
            
            echo $html;
            break;

    case 'todasCampanasActivas':
        $html = '';
        $datos = $campana->todasCampanasActivas();
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $estado = "";

                if($row['cam_est'] == 1){
                    $estado = "Activa";
                }else if($row['cam_est'] == 2){
                    $estado = "Inactiva";
                }else if($row['cam_est'] == 3){
                    $estado = "Completada";
                }else if($row['cam_est'] == 4){
                    $estado = "Cierre completo";
                }else if($row['cam_est'] == 5){
                    $estado = "Terminada";
                }

                $html .= "<option value='" . $row['cam_id'] . "'>" . $row['cam_nom'] . " - " . $estado . "</option>";
            }
            echo $html;
        }
        break;    

    case "campanas":
        $usu_id = $_POST["usu_id"];
        $datos = $campana->campanasxusuario($usu_id);
        echo json_encode($datos);
        break;
    case "contcampact":
        $datos = $campana->contcampact($_SESSION["usu_id"]);
        echo json_encode($datos);
        break;
    case "agenda":
        $datos = $campana->agenda($_SESSION["usu_id"]);
        echo json_encode($datos);
        break;

}
