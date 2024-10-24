El código PHP que has proporcionado está diseñado para colgar una llamada en una extensión específica en Asterisk utilizando la interfaz AMI. Sin embargo, hay algunas correcciones y mejoras que se pueden realizar para asegurarse de que el comando para colgar la llamada funcione correctamente.

Correcciones y Mejoras
Eliminar el Contexto: En la acción Hangup, no es necesario especificar el contexto, solo el canal.
Manejo de Respuestas: Es importante manejar las respuestas de AMI y asegurarse de que el comando Hangup se ejecute correctamente.
Estructura del Mensaje: Asegúrate de que el mensaje esté bien estructurado y separado por líneas.
Código PHP Mejorado
php
Copiar código
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $extension = $_POST['extension'];
    $host = '149.50.137.240';
    $port = 5038;
    $username = 'crmmyuser';
    $password = 'mypass2025**';

    $socket = fsockopen($host, $port, $errno, $errstr, 30);
    if (!$socket) {
        echo "Error: $errstr ($errno)";
        exit(1);
    }

    // Login
    fputs($socket, "Action: Login\r\n");
    fputs($socket, "Username: $username\r\n");
    fputs($socket, "Secret: $password\r\n\r\n");

    // Hangup
    fputs($socket, "Action: Hangup\r\n");
    fputs($socket, "Channel: SIP/$extension\r\n\r\n");

    // Logoff
    fputs($socket, "Action: Logoff\r\n\r\n");

    fclose($socket);

    echo "Llamada colgada para la extensión $extension";
}
?>
HTML y JavaScript para Interactuar con el PHP
Aquí está el HTML y JavaScript que puedes usar para enviar una solicitud al script PHP y colgar la llamada:

html
Copiar código
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Colgar Llamada</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        input,
        button {
            margin: 10px 0;
            padding: 10px;
        }

        #result {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <h1>Colgar Llamada desde Extensión</h1>
    <input type="text" id="extension" placeholder="Ingrese la extensión">
    <button id="hangupButton">Colgar Llamada</button>
    <div id="result"></div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#hangupButton').on('click', function() {
                var extension = $('#extension').val();
                $.ajax({
                    url: 'hangup.php',
                    type: 'POST',
                    data: {
                        extension: extension
                    },
                    success: function(response) {
                        $('#result').html(response);
                    },
                    error: function(xhr, status, error) {
                        $('#result').html('Error: ' + error);
                    }
                });
            });
        });
    </script>
</body>

</html>