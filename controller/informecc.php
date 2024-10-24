<?php
require_once "../config/conexion.php";
require_once "../models/informecc.php";
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$informe = new Informecc();

switch ($_GET["op"]) {

    case "inf_llamadas":
        // DIVIDIR FECHAS
        $fechastar = $_POST["daterange"];
        $fechas = explode(" - ", $fechastar);
        $fechaInicio = DateTime::createFromFormat('d/m/Y', $fechas[0])->format('Y-m-d');
        $fechaFin = DateTime::createFromFormat('d/m/Y', $fechas[1])->format('Y-m-d');

        $datos = $informe->inf_llamadas($fechaInicio, $fechaFin, $_POST["fil_camp"], $_POST["fil_asesor"]);

        // echo json_encode($datos);
        if (empty($datos)) {

            // No hay datos, enviar una respuesta JSON
            echo json_encode(['error' => 'No se encontraron datos.']);
            exit;
        }

        // Crear un nuevo objeto de Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // AÃ±adir encabezados de columna (ajusta segÃºn tus datos)
        $sheet->setCellValue('A1', 'CEDULA');
        $sheet->setCellValue('B1', 'NOMBRE CLIENTE');
        $sheet->setCellValue('C1', 'TELEFONO');
        $sheet->setCellValue('D1', 'ESTADO');
        $sheet->setCellValue('E1', 'INTENTOS');
        $sheet->setCellValue('F1', 'CONVENIO');
        $sheet->setCellValue('G1', 'CIUDAD');
        $sheet->setCellValue('H1', 'ASESOR');
        $sheet->setCellValue('I1', 'FECHA GESTION');
        //$sheet->setCellValue('J1', 'FECHA VOLVER A LLAMAR');
        // $sheet->setCellValue('I1', 'HORA VOLVER A LLAMAR');
        $sheet->setCellValue('J1', 'OBSERVACIONES');

        // AÃ±adir datos al archivo de Excel
        $row = 2; // Comienza en la fila 2 porque la fila 1 tiene los encabezados
        foreach ($datos as $dato) {
            $sheet->setCellValue('A' . $row, isset($dato['CEDULA']) ? $dato['CEDULA'] : '');
            $sheet->setCellValue('B' . $row, isset($dato['NOMBRE']) ? $dato['NOMBRE'] : '');
            $sheet->setCellValue('C' . $row, isset($dato['TELEFONO']) ? $dato['TELEFONO'] : '');
            $sheet->setCellValue('D' . $row, isset($dato['ESTADO']) ? $dato['ESTADO'] : '');
            $sheet->setCellValue('E' . $row, isset($dato['INTENTOS']) ? $dato['INTENTOS'] : '');
            $sheet->setCellValue('F' . $row, isset($dato['CONVENIO']) ? $dato['CONVENIO'] : '');
            $sheet->setCellValue('G' . $row, isset($dato['CIUDAD']) ? $dato['CIUDAD'] : '');
            $sheet->setCellValue('H' . $row, (isset($dato['detu_nom']) ? $dato['detu_nom'] : '') . " " . (isset($dato['detu_ape']) ? $dato['detu_ape'] : ''));
            $sheet->setCellValue('I' . $row, isset($dato['FECHA']) ? $dato['FECHA'] : '');
            // $sheet->setCellValue('J' . $row, isset($dato['FECHAVLL']) ? $dato['FECHAVLL'] : '');
            // $sheet->setCellValue('I' . $row, isset($dato['HORA']) ? $dato['HORA'] : '');
            $sheet->setCellValue('J' . $row, isset($dato['OBSERVACIONES']) ? $dato['OBSERVACIONES'] : '');
        
            $row++;
        }        

        // Crear el archivo de Excel
        $writer = new Xlsx($spreadsheet);
        $filename = 'Informe_Llamadas' . date('Ymd') . '.xlsx';
        $path = "../documents/informes/" . $filename;
        $writer->save($path);
        // Enviar el archivo al navegador
        $response = array('file' => $path);
        echo json_encode($response);
        break;
    

    
    case "inf_ragente":
        // DIVIDIR FECHAS
        $fechastar = $_POST["daterange2"];
        $fechas = explode(" - ", $fechastar);
        $fechaInicio = DateTime::createFromFormat('d/m/Y', $fechas[0])->format('Y-m-d');
        $fechaFin = DateTime::createFromFormat('d/m/Y', $fechas[1])->format('Y-m-d');
        
        $datos = $informe->inf_ragente($fechaInicio, $fechaFin, $_POST["fil_grupo1"], $_POST["fil_asesor2"]);
        
        // echo json_encode($datos);
        if (empty($datos)) {        
            echo json_encode(['error' => 'No se encontraron datos.']);
            exit;
        }
        
        // Crear un nuevo objeto de Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Añadir encabezados de columna (ajusta segÃºn tus datos)
        $sheet->setCellValue('A1', 'AGENTE');
        $sheet->setCellValue('B1', 'CAMPAÑA');
        $sheet->setCellValue('C1', 'DETALLE');
        $sheet->setCellValue('D1', 'ESTADO');
        $sheet->setCellValue('E1', 'FECHA');
        
        // Añadir datos al archivo de Excel
        $row = 2; // Comienza en la fila 2 porque la fila 1 tiene los encabezados
        foreach ($datos as $dato) {
            $sheet->setCellValue('A' . $row, trim((isset($dato['detu_nom']) ? $dato['detu_nom'] : '') . ' ' . (isset($dato['detu_ape']) ? $dato['detu_ape'] : '')));
            $sheet->setCellValue('B' . $row, isset($dato['cam_nom']) ? $dato['cam_nom'] : '');

            // DETALLE
            $detalle = isset($dato['reco_det']) ? $dato['reco_det'] : '';
            switch ($detalle) {
                case 1:
                    $detalleTexto = 'BREAK';
                    break;
                case 2:
                    $detalleTexto = 'AUSENCIA';
                    break;
                case 3:
                    $detalleTexto = 'SUPERVISOR';
                    break;
                case 4:
                    $detalleTexto = 'LLAMADA EN ESPERA';
                    break;
                default:
                    $detalleTexto = $detalle;
                    break;
            }
            $sheet->setCellValue('C' . $row, $detalleTexto);

            // ESTADO
            $estado = isset($dato['reco_est']) ? $dato['reco_est'] : '';
            switch ($estado) {
                case 1:
                    $estadoTexto = 'INGRESO';
                    break;
                case 2:
                    $estadoTexto = 'TERMINADO';
                    break;
                default:
                    $estadoTexto = '';
                    break;
            }
            $sheet->setCellValue('D' . $row, $estadoTexto);
    
            // FECHA
            if (isset($dato['reco_fech'])) {
                // Crear objeto DateTime a partir del formato de entrada
                $fecha = DateTime::createFromFormat('Y-m-d H:i:s', $dato['reco_fech']); // Asegúrate de usar el formato correcto de entrada
            
                if ($fecha) {
                    // Formatear la fecha y hora en el formato deseado
                    $fechaFormateada = $fecha->format('d/m/Y h:i A');
                    $sheet->setCellValue('E' . $row, $fechaFormateada);
                } else {
                    $sheet->setCellValue('E' . $row, ''); // Manejar casos donde la fecha no se puede convertir
                }
            } else {
                $sheet->setCellValue('E' . $row, ''); // Si 'reco_fech' no está establecido
            }
            $row++;
        }
                
        
        // Crear el archivo de Excel
        $writer = new Xlsx($spreadsheet);
        $filename = 'Informe_Registro_Agenda' . date('Ymd') . '.xlsx';
        $path = "../documents/informes/" . $filename;
        $writer->save($path);
        
        // Enviar el archivo al navegador
        $response = array('file' => $path);
        echo json_encode($response);
        
        break;
                
    case "inf_base":
        $datos = $informe->inf_base($_POST["fil_camp2"]);
                
        if (empty($datos)) {        
            echo json_encode(['error' => 'No se encontraron datos.']);
            exit;
        }
      
        // Crear un nuevo objeto de Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
                
        // Obtener nombres de columnas sin claves numéricas
        $columnNames = array_keys($datos[0]);
        $filteredColumnNames = array_filter($columnNames, function($key) {
            // Verifica si la clave es una cadena no numérica
            return !is_numeric($key);
        });
                
        // Añadir encabezados de columna de manera dinámica
        $col = 'A';
        foreach ($filteredColumnNames as $columnName) {
            $sheet->setCellValue($col . '1', strtoupper($columnName));
            $col++;
        }
                
        // Añadir datos al archivo de Excel
        $row = 2; // Comienza en la fila 2 porque la fila 1 tiene los encabezados
        foreach ($datos as $dato) {
            $col = 'A';
            foreach ($filteredColumnNames as $columnName) {
                // Coloca el valor en la celda, o una cadena vacía si no existe el valor
                $sheet->setCellValue($col . $row, isset($dato[$columnName]) ? $dato[$columnName] : '');
                $col++;
            }
            $row++;
        }
                
        // Crear el archivo de Excel
        $writer = new Xlsx($spreadsheet);
        $filename = 'Informe_campaña_' . $_POST["nomcamp"] . date('Ymd') . '.xlsx';
        $path = "../documents/informes/" . $filename;
        $writer->save($path);
                
        // Enviar el archivo al navegador
        $response = array('file' => $path);
        echo json_encode($response);
                
        break;
    case "info_agenda":
        // DIVIDIR FECHAS
        $fechastar = $_POST["daterange1"];
        $fechas = explode(" - ", $fechastar);
        $fechaInicio = DateTime::createFromFormat('d/m/Y', $fechas[0])->format('Y-m-d');
        $fechaFin = DateTime::createFromFormat('d/m/Y', $fechas[1])->format('Y-m-d');

        $datos = $informe->info_agenda($fechaInicio, $fechaFin, $_POST["fil_grupo"], $_POST["fil_asesor1"]);

        // echo json_encode($datos);
        if (empty($datos)) {
            echo json_encode(['error' => 'No se encontraron datos.']);
            exit;
        }
        
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        $sheet->setCellValue('A1', 'CEDULA');
        $sheet->setCellValue('B1', 'CLIENTE');
        $sheet->setCellValue('C1', 'CAMPAÑA');
        $sheet->setCellValue('D1', 'CONVENIO');
        $sheet->setCellValue('E1', 'AGENTE');
        $sheet->setCellValue('F1', 'FECHA');
        $sheet->setCellValue('G1', 'HORA');
        $sheet->setCellValue('H1', 'ESTADO');
        
        // AÃ±adir datos al archivo de Excel
        $row = 2; // Comienza en la fila 2 porque la fila 1 tiene los encabezados
        foreach ($datos as $dato) {
            $sheet->setCellValue('A' . $row, isset($dato['CEDULA']) ? $dato['CEDULA'] : '');
            $sheet->setCellValue('B' . $row, isset($dato['NOMBRE']) ? $dato['NOMBRE'] : '');
            $sheet->setCellValue('C' . $row, isset($dato['cam_nom']) ? $dato['cam_nom'] : '');
            $sheet->setCellValue('D' . $row, isset($dato['age_conv']) ? $dato['age_conv'] : '');
            $nombreCompleto = trim($dato['detu_nom'] . " " . $dato['detu_ape']); 
            
            // ASESOR
            if (!empty($nombreCompleto)) {
                $sheet->setCellValue('E' . $row, $nombreCompleto);
            } else {
                $sheet->setCellValue('E' . $row, '');
            }

            // FECHA
            if (isset($dato['age_fecha'])) {
                $fecha = DateTime::createFromFormat('Y-m-d', $dato['age_fecha']); // Convertir de 'Y-m-d' a objeto DateTime
                $fechaFormateada = $fecha->format('d/m/Y'); // Formatear a 'd/m/Y'
                $sheet->setCellValue('F' . $row, $fechaFormateada);
            } else {
                $sheet->setCellValue('F' . $row, '');
            }
            // echo json_encode($dato['age_hora']);
            // HORA
            if (isset($dato['age_hora'])) {
                $hora = DateTime::createFromFormat('H:i:s', $dato['age_hora']); // Convertir de 'H:i:s' a objeto DateTime
                $horaFormateada = $hora->format('h:i A'); // Formatear a 'h:i A' para obtener 'HH:MM AM/PM'
                $sheet->setCellValue('G' . $row, $horaFormateada);
            } else {
                $sheet->setCellValue('G' . $row, '');
            }
            // ESTADO
            if (isset($dato['age_est'])) {
                $estado = '';
                if ($dato['age_est'] == 1) {
                    $estado = 'AGENDADO';
                } elseif ($dato['age_est'] == 2) {
                    $estado = 'REAGENDADO';
                } elseif ($dato['age_est'] == 3) {
                    $estado = 'CERRADO';
                }else if($dato['age_est'] == 4) {
                    $estado = 'CERRADO POR CAMPAÑA';
                }

                $sheet->setCellValue('H' . $row, $estado);
            } else {
                $sheet->setCellValue('H' . $row, '');
            }
            
            $row++;
        }

        // Crear el archivo de Excel
        $writer = new Xlsx($spreadsheet);
        $filename = 'Informe_Agenda' . date('Ymd') . '.xlsx';
        $path = "../documents/informes/" . $filename;
        $writer->save($path);
    
        // Enviar el archivo al navegador
        $response = array('file' => $path);
        echo json_encode($response);

        break;
        
                
}
