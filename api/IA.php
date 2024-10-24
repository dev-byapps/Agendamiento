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
// Puede ser vía GET, POST, o encabezados (headers)
// En este ejemplo, la obtenemos vía GET o POST
$clave_recibida = null;

// Priorizar la obtención de la clave desde los encabezados (más seguro)
$headers = getallheaders();
if (isset($headers['Authorization'])) {
    // Se asume que la clave API se envía en el encabezado Authorization como 'Bearer {API_KEY}'
    if (preg_match('/Bearer\s(\S+)/', $headers['Authorization'], $matches)) {
        $clave_recibida = $matches[1];
    }
} else {
    // Si no está en los encabezados, buscar en GET o POST
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
    if (isset($_GET['camp'])) {
        $camp = $_GET['camp']; // Asumimos que es un string
    } elseif (isset($_POST['camp'])) {
        $camp = $_POST['camp']; // Asumimos que es un string
    } else {
        http_response_code(400); // Solicitud incorrecta
        echo json_encode(["error" => "Falta el parámetro camp"]);
        exit();
    }
    
    // Verificar si se ha enviado el parámetro cant
    if (isset($_GET['cant'])) {
        $cant = (int)$_GET['cant']; // Convertir a entero
    } elseif (isset($_POST['cant'])) {
        $cant = (int)$_POST['cant']; // Convertir a entero
    } else {
        http_response_code(400); // Solicitud incorrecta
        echo json_encode(["error" => "Falta el parámetro cant"]);
        exit();
    }
    
    
    try {
        // Preparar y ejecutar la consulta
        $stmt = $db->prepare("call IA2(:camp, :cant)");
        $stmt->bindParam(':camp', $camp, PDO::PARAM_STR); // Cambia a PDO::PARAM_STR
        $stmt->bindParam(':cant', $cant, PDO::PARAM_INT);
        $stmt->execute();
    
        // Fetch the first result set (table data)
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        // Move to the second result set (variables)
        $stmt->nextRowset();
        $variables = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($resultados && $variables) {
            echo json_encode([
                "resultados" => $resultados,
                "ENVIADOS" => $variables['ENVIADOS'],
                "TOTALES" => $variables['TOTALES']
            ]);
        } else {
            http_response_code(404);
            echo json_encode(["error" => "No se encontraron datos"]);
        }
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["error" => "Error al ejecutar la consulta"]);
    }
}
