<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $number = $_POST['number'];
    $host = '149.50.137.240';
    $port = 5038;
    $username = 'crmmyuser';
    $password = 'mypass2025**';
    $extension = '84001'; // La extensión desde la que deseas realizar la llamada

    $socket = fsockopen($host, $port, $errno, $errstr, 30);
    if (!$socket) {
        echo "Error: $errstr ($errno)";
        exit(1);
    }

    fputs($socket, "Action: Login\r\n");
    fputs($socket, "Username: $username\r\n");
    fputs($socket, "Secret: $password\r\n\r\n");

    fputs($socket, "Action: Originate\r\n");
    fputs($socket, "Channel: SIP/$extension\r\n");
    fputs($socket, "Context: from-internal\r\n");
    fputs($socket, "Exten: $number\r\n");
    fputs($socket, "Priority: 1\r\n");
    fputs($socket, "Callerid: $extension\r\n\r\n");

    fputs($socket, "Action: Logoff\r\n\r\n");
    fclose($socket);

    echo "Llamada iniciada a $number desde la extensión $extension";
}
