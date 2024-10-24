<?php
require_once "../config/conexion.php";
require_once "../models/sip.php";

$key = "@L1b3lul4*2024*1Nv3sT0r/By4pp5";
$cipher = "aes-256-cbc";
$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));

$sip = new SIP();

switch ($_GET["op"]) {

    case "dsip":
        try {
            $resultado = $sip->dsip($_SESSION["usu_id"]);
            echo json_encode([
                "status" => "success",
                "data" => $resultado
            ]);
        } catch (Exception $e) {
            echo json_encode([
                "status" => "error",
                "message" => $e->getMessage()
            ]);
        }
    break;

    }