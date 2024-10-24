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
