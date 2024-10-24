<?php
require_once "../config/conexion.php";
require_once "../models/logs.php";

$logs = new Logs();

switch ($_GET["op"]) {
    case "logs":
        $data = json_decode(file_get_contents("php://input"), true);
        $usu_id = $_SESSION["usu_id"];
        $tipo = $data["tipo"] ?? null;
        $detalle = $data["detalle"] ?? null;
        $ip = $_SESSION["client_ip"];

        if ($usu_id && $tipo && $detalle) {
            $logs->insert_logs($usu_id, $tipo, $detalle, $ip);
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Datos faltantes para el log'));
        }
        break;

}
