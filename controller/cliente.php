<?php
require_once "../config/conexion.php";
require_once "../models/cliente.php";
require_once "../models/entidad.php";
require_once "../models/usuario.php";
require_once __DIR__ . '/../vendor/autoload.php';

use Mpdf\Mpdf;

$key = "@L1b3lul4*2024*1Nv3sT0r/By4pp5";
$cipher = "aes-256-cbc";
$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));

$cliente = new Cliente();
$entidad = new Entidad();
$usuario = new Usuario();

switch ($_GET["op"]) {

    case "listar":
        $fechastar = $_POST['daterange'];
        $fechas = explode(" - ", $fechastar);
        $fechaInicio = DateTime::createFromFormat('d/m/Y', $fechas[0]);
        $fechaFin = DateTime::createFromFormat('d/m/Y', $fechas[1]);
        // FORMATOS
        $fechaInicio = $fechaInicio->format('Y-m-d');
        $fechaFin = $fechaFin->format('Y-m-d');

        $datos = $cliente->listar_clientes(
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
            $fechaFormateada = null;
            $fechaFormateada = DateTime::createFromFormat('Y-m-d H:i:s', $row["cli_feest"]);
            $fechaFormateada = $fechaFormateada->format('d/m/Y ');

            $sub_array = array();
            $sub_array[] = $row["cli_doc"];
            $sub_array[] = $row["cli_nom"];
            $sub_array[] = $row["cli_con"];
            $sub_array[] = $row["ent_nom"];
            $sub_array[] = $row["detu_nom"]." ".$row['detu_ape'];
            $sub_array[] = $row["cli_ciu"];
            $sub_array[] = $fechaFormateada;

            $cifrado = openssl_encrypt($row["cli_id"], $cipher, $key, OPENSSL_RAW_DATA, $iv);
            $textocifrado = base64_encode($iv . $cifrado);

            $sub_array[] = '<button name="ver" type="button" data-client="' . $textocifrado . '" id="' . $textocifrado . '" class="btn btn-inline btn-primary btn-sm ladda-button"><div><i class="fa fa-eye"></i></button>';

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

    case "filtrar":
        // DIVIDIR FECHAS
        $fechastar = $_POST['daterange'];
        $fechas = explode(" - ", $fechastar);
        $fechaInicio = DateTime::createFromFormat('d/m/Y', $fechas[0]);
        $fechaInicio = $fechaInicio->format('Y-m-d');
        $fechaFin = DateTime::createFromFormat('d/m/Y', $fechas[1]);
        $fechaFin = $fechaFin->format('Y-m-d');

        $datos = $cliente->filtrar(
            $fechaInicio,
            $fechaFin,
            $_POST["usu_perfil"],
            $_POST["fil_entidad"],
            $_POST["fil_grupo"],
            $_POST["fil_asesor"],
            $_POST["filtro"],
        );
        $output = array(
            "interesado" => 0,
            "cita" => 0,
            "analisis" => 0,
            "consulta" => 0,
            "viable" => 0,
            "oferta" => 0,
            "retoma" => 0,
            "noviable" => 0,
            "nointeresado" => 0,
            "operacion" => 0,
            "cerrados" => 0,
        );
        // Verificar y asignar valores si existen
        if (isset($datos[0])) {
            $output["interesado"] = isset($datos[0]['interesado']) ? $datos[0]['interesado'] : 0;
            $output["cita"] = isset($datos[0]['cita']) ? $datos[0]['cita'] : 0;
            $output["analisis"] = isset($datos[0]['analisis']) ? $datos[0]['analisis'] : 0;
            $output["consulta"] = isset($datos[0]['consulta']) ? $datos[0]['consulta'] : 0;
            $output["viable"] = isset($datos[0]['viable']) ? $datos[0]['viable'] : 0;
            $output["oferta"] = isset($datos[0]['oferta']) ? $datos[0]['oferta'] : 0;
            $output["retoma"] = isset($datos[0]['retoma']) ? $datos[0]['retoma'] : 0;
            $output["noviable"] = isset($datos[0]['noviable']) ? $datos[0]['noviable'] : 0;
            $output["nointeresado"] = isset($datos[0]['nointeresado']) ? $datos[0]['nointeresado'] : 0;
            $output["operacion"] = isset($datos[0]['operacion']) ? $datos[0]['operacion'] : 0;
            $output["cerrados"] = isset($datos[0]['cerrados']) ? $datos[0]['cerrados'] : 0;
        }
        echo json_encode($output);
        break;

    case "Buscarclienteid":

        $iv_dec = substr(base64_decode($_POST["id"]), 0, openssl_cipher_iv_length($cipher));
        $cifradosinIV = substr(base64_decode($_POST["id"]), openssl_cipher_iv_length($cipher));
        $decifrado = openssl_decrypt($cifradosinIV, $cipher, $key, OPENSSL_RAW_DATA, $iv_dec);
        $decifrado = str_replace(['"', "'"], '', $decifrado);
        $decifrado = (int)$decifrado;

        $datos = $cliente->B_ClientexID($decifrado);

        if (is_array($datos) && count($datos) > 0) {
            $data = array();
            foreach ($datos as $row) {
                $sub_array = array();

                $sub_array[] = $row["cli_tip"];
                $sub_array[] = $row["cli_doc"];
                $sub_array[] = $row["cli_nom"];

                $fechanacimiento = isset($row["cli_fenac"]) ? DateTime::createFromFormat('Y-m-d', $row["cli_fenac"])->format('d/m/Y') : null;

                $sub_array[] = $fechanacimiento;
                $sub_array[] = $row["cli_fenac"];
                $sub_array[] = $row["cli_tel"];
                $sub_array[] = $row["cli_tel2"];
                $sub_array[] = $row["cli_mail"];
                $sub_array[] = $row["cli_ciu"];
                $sub_array[] = $row["cli_dep"];
                $sub_array[] = $row["ent_id"];
                $sub_array[] = $row["ent_nom"];
                $sub_array[] = $row["cli_est"];
                $sub_array[] = $row["cli_con"];
                $sub_array[] = $row["cli_estlab"];
                $sub_array[] = $row["cli_tipcon"];
                $sub_array[] = $row["cli_car"];
                $sub_array[] = $row["cli_tipen"];
                $sub_array[] = $row["cli_tiser"];
                $sub_array[] = $row["utl_id"];
                $sub_array[] = $row["utl_nom"];
                $sub_array[] = $row["cli_idage"];
                $sub_array[] = $row["cli_idase"];
                $sub_array[] = $row["asesor"];
                $sub_array[] = $row["agente"];
                $sub_array[] = $row["cli_dir"];

                $fechaCreacion = isset($row["cli_fecrea"]) ? DateTime::createFromFormat('Y-m-d H:i:s', $row["cli_fecrea"])->format('d/m/Y') : null;
                $sub_array[] = $fechaCreacion;

                $fechaEstado = isset($row["cli_feest"]) ? DateTime::createFromFormat('Y-m-d H:i:s', $row["cli_feest"])->format('d/m/Y') : null;
                $sub_array[] = $fechaEstado;
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

    case "buscarxDato":
        $datos = $cliente->B_ClientexDato($_POST["busqueda"], $_POST["filtro"], $_POST["grupo"], $_POST["usuPerfil"], $_POST["usu_id"]);

        $data = array();
        foreach ($datos as $row) {
            $fechaFormateada = isset($row["cli_feest"]) ? DateTime::createFromFormat('Y-m-d H:i:s', $row["cli_feest"])->format('d-m-Y') : null;

            $sub_array = array();
            $sub_array[] = $row["cli_doc"];
            $sub_array[] = $row["cli_nom"];
            $sub_array[] = $row["cli_con"];
            $sub_array[] = $row["ent_nom"];
            $sub_array[] = $row["usu_nom"]. " " .$row["usu_ape"];            
            $sub_array[] = $row["cli_est"];
            $sub_array[] = $fechaFormateada;

            $cifrado = openssl_encrypt($row["cli_id"], $cipher, $key, OPENSSL_RAW_DATA, $iv);
            $textocifrado = base64_encode($iv . $cifrado);

            $sub_array[] = '<button name="ver" type="button" data-cliente="' . $textocifrado . '" id="' . $textocifrado . '" class="btn btn-inline btn-primary btn-sm ladda-button"><div><i class="fa fa-eye"></i></button>';
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

    case "edestado":
        $iv_dec = substr(base64_decode($_POST["id_cli"]), 0, openssl_cipher_iv_length($cipher));
        $cifradosinIV = substr(base64_decode($_POST["id_cli"]), openssl_cipher_iv_length($cipher));
        $decifrado = openssl_decrypt($cifradosinIV, $cipher, $key, OPENSSL_RAW_DATA, $iv_dec);
        $decifrado = str_replace(['"', "'"], '', $decifrado);
        $decifrado = (int)$decifrado;

        $cliente->editar_estado(
            $decifrado,
            $_POST["selectedValue"]
        );
        break;
        case "PDFhojadevidacli":
            $iv_dec = substr(base64_decode($_POST["id"]), 0, openssl_cipher_iv_length($cipher));
            $cifradosinIV = substr(base64_decode($_POST["id"]), openssl_cipher_iv_length($cipher));
            $decifrado = openssl_decrypt($cifradosinIV, $cipher, $key, OPENSSL_RAW_DATA, $iv_dec);
            $decifrado = str_replace(['"', "'"], '', $decifrado);
            $decifrado = (int)$decifrado;
            
            $clienteData->buscarclienteTodo($decifrado);
            echo json_encode($clienteData);

            // Verificar si hay datos del cliente
            if (empty($clienteData)) {
                // Enviar respuesta JSON en caso de que no haya datos
                header('Content-Type: application/json');
                echo json_encode(['error' => 'Error al buscar los datos para el cliente especificado.']);
                exit;
            }
        
            try {
                // Crear una instancia de Mpdf
                $mpdf = new \Mpdf\Mpdf();
            
                $html = '
                    <h1>Datos del Cliente</h1>
                    <p><strong>Nombre:</strong> ' . htmlspecialchars($clienteData['cli_nom'], ENT_QUOTES, 'UTF-8') . '</p>
                    <p><strong>Documento:</strong> ' . htmlspecialchars($clienteData['cli_doc'], ENT_QUOTES, 'UTF-8') . '</p>
                    <p><strong>Ciudad:</strong> ' . htmlspecialchars($clienteData['cli_ciu'], ENT_QUOTES, 'UTF-8') . '</p>
                    ';
            
                // Escribir el contenido HTML en el PDF
                $mpdf->WriteHTML($html);

                // Limpiar el búfer de salida si existe
                if (ob_get_contents()) {
                    ob_end_clean();
                }
                    
                // Enviar el PDF al navegador
                header('Content-Type: application/pdf');
                header('Content-Disposition: attachment; filename="hoja_de_vida_cliente.pdf"');
                header('Cache-Control: max-age=0');
            
                // Salida del contenido del PDF
                $mpdf->Output('hoja_de_vida_cliente.pdf', 'D');

            } catch (\Mpdf\MpdfException $e) {
                // Manejar errores de mPDF
                header('Content-Type: application/json');
                echo json_encode(['error' => 'Error al generar el PDF: ' . $e->getMessage()]);
            }
            break;
        
        

    case "combo":
        $datos = $cliente->get_cliente();
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $html .= "<option value='" . $row['utl_id'] . "'>" . $row['utl_nom'] . "</option>";
            }
            echo $html;
        }
        break;

    case "insertcoments":
        $iv_dec = substr(base64_decode($_POST["id_cli"]), 0, openssl_cipher_iv_length($cipher));
        $cifradosinIV = substr(base64_decode($_POST["id_cli"]), openssl_cipher_iv_length($cipher));
        $decifrado = openssl_decrypt($cifradosinIV, $cipher, $key, OPENSSL_RAW_DATA, $iv_dec);
        $decifrado = str_replace(['"', "'"], '', $decifrado);
        $decifrado = (int)$decifrado;

        if ($_POST["id_com"] == "") {
            $cliente->insert_comentarios(
                $decifrado,
                $_POST["com_coment"],
                $_POST["usu_id"],
                $_POST["privacidad"]
            );
            echo 1;
        } else {
            $cliente->editar_comentarios(
                $decifrado,
                $_POST["com_coment"],
                $_POST["usu_id"],
                $_POST["privacidad"],
                $_POST["id_com"]
            );
            echo 2;
        }
        break;

    case "editar":
        $iv_dec = substr(base64_decode($_POST["id"]), 0, openssl_cipher_iv_length($cipher));
        $cifradosinIV = substr(base64_decode($_POST["id"]), openssl_cipher_iv_length($cipher));
        $decifrado = openssl_decrypt($cifradosinIV, $cipher, $key, OPENSSL_RAW_DATA, $iv_dec);

        // Capturar y procesar los datos del formulario
        $fechanacimiento = $_POST["fec_nac"];
        $tipo_contrato = isset($_POST["tipo_contrato"]) ? $_POST["tipo_contrato"] : "";
        $tipo_pension = isset($_POST["tipo_pension"]) ? $_POST["tipo_pension"] : "";
        $cli_cargo = isset($_POST["cli_cargo"]) ? $_POST["cli_cargo"] : "";
        $tiem_servicio = isset($_POST["tiem_servicio"]) ? $_POST["tiem_servicio"] : "";

        // Crear objeto DateTime desde la fecha de nacimiento
        $fenacimiento = DateTime::createFromFormat('d/m/Y', $fechanacimiento);

        if ($fenacimiento !== false) {
            // FORMATEAR FECHA
            $fecha = $fenacimiento->format('Y-m-d');

            // Llamar a la función editar_cliente con los parámetros actualizados
            $resultado = $cliente->editar_cliente(
                $decifrado,
                $_POST["tipo_doc"],
                $_POST["cli_cc"],
                $_POST["cli_nombre"],
                $fecha,
                $_POST["cli_telefono"],
                $_POST["tel_alternativo"],
                $_POST["cli_mail"],
                $_POST["cli_entidad"],
                $_POST["cli_dir"],
                $_POST["cli_ciudad"],
                $_POST["cli_dep"],
                $_POST["cli_convenio"],
                $_POST["est_laboral"],
                $tipo_contrato,
                $cli_cargo,
                $tiem_servicio,
                $tipo_pension,
                $_POST["contacto"],
                $_POST["idage"],
                $_POST["asesor"]
            );

            // Verificar el resultado de la edición
            if ($resultado) {
                echo json_encode(["status" => "success", "message" => "Cliente editado correctamente"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Hubo un problema al editar el cliente"]);
            }
        } else {
            // Manejar el caso en que la fecha de nacimiento no sea válida
            echo json_encode(["status" => "error", "message" => "La fecha de nacimiento proporcionada no es válida"]);
        }
        break;

    case "listarcomentarios":
        $iv_dec = substr(base64_decode($_POST["cli_id"]), 0, openssl_cipher_iv_length($cipher));
        $cifradosinIV = substr(base64_decode($_POST["cli_id"]), openssl_cipher_iv_length($cipher));
        $decifrado = openssl_decrypt($cifradosinIV, $cipher, $key, OPENSSL_RAW_DATA, $iv_dec);
        $decifrado = str_replace(['"', "'"], '', $decifrado);
        $decifrado = (int)$decifrado;

        $datos = $cliente->listar_comentarios_x_cliente($decifrado, $_POST["usuPerfil"]);

        // Limitar la cantidad de comentarios a mostrar
        $limit = isset($_POST['limit']) ? intval($_POST['limit']) : 10;
        $offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;

        // Filtrar los comentarios según el límite y el desplazamiento
        $datos_limitados = array_slice($datos, $offset, $limit);

        ?>
            <style>
                .line-color-1 {
                    border-left: 5px solid green;
                    /* Cambia esto al color que desees */
                    padding-left: 10px;
                }

                .line-color-2 {
                    border-left: 5px solid red;
                    /* Cambia esto al color que desees */
                    padding-left: 10px;
                }

                .cont-in {
                    position: relative;
                    padding-right: 60px;
                    /* Añade espacio para el checkbox-toggle */
                }

                .comen {
                    position: absolute;
                    top: 0;
                    right: 0;
                }

                .show-more-container {
                    text-align: center; /* Centra el botón */
                    margin-top: 20px;   /* Espacio superior para separar del último comentario */
                }

                #btnMostrarMas {
                    background-color: #00a8ff;; /* Azul */
                    border: none;
                    color: white;
                    padding: 10px 20px;
                    text-align: center;
                    text-decoration: none;
                    display: inline-block;
                    font-size: 16px;
                    margin: 4px 2px;
                    cursor: pointer;
                    border-radius: 12px;
                    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                    transition: background-color 0.3s ease;
                }

                #btnMostrarMas:hover {
                    background-color: #00a8ff; /* Azul más oscuro al pasar el mouse */
                }

            </style>
        <?php

        // Renderizar los comentarios limitados
        $usu_nom_anterior = null;
        $com_fecrea_anterior = null;

        foreach ($datos_limitados as $row) {
            // Escapa el comentario para usarlo en el atributo onclick
            $com_com_escaped = htmlspecialchars($row['com_com'], ENT_QUOTES, 'UTF-8');

            // Verifica si usu_nom y com_fecrea son iguales al registro anterior
            $mostrar_activity_line_action = (
                $row['detu_nom']." ".$row['detu_ape'] == $usu_nom_anterior &&
                date("d/m/Y", strtotime($row['com_fecrea'])) == $com_fecrea_anterior
            );

            if (!$mostrar_activity_line_action && $usu_nom_anterior !== null) {
                ?>
                    </div>
                    </article>
                <?php
            }

            // Determina la clase basada en el valor de com_per
            $line_class = $row['com_per'] == 1 ? 'line-color-1' : 'line-color-2';

            if (!$mostrar_activity_line_action) {
                ?>
                    <article class="activity-line-item box-typical">
                        <div class="activity-line-date">
                            <?php echo date("d/m/Y", strtotime($row["com_fecrea"])); ?>
                        </div>
                        <header class="activity-line-item-header">
                            <div class="activity-line-item-user">
                                <div class="activity-line-item-user-photo">
                                    <a href="#">
                                        <img src="../../public/img/<?php echo $row['usu_per'] ?>.jpg" alt="">
                                    </a>
                                </div>
                                <div class="activity-line-item-user-name"><?php echo $row["detu_nom"]." ".$row['detu_ape']; ?></div>
                                <div class="activity-line-item-user-status"><?php echo $row['usu_per']; ?></div>
                            </div>
                        </header>
                        <div class="activity-line-action-list">
                <?php
                }
                ?>
                            <section class="activity-line-action <?php echo $line_class; ?>">
                                <div class="time"><?php echo date("H:i:s", strtotime($row["com_fecrea"])); ?></div>
                                <div class="cont">
                                    <div class="cont-in">
                                        <p><?php echo $row["com_com"]; ?></p>
                                        <?php if ($_POST["usuPerfil"] != 'Asesor' && $_POST["usuPerfil"] != 'Coordinador') {?>
                                            <!-- Botón para enviar datos del comentario y prioridad -->
                                            <div class="comen">
                                                <button type="button" onclick="enviarDatosComentario(
                                                    <?php echo $row['com_id']; ?>,
                                                    <?php echo $row['com_per']; ?>,
                                                    '<?php echo $com_com_escaped; ?>'
                                                    )" id="<?php echo $row['com_id']; ?>" class="btn btn-inline btn-warning btn-sm ladda-button">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                            </div>
                                        <?php }?>
                                    </div>
                                </div>
                            </section>
                <?php
                // Actualiza las variables de comparaciÃ³n para la prÃ³xima iteraciÃ³n
                $usu_nom_anterior = $row["detu_nom"]." ".$row['detu_ape'];
                $com_fecrea_anterior = date("d/m/Y", strtotime($row['com_fecrea']));

                if (!$mostrar_activity_line_action) {
                    ?>
                            </div>
                        <article class="activity-line-item box-typical">
                    <?php
                }
            }
            // Mostrar el botón "Mostrar más" si hay más comentarios disponibles
            if (count($datos) > $offset + $limit) {
                echo '<div class="show-more-container"><button id="btnMostrarMas" onclick="cargarMasComentarios()">Mostrar más</button></div>';
            }
        break;

    case "editarprivacidadcomentario":
        $cliente->editar_pricomentarios(
            $_POST["com_id"],
            $_POST["estado"]
        );
        break;

    //INSERTAR CLIENTE
    case "insert":
        // try {
            $fechaFormateada = "0000-00-00";
            if (!empty($_POST["cli_edad"])) {
                $fechaInicio = DateTime::createFromFormat('d/m/Y', $_POST["cli_edad"]);
                if ($fechaInicio) {
                    $fechaFormateada = $fechaInicio->format('Y-m-d');
                } else {
                    $fechaFormateada = "0000-00-00";
                }
            }

            $tipo_contrato = isset($_POST["tipo_contrato"]) ? $_POST["tipo_contrato"] : "";
            $cli_cargo = isset($_POST["cli_cargo"]) ? $_POST["cli_cargo"] : "";
            $tiem_servicio = isset($_POST["tiem_servicio"]) ? $_POST["tiem_servicio"] : "";
            $tipo_pension = isset($_POST["tipo_pension"]) ? $_POST["tipo_pension"] : "";
            $cli_agente = isset($_POST["cli_agente"]) ? $_POST["cli_agente"] : "";
            $comentario = isset($_POST["comentario"]) ? $_POST["comentario"] : "";

            $res = $cliente->insert_cliente(
                $_POST["tipo_cc"],
                $_POST["cli_cc"],
                $_POST["cli_nombre"],
                $fechaFormateada,
                $_POST["cli_telefono"],
                $_POST["tel_alternativo"],
                $_POST["cli_mail"],
                $_POST["cli_ciudad"],
                $_POST["cli_depa"],
                $_POST["cli_entidad"],
                $_POST["cli_estado"],
                $_POST["cli_convenio"],
                $_POST["est_laboral"],
                $tipo_contrato,
                $cli_cargo,
                $tipo_pension,
                $tiem_servicio,
                $_POST["toma_contac"],
                $cli_agente,
                $_POST["cli_asesor"],
                $comentario,
                "",
                $_POST["tabla"],
                $_POST["idcli"],
                $_POST["idcam"],
                $_POST["observaciones"],
                $_POST["estado"]
            );

            //$cifrado = openssl_encrypt($res, $cipher, $key, OPENSSL_RAW_DATA, $iv);
            // $textocifrado = base64_encode($iv . $cifrado);

            // echo $textocifrado;   
            echo json_encode($res);        

        // } catch (Exception $e) {
        //     echo json_encode(array('status' => 'error', 'message' => 'Error al crear el cliente'));
        // }        
        break;

    case "insertclienteform":
            try {
                $fechaFormateada = "0000-00-00";
                if (!empty($_POST["cli_edad"])) {
                    $fechaInicio = DateTime::createFromFormat('d/m/Y', $_POST["cli_edad"]);
                    if ($fechaInicio) {
                        $fechaFormateada = $fechaInicio->format('Y-m-d');
                    } else {
                        $fechaFormateada = "0000-00-00";
                    }
                }
    
                $tipo_contrato = isset($_POST["tipo_contrato"]) ? $_POST["tipo_contrato"] : "";
                $cli_cargo = isset($_POST["cli_cargo"]) ? $_POST["cli_cargo"] : "";
                $tiem_servicio = isset($_POST["tiem_servicio"]) ? $_POST["tiem_servicio"] : "";
                $tipo_pension = isset($_POST["tipo_pension"]) ? $_POST["tipo_pension"] : "";
                $cli_agente = isset($_POST["cli_agente"]) ? $_POST["cli_agente"] : "";
                $comentario = isset($_POST["comentario"]) ? $_POST["comentario"] : "";
    
                $res = $cliente->insertclienteform(
                    $_POST["tipo_cc"],
                    $_POST["cli_cc"],
                    $_POST["cli_nombre"],
                    $fechaFormateada,
                    $_POST["cli_telefono"],
                    $_POST["tel_alternativo"],
                    $_POST["cli_mail"],
                    $_POST["cli_ciudad"],
                    $_POST["cli_depa"],
                    $_POST["cli_entidad"],
                    $_POST["cli_estado"],
                    $_POST["cli_convenio"],
                    $_POST["est_laboral"],
                    $tipo_contrato,
                    $cli_cargo,
                    $tipo_pension,
                    $tiem_servicio,
                    $_POST["toma_contac"],
                    $cli_agente,
                    $_POST["cli_asesor"]                    
                );
    
                $cifrado = openssl_encrypt($res, $cipher, $key, OPENSSL_RAW_DATA, $iv);
                $textocifrado = base64_encode($iv . $cifrado);
    
                echo $textocifrado;   
    
            } catch (Exception $e) {
                echo json_encode(array('status' => 'error', 'message' => 'Error al crear el cliente'));
            }        
            break;

    case "noRepetircc":
        $datos = $cliente->NoRepetirCC($_POST["c"]);
        echo json_encode($datos);
        break;

    case "noRepetirTel":
        $datos = $cliente->NoRepetirTel($_POST["t"]);
        echo json_encode($datos);
        break;

    case "consulta":
        $iv_dec = substr(base64_decode($_POST["id_cli"]), 0, openssl_cipher_iv_length($cipher));
        $cifradosinIV = substr(base64_decode($_POST["id_cli"]), openssl_cipher_iv_length($cipher));
        $decifrado = openssl_decrypt($cifradosinIV, $cipher, $key, OPENSSL_RAW_DATA, $iv_dec);
        $decifrado = str_replace(['"', "'"], '', $decifrado);
        $decifrado = (int)$decifrado;

        $dato = $cliente->consulta(
            $decifrado
        );
        echo json_encode($dato);
        break;

    //---------------------------------------

    case "editarconsulta":
        $iv_dec = substr(base64_decode($_POST["id_cli"]), 0, openssl_cipher_iv_length($cipher));
        $cifradosinIV = substr(base64_decode($_POST["id_cli"]), openssl_cipher_iv_length($cipher));
        $decifrado = openssl_decrypt($cifradosinIV, $cipher, $key, OPENSSL_RAW_DATA, $iv_dec);
        $decifrado = str_replace(['"', "'"], '', $decifrado);
        $decifrado = (int)$decifrado;

        if (isset($_POST["fecon"]) && !empty($_POST["fecon"])) {
            $feform = new DateTime(date('Y-m-d', strtotime($_POST["fecon"])));

            if ($feform === false) {
                echo json_encode(['status' => 'error', 'message' => 'Formato de fecha incorrecto']);
                break;
            }
            $formattedDate = $feform->format('Y-m-d');
        } else {
            echo "La fecha no está presente en el POST o está vacía.";
        }

        // Editar la consulta
        $datos = $cliente->editar_consulta($formattedDate, $_POST["resp"], $_POST["desc"], $decifrado, $_POST["pri"], $_POST["con_id"]);

        if ($datos['status'] !== 'success') {
            echo json_encode(['status' => 'error', 'message' => 'Error al editar la consulta: ' . $datos['message']]);
            break;
        }

        // Insertar comentarios
        $comentarios = $cliente->insert_comentarios($decifrado, $_POST["desc"], $_SESSION["usu_id"], $_POST["pri"]);

        // Editar el estado
        $res = ($_POST["resp"] == "VIABLE") ? "Viable" : "No viable";
        $estado = $cliente->editar_estado($decifrado, $res);

        // Si todo salió bien, enviar respuesta de éxito
        echo json_encode(['status' => 'success', 'message' => 'Consulta editada correctamente']);
        break;

    //INSERTAR PRESELECTA
    case "insertpreselecta":
        try {
            $fechaFormateada = null;
            if ($_POST["cli_edad"] != "") {
                $fechaInicio = DateTime::createFromFormat('d/m/Y', $_POST["cli_edad"]);
                $fechaFormateada = $fechaInicio->format('Y-m-d');
            }
            $tipo_contrato = isset($_POST["tipo_contrato"]) ? $_POST["tipo_contrato"] : "";
            $cli_cargo = isset($_POST["cli_cargo"]) ? $_POST["cli_cargo"] : "";
            $tiem_servicio = isset($_POST["tiem_servicio"]) ? $_POST["tiem_servicio"] : "";
            $tipo_pension = isset($_POST["tipo_pension"]) ? $_POST["tipo_pension"] : "";
            $cli_agente = isset($_POST["cli_agente"]) ? $_POST["cli_agente"] : "";

            $res = $cliente->insert_cliente_preselecta(
                $_POST["tipo_cc"],
                $_POST["cli_cc"],
                $_POST["cli_nombre"],
                $fechaFormateada,
                $_POST["cli_telefono"],
                $_POST["tel_alternativo"],
                $_POST["cli_mail"],
                $_POST["cli_ciudad"],
                $_POST["cli_depa"],
                $_POST["cli_entidad"],
                $_POST["cli_estado"],
                $_POST["cli_convenio"],
                $_POST["est_laboral"],
                $tipo_contrato,
                $cli_cargo,
                $tipo_pension,
                $tiem_servicio,
                $_POST["toma_contac"],
                $cli_agente,
                $_POST["cli_asesor"],
                $_POST["comentario"],
                $_POST["cli_dir"]
            );

            $res = json_encode($res);

            $cifrado = openssl_encrypt($res, $cipher, $key, OPENSSL_RAW_DATA, $iv);
            $textocifrado = base64_encode($iv . $cifrado);

            echo json_encode($textocifrado);
        } catch (Exception $e) {
            echo json_encode(array('status' => 'error', 'message' => 'Error al crear preselecta'));
        }
        break;

    //pendiente
    case "Buscaridcli":
        $datos = $cliente->Buscaridcli($_POST["documento"]);
        echo json_encode($datos);
        break;

    //---------------------------------------

    case "insertclixdoc":
        try {

            $cliente->insert_cliente_xdoc(
                $_POST["cli_cc"],
                $_POST["cli_nombre"],
                $_POST["cli_edad"],
                $_POST["cli_telefono"],
                $_POST["cli_ciudad"],
                $_POST["cli_entidad"],
                $_POST["cli_estado"],
                $_POST["cli_convenio"],
                $_POST["cli_asesor"],
                $_POST["fcreacion"],
                $_POST["toma_contac"],
                $_POST["tipo"]
            );

            // Enviar mensaje de Ã©xito al cliente
            echo json_encode(array('status' => 'success', 'message' => 'Cliente creado con Ã©xito'));
        } catch (Exception $e) {
            // Enviar mensaje de error al cliente
            echo json_encode(array('status' => 'error', 'message' => 'Error al crear el cliente'));
        }
        break;

    case "eliminaroperaciones": //ok*******
        $cliente->delete_operaciones(
            $_POST["ope_id"],
        );
        break;

    case "sumadesebolsados":
        if ($_SESSION["usu_grupocom"] == "") {
            $grupo = 0;
        } else {
            $grupo = $_SESSION["usu_grupocom"];
        }
        $datos = $cliente->sumadesebolsados($_SESSION["usu_id"], $_SESSION['usu_perfil'], $_POST["dato"], $grupo);
        echo json_encode($datos);
        break;

    case "selectcli":            
        $datos = $cliente->get_cliterm($_POST["term"],$_SESSION['usu_perfil'], $_SESSION["usu_id"],$_SESSION["usu_grupocom"]);
        if (is_array($datos) && count($datos) > 0) {
            echo json_encode($datos);
        }else {
            echo json_encode([]);
        }
        break;
    
}
