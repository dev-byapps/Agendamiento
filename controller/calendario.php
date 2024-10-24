<?php
require_once "../config/conexion.php";
require_once "../models/calendario.php";

$calendario = new Calendario();

switch ($_GET["op"]) {
    // Categorias
    case "listar_catevents":  
        $eventos = $calendario->listar_catevents($_SESSION["usu_id"]);
        if ($eventos['success'] === false) {
            // Manejar el error, por ejemplo, devolver un mensaje de error en formato JSON
            echo json_encode(array('error' => true, 'message' => $eventos['message']));
        } else {
            echo json_encode(array('error' => false, 'data' => $eventos['data']));
        }
        break;

    // Calendario
        case "listar_calendarios":  
            $calendarios = $calendario->listar_calendarios($_SESSION["usu_id"]);
            echo json_encode($calendarios);
            break;

    

    // Eventos
        case "listar_events": 
            // Obtener las categorías Y calendarios seleccionados del frontend (pueden venir como un array)
            $categories = isset($_POST['categories']) ? json_decode($_POST['categories'], true) : []; // Decodificar JSON a array
            $calendarios = isset($_POST['calendarios']) ? json_decode($_POST['calendarios'], true) : []; // Decodificar JSON a array

            $datos = $calendario->listar_events( $_SESSION["usu_id"], $categories, $calendarios, $_POST['start'],$_POST['end']);
            $datos = json_decode($datos, true);

            if ($datos === null) {
                echo json_encode(['status' => 'error', 'message' => 'Error al procesar los datos.']);
                break;
            }

            $eventos = array();
            $participantes = array();
            $notificaciones = array();

            // Verifica el estado
            if ($datos['status'] === 'success') {
                // Decodifica los datos de eventos, participantes y notificaciones
                $eventos = json_decode($datos['datos'][0]['eventos'], true);
                $participantes = json_decode($datos['datos'][0]['participantes'], true);
                $notificaciones = json_decode($datos['datos'][0]['notificaciones'], true);
                
                // Verifica si $eventos no está vacío
                if (!empty($eventos) && is_array($eventos)) {

                    // Crear un array asociativo para vincular participantes a eventos
                    $participantesPorEvento = array();
                    $notificacionesPorEvento = array();

                    // Si hay participantes, agrúpalos por eve_id
                    if (!empty($participantes) && is_array($participantes)) {
                        foreach ($participantes as $participante) {
                            $eveId = $participante['eve_id'];
                            if (!isset($participantesPorEvento[$eveId])) {
                                $participantesPorEvento[$eveId] = array(); // Inicializa el array si no existe
                            }
                            // Agrega el participante al evento correspondiente
                            $participantesPorEvento[$eveId][] = $participante;
                        }
                    }

                    // Si hay notificaciones, agrúpalas por eve_id
                    if (!empty($notificaciones) && is_array($notificaciones)) {
                        foreach ($notificaciones as $notificacion) {
                            $eveId = $notificacion['eve_id'];
                            if (!isset($notificacionesPorEvento[$eveId])) {
                                $notificacionesPorEvento[$eveId] = array(); // Inicializa el array si no existe
                            }
                            // Agrega la notificación al evento correspondiente
                            $notificacionesPorEvento[$eveId][] = $notificacion;
                        }
                    }

                    foreach ($eventos as $row) {                     

                        // Dividir la cadena en fecha y hora
                        list($fecha, $horaIni) = explode(' ', $row['eve_feini']);
                        list($fecha, $horaFin) = explode(' ', $row['eve_fefin']);

                        $eventoData = array(
                            'id' => $row['eve_id'],
                            'title' => $row['eve_tit'],
                            'descrip' => $row['eve_des'],
                            'cateve_id' => $row['cateve_id'],
                            'categoria' => $row['cateve_title'],
                            'cateve_color' => $row['cateve_color'],
                            'estado' => $row['eve_est'],
                            'prioridad' => $row['eve_pri'],
                            'Tododia' => $row['eve_dia'],
                            'fecha' => $fecha,
                            'horaIni' => $horaIni,
                            'horaFin' => $horaFin,
                            'start' => $row['eve_feini'],
                            'end' => $row['eve_fefin'],
                            'ubicacion' => $row['eve_ubi'],
                            'cal_id' => $row['cal_id'],
                            'calendario' => $row['cal_nom'],
                            'cal_col' => $row['cal_col'],
                            'eve_com' => $row['eve_com'],
                            'participantes' => isset($participantesPorEvento[$row['eve_id']]) ? $participantesPorEvento[$row['eve_id']] : array(), // Asocia participantes al evento
                            'notificaciones' => isset($notificacionesPorEvento[$row['eve_id']]) ? $notificacionesPorEvento[$row['eve_id']] : array() // Asocia notificaciones al evento
                        );

                        // Añade el evento a la lista final
                        $eventos[] = $eventoData;
                    }
                } 
            } else {
                echo json_encode(['status' => 'error', 'message' => $datos['message']]);
            }
            echo json_encode(['status' => 'success', 'data' => $eventos]);
            break;  

        case "guardaryeditarEvento":
            $res = '';
            $num1 = 1;
            $num2 = 1;
            $fechaOriginal = $_POST["tar_fcierre"];
            // Convertir la fecha de formato dd/mm/yyyy a yyyy-mm-dd
            $fechaFormateada = DateTime::createFromFormat('d/m/Y', $fechaOriginal)->format('Y-m-d');
            // Obtener hora de inicio
            $hini = filter_input(INPUT_POST, "horaini", FILTER_SANITIZE_STRING) ?: $_POST["horaini_hidden"];
            // Obtener hora de fin
            $hfin = filter_input(INPUT_POST, "horafin", FILTER_SANITIZE_STRING) ?: $_POST["horafin_hidden"];
            $feini = $fechaFormateada . ' ' . $hini;
            $fefin = $fechaFormateada . ' ' . $hfin;

            // Variable para almacenar el ID del evento en caso de que se cree
            $ideve = null;
            $error = false;

            if (empty($_POST["tar_id"])) {
                // Intentar crear el evento
                $ideve = $calendario->insert_events(
                    filter_input(INPUT_POST, "tar_titulo", FILTER_SANITIZE_STRING),
                    filter_input(INPUT_POST, "tar_des", FILTER_SANITIZE_STRING), 
                    filter_input(INPUT_POST, "tar_cat", FILTER_VALIDATE_INT),
                    filter_input(INPUT_POST, "tar_est", FILTER_SANITIZE_STRING),
                    filter_input(INPUT_POST, "tar_pri", FILTER_SANITIZE_STRING),
                    filter_input(INPUT_POST, "todo_dia", FILTER_SANITIZE_STRING),
                    $feini, 
                    $fefin,
                    filter_input(INPUT_POST, "tar_ubi", FILTER_SANITIZE_STRING),
                    filter_input(INPUT_POST, "tar_cal", FILTER_VALIDATE_INT),
                    $_SESSION["usu_id"], 
                    filter_input(INPUT_POST, "agenda", FILTER_SANITIZE_STRING)
                );  

                // Comprobar si la inserción fue exitosa
                if ($ideve === false) {
                    $error = true;
                    $data .= 'Error: no se pudo crear el evento.';
                }

                // Procesar las notificaciones dinámicas
                $coun = filter_input(INPUT_POST, "counter", FILTER_VALIDATE_INT);
                if ($coun !== false && $coun >= $num1) {
                    while ($num1 <= $coun) {
                        
                        if (isset($_POST["tar_not_" . $num1])) { // Verifica si existe el campo de Notificación
                            $tar_not = filter_input(INPUT_POST, "tar_not_" . $num1, FILTER_SANITIZE_STRING);
                            $tar_min = filter_input(INPUT_POST, "tar_min_" . $num1, FILTER_VALIDATE_INT);
                            $tar_tie = filter_input(INPUT_POST, "tar_tie_" . $num1, FILTER_SANITIZE_STRING);
                            
                            if ($tar_min !== false && $tar_min !== null) { // Verifica que el campo de minutos no esté vacío y sea un número
                                // Inserta cada notificación
                                $result = $calendario->insert_notify($ideve, $tar_not, $tar_min, $tar_tie);
                                if ($result === false) {
                                    $error = true;
                                    $data .= 'Error: no se pudo crear la notificación ' . $num1 . '.';
                                    break; // Salir del bucle si hay un error
                                }
                            }
                        }
                        $num1++; // Aumenta el número para la siguiente iteración
                    }
                } else {
                    $data .= 'Error: contador no válido.';
                    $error = true;
                }

                // Procesar los participantes dinámicos
                $count = filter_input(INPUT_POST, "counterpar", FILTER_VALIDATE_INT);
                if ($count !== false && $count >= $num2) {
                    while ($num2 <= $count) {
                        
                        if (isset($_POST["tar_par_" . $num2])) { // Verifica si existe el campo de Notificación
                            $tar_par = filter_input(INPUT_POST, "tar_par_" . $num2, FILTER_SANITIZE_STRING);
                            $mail = filter_input(INPUT_POST, "tar_dat_" . $num2, FILTER_SANITIZE_STRING);
                            $tar_edit = filter_input(INPUT_POST, "tar_edit_" . $num2, FILTER_SANITIZE_STRING);
                            
                            if ($mail !== null) {
                                // Inserta cada notificación
                                $result = $calendario->insert_eventshare($ideve, $tar_par, $mail, $tar_edit);
                                if ($result === false) {
                                    $error = true;
                                    $data .= 'Error: no se pudo crear el participante ' . $num2 . '.';
                                    break; // Salir del bucle si hay un error
                                }
                            }
                        }
                        $num2++; // Aumenta el número para la siguiente iteración
                    }
                } else {
                    $data .= 'Error: contador participantes no válido.';
                    $error = true;
                }

                // Si hubo un error, eliminar el evento, notificaciones y participantes creados
                if ($error) {
                    if ($ideve) {
                        // Eliminar el evento
                        $calendario->delete_event_completo($ideve);                     
                    }
                } else {
                    echo "1"; // Todo salió bien
                }
            } else {
                $entidad->update_entidad($_POST["ent_id"], $_POST["ent_nombre"], $_POST["ent_coment"], $_POST["ent_estado"]);
                echo "2";
            }
            break;
            
        case "delete_event":
            // Obtén el ID del evento a eliminar
            $eventId = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
                
            // Asegúrate de que el ID sea válido
            if ($eventId) {
                $res = $calendario->delete_event_completo($eventId);
                    
                // Verifica la respuesta del método delete_event
                if ($res['status'] === 'success') {
                    $response = [
                        'success' => true,
                        'message' => $res['message']
                    ];
                } else {
                    $response = [
                        'success' => false,
                        'message' => $res['message']
                    ];
                }
            } else {
                // ID no válido
                $response = [
                    'success' => false,
                    'message' => 'ID de evento no válido.'
                ];
            }
            
            // Enviar la respuesta como JSON
            echo json_encode($response);
            exit();
            
            








    // Compartir calendario

    case "agregarevents":
        // Recibir los datos del evento vía POST (los envías desde AJAX)
        $title = $_POST["title"];
        $start = $_POST["start"];
        $end = $_POST["end"];
        $category_id = $_POST["category_id"];
    
        // Llamar al método del modelo para insertar el evento
        $calendario->agregarevents($title, $start, $end);
        echo json_encode(["status" => "success"]);
        break;
    case "eliminarevents":
        // Recibir el id del evento vía POST (enviado desde AJAX)
        $id = $_POST["id"];
        
        // Llamar al método del modelo para eliminar el evento
        $calendario->eliminarevents($id);
        echo json_encode(["status" => "success"]);
        break;
    case "editarevents":
        // Recibir los datos del evento desde la solicitud AJAX
        $id = $_POST["id"];
        $title = $_POST["title"];
        $start = $_POST["start"];
        $end = $_POST["end"];
            
        // Llamar al método del modelo para actualizar el evento
        $calendario->editarevents($id, $title, $start, $end);
        echo json_encode(["status" => "success"]);
        break;
    
}
