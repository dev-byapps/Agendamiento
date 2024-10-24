<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Content-Type: application/json; charset=UTF-8");

// Definir la ruta base del proyecto
define('BASE_PATH', __DIR__ . '/../');

// Incluir el archivo de conexión a la base de datos
require_once BASE_PATH . 'config/conexion.php';

// Utilizar la clase Conectar para establecer la conexión
$conexion = new Conectar();
$db = $conexion->Conexion();
$conexion->set_names();

// Obtener la clave API enviada por la solicitud
$clave_recibida = null;

// Priorizar la obtención de la clave desde los encabezados
$headers = getallheaders();
if (isset($headers['Authorization'])) {
    if (preg_match('/Bearer\s(\S+)/', $headers['Authorization'], $matches)) {
        $clave_recibida = $matches[1];
    }
} else {
    if (isset($_GET['api_key'])) {
        $clave_recibida = $_GET['api_key'];
    } elseif (isset($_POST['api_key'])) {
        $clave_recibida = $_POST['api_key'];
    }
}

// Validar la clave API
if ($clave_recibida !== API_KEY) {
    http_response_code(401); // No autorizado
    echo json_encode(["error" => "Clave API inválida"]);
    exit();
}else{
    // Verificar los parámetros que se quieren actualizar
$id = isset($_POST['id']) ? (int)$_POST['id'] : null;
$camp = isset($_POST['camp']) ? $_POST['camp'] : null;
$est = isset($_POST['est']) ? $_POST['est'] : null;
$age = isset($_POST['age']) ? $_POST['age'] : null;
$obs = isset($_POST['obs']) ? $_POST['obs'] : null;
$inte = isset($_POST['inte']) ? $_POST['inte'] : null;
$gra = isset($_POST['gra']) ? $_POST['gra'] : null;


// Validar que al menos un campo esté presente para la actualización
if (is_null($id) || is_null($camp) || is_null($est) || is_null($obs)) {
    http_response_code(400); // Solicitud incorrecta
    echo json_encode(["error" => "Faltan parámetros"]);
    exit();
}else{
    try {
        // Preparar y ejecutar la consulta
        $stmt = $db->prepare("call IA_IN2(:camp, :id, :est, :age, :obs, :inte, :gra)");
        $stmt->bindParam(':camp', $camp, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':est', $est, PDO::PARAM_STR);
        $stmt->bindParam(':age', $age, PDO::PARAM_STR);
        $stmt->bindParam(':obs', $obs, PDO::PARAM_STR);
        $stmt->bindParam(':inte', $inte, PDO::PARAM_STR);
        $stmt->bindParam(':gra', $gra, PDO::PARAM_STR);
    
        $stmt->execute();
    
        if ($stmt->rowCount() > 0) {
            echo json_encode(["success" => "Cliente creado y Actualizado con Exito"]);
        } else {
            http_response_code(404); // No encontrado
            echo json_encode(["error" => "Error: No se pudo actualizar el cliente"]);
        }
    } catch (PDOException $e) {
        http_response_code(500);
        // Verificar si el mensaje de error contiene el código de error 45000
        if (strpos($e->getMessage(), '45000') !== false) {
            echo json_encode([
                "error" => "El nombre de la campaña no existe, Por favor validelo."
            ]);
        }else if (strpos($e->getMessage(), '22001') !== false) {
            echo json_encode([
                "error" => "El valor de la grabación es más largo de lo esperado."
            ]);
        }else {
            echo json_encode([
                "error" => "Error al ejecutar la consulta",
                "details" => $e->getMessage()
            ]);
        }
    }
}
}