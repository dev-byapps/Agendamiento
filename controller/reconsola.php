<?php
require_once "../config/conexion.php";
require_once "../models/reconsola.php";

$key = "@L1b3lul4*2024*1Nv3sT0r/By4pp5";
$cipher = "aes-256-cbc";
$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));

$reconsola = new Reconsola();

switch ($_GET["op"]) {
  case "registrar":
    $iv_dec = substr(base64_decode($_POST["campid"]), 0, openssl_cipher_iv_length($cipher));
        $cifradosinIV = substr(base64_decode($_POST["campid"]), openssl_cipher_iv_length($cipher));
        $decifrado = openssl_decrypt($cifradosinIV, $cipher, $key, OPENSSL_RAW_DATA, $iv_dec);

    $reconsola->registrar($decifrado, $_POST["detalle"], $_POST["estado"], $_SESSION["usu_id"]);
    echo $decifrado;
    break;
}