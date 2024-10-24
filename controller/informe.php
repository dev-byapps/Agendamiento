<?php
require_once "../config/conexion.php";
require_once "../models/informe.php";
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$informe = new Informe();

switch ($_GET["op"]) {
    case "inf_consultas":
        // DIVIDIR FECHAS
        $fechastar = $_POST['daterange'];
        $fechas = explode(" - ", $fechastar);
        $fechaInicio = DateTime::createFromFormat('d/m/Y', $fechas[0])->format('Y-m-d');
        $fechaFin = DateTime::createFromFormat('d/m/Y', $fechas[1])->format('Y-m-d');

        $datos = $informe->inf_consultas($fechaInicio, $fechaFin, $_POST["fil_entidad"], $_POST["fil_grupo"], $_POST["fil_asesor"]);

        if (empty($datos)) {

            // Enviar respuesta JSON en caso de que no haya datos
            header('Content-Type: application/json');
            echo json_encode(['error' => 'No hay datos disponibles para las fechas seleccionadas.']);
            exit;

        }
        // Crear un nuevo objeto de Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Añadir encabezados de columna
        $sheet->setTitle("Consultas");
        $sheet->setCellValue('A1', 'CEDULA');
        $sheet->setCellValue('B1', 'NOMBRE CLIENTE');
        $sheet->setCellValue('C1', 'CIUDAD');
        $sheet->setCellValue('D1', 'ENTIDAD');
        $sheet->setCellValue('E1', 'CONVENIO');
        $sheet->setCellValue('F1', 'CONSULTA');
        $sheet->setCellValue('G1', 'FECHA DE CONSULTA');
        $sheet->setCellValue('H1', 'CONCEPTO DE NO VIABILIDAD');
        $sheet->setCellValue('I1', 'GRUPO COMERCIAL');
        $sheet->setCellValue('J1', 'ASESOR');

        // Añadir datos al archivo de Excel
        $row = 2; // Comienza en la fila 2 porque la fila 1 tiene los encabezados
        if (!empty($datos)) {
            foreach ($datos as $dato) {
                $sheet->setCellValue('A' . $row, $dato['cli_doc']);
                $sheet->setCellValue('B' . $row, $dato['cli_nom']);
                $sheet->setCellValue('C' . $row, $dato['cli_ciu']);
                $sheet->setCellValue('D' . $row, $dato['ent_nom']);
                $sheet->setCellValue('E' . $row, $dato['cli_con']);
                $sheet->setCellValue('F' . $row, $dato['con_res']);
                $sheet->setCellValue('G' . $row, $dato['con_fecon']);
                $sheet->setCellValue('H' . $row, $dato['con_des']);
                $sheet->setCellValue('I' . $row, $dato['gcom_id']);
                $sheet->setCellValue('J' . $row, $dato['detu_nom']);
                $row++;
            }
        }

        // Limpiar el búfer de salida si existe
        if (ob_get_contents()) {
            ob_end_clean();
        }

        // Crear el archivo de Excel
        $writer = new Xlsx($spreadsheet);
        echo "hola";
        // Configurar encabezados HTTP para la descarga del archivo
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="informe_Consultas.xlsx"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');

        // Enviar el archivo al navegador
        $writer->save('php://output');
        break;

        case "inf_operaciones":
            // DIVIDIR FECHAS
            $fechastar = $_POST["daterange2"];
            $fechas = explode(" - ", $fechastar);
            $fechaInicio = DateTime::createFromFormat('d/m/Y', $fechas[0])->format('Y-m-d');
            $fechaFin = DateTime::createFromFormat('d/m/Y', $fechas[1])->format('Y-m-d');
    
            $datos = $informe->inf_operaciones($fechaInicio, $fechaFin, $_POST["fil_entidad_ope"], $_POST["fil_grupo_ope"], $_POST["fil_asesor_ope"]);
    
            // echo json_encode($datos);
            if (empty($datos)) {
    
                // No hay datos, enviar una respuesta JSON
                echo json_encode(['error' => 'No se encontraron datos.']);
                exit;
            }
    
            // Crear un nuevo objeto de Spreadsheet
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
    
            // AÃƒÂ±adir encabezados de columna (ajusta segÃƒÂºn tus datos)
            $sheet->setCellValue('A1', 'CEDULA');
            $sheet->setCellValue('B1', 'NOMBRE CLIENTE');
            $sheet->setCellValue('C1', 'CIUDAD');
            $sheet->setCellValue('D1', 'CONVENIO');
            $sheet->setCellValue('E1', 'ENTIDAD');
            $sheet->setCellValue('F1', 'COD OPERACION');
            $sheet->setCellValue('G1', 'OPERACION');
            $sheet->setCellValue('H1', 'ESTADO CRM');
            $sheet->setCellValue('I1', 'ESTADO OPERACION');
            $sheet->setCellValue('J1', 'MONTO RADICADO');
            $sheet->setCellValue('K1', 'MONTO DESEMBOLSADO');
            $sheet->setCellValue('L1', 'TASA');
            $sheet->setCellValue('M1', 'PLAZO');
            $sheet->setCellValue('N1', 'FECHA RADICADO');
            $sheet->setCellValue('O1', 'FECHA CIERRE');
            $sheet->setCellValue('P1', 'ASESOR');
            $sheet->setCellValue('Q1', 'GRUPO COMERCIAL');
    
            // AÃƒÂ±adir datos al archivo de Excel
            $row = 2; // Comienza en la fila 2 porque la fila 1 tiene los encabezados
            foreach ($datos as $dato) {
                $sheet->setCellValue('A' . $row, $dato['cli_doc']);
                $sheet->setCellValue('B' . $row, $dato['cli_nom']);
                $sheet->setCellValue('C' . $row, $dato['cli_ciu']);
                $sheet->setCellValue('D' . $row, $dato['cli_con']);
                $sheet->setCellValue('E' . $row, $dato['ent_nom']);          
                $sheet->setCellValue('F' . $row, $dato['ope_cod']);
                $sheet->setCellValue('G' . $row, $dato['ope_ope']);
                $sheet->setCellValue('H' . $row, $dato['ope_est']);
                $sheet->setCellValue('I' . $row, $dato['ope_estope']);
                $sheet->setCellValue('J' . $row, $dato['ope_mon']);
                $sheet->setCellValue('K' . $row, $dato['ope_monap']);
                $sheet->setCellValue('L' . $row, $dato['ope_tasa']);
                $sheet->setCellValue('M' . $row, $dato['ope_pla']);
                $sheet->setCellValue('N' . $row, $dato['ope_feradi']);
                $sheet->setCellValue('O' . $row, $dato['ope_fecie']);
                $sheet->setCellValue('P' . $row, $dato['detu_nom']);
                $sheet->setCellValue('Q' . $row, $dato['gcom_nom']);
    
                $row++;
            }
    
            // Crear el archivo de Excel
            $writer = new Xlsx($spreadsheet);
            $filename = 'Informe_Operaciones' . date('Ymd') . '.xlsx';
            $path = "../documents/informes/" . $filename;
            $writer->save($path);
    
            // Enviar el archivo al navegador
            $response = array('file' => $path);
            echo json_encode($response);
    
            break;
    

}
