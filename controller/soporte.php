<?php
require_once("../config/conexion.php");
require_once('../models/soporte.php');

$soporte = new Soporte();

switch ($_GET["op"]) {
    case "enviar":
        $res = $soporte->enviar_soporte(
            $_POST["asunto"],
            $_POST["contacto"],
            $_POST["mensaje"],
            $_POST["usu"],
        );
        echo $res;
        break;
}
