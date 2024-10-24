<?php
// Configuración del servidor Asterisk
$asteriskHost = 'ps2.byapps.co';  // Cambia esto a la IP de tu servidor Asterisk
$asteriskPort = 8089;          // Cambia esto al puerto de tu servidor Asterisk
$asteriskUsername = 'userDB2024Crm';   // Cambia esto al nombre de usuario de tu servidor Asterisk
$asteriskPassword = '54sg674nbjkb54jswef567jh';   // Cambia esto a la contraseña de tu servidor Asterisk

// Número al que se realizará la llamada
$destinationNumber = '3209177653';   // Reemplaza con el número de destino
$extSIP = '4000';              // Reemplaza con tu extensión SIP

// Crear el comando Originate para realizar la llamada
$originateCommand = "Action: Originate\r\n";
$originateCommand .= "Channel: Local/$extSIP@from-internal\r\n";
$originateCommand .= "Context: from-internal\r\n";
$originateCommand .= "Exten: $destinationNumber\r\n";
$originateCommand .= "Priority: 1\r\n";
$originateCommand .= "Callerid: AMI Call\r\n\r\n";

// Crear la conexión con el servidor Asterisk
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
socket_connect($socket, $asteriskHost, $asteriskPort);

// Iniciar sesión en el servidor Asterisk
$loginCommand = "Action: Login\r\n";
$loginCommand .= "Username: $asteriskUsername\r\n";
$loginCommand .= "Secret: $asteriskPassword\r\n\r\n";
socket_write($socket, $loginCommand, strlen($loginCommand));

// Esperar la respuesta del servidor
$response = socket_read($socket, 2048);

// Verificar si la sesión se inició correctamente
if (strpos($response, 'Message: Authentication accepted') !== false) {
    // Enviar el comando Originate para realizar la llamada
    socket_write($socket, $originateCommand, strlen($originateCommand));

    // Esperar la respuesta del servidor
    $response = socket_read($socket, 2048);

    // Verificar el resultado de la llamada
    if (strpos($response, 'Response: Success') !== false) {
        echo "Llamada realizada exitosamente\n";
    } else {
        echo "Error al realizar la llamada: $response\n";
    }
} else {
    echo "Error de autenticación: $response\n";

}

// Cerrar la conexión con el servidor Asterisk
socket_close($socket);
?>




