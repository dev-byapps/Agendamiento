<?php
require_once "../config/conexion.php";
require_once "../models/documentosclientes.php";

$key = "@L1b3lul4*2024*1Nv3sT0r/By4pp5";
$cipher = "aes-256-cbc";
$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));

$documentocli = new Documentosclientes();

switch ($_GET["op"]) {
    //---------------------------------
    case "buscarcategorias":
        $datos = $documentocli->buscarcategoriasdoccli($_POST["perfil"]);
        $html = "";
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $html .= "<option value='" . $row['clasdc_id'] . "'>" . $row['clasdc_nom'] . "</option>";
            }
        }
        echo $html;
        break;

    case "documentosxidcat":
        $iv_dec = substr(base64_decode($_POST["id_cli"]), 0, openssl_cipher_iv_length($cipher));
        $cifradosinIV = substr(base64_decode($_POST["id_cli"]), openssl_cipher_iv_length($cipher));
        $decifrado = openssl_decrypt($cifradosinIV, $cipher, $key, OPENSSL_RAW_DATA, $iv_dec);
        $decifrado = str_replace(['"', "'"], '', $decifrado);
        $decifrado = (int)$decifrado;

        $datos = $documentocli->documentosclixidcat($_POST["idcat"], $_POST["label"], $_POST["usuPerfil"], $decifrado);

        $data = array();

        foreach ($datos as $row) {
            $publicPath = "../../documents/clientes/";
            $carpcli = $row["cli_id"] . "/";
            $ruta = $row["doc_rut"];

            $sub_array = array();
            $sub_array[] = $row["doc_nom"];
            $sub_array[] = '
                <style>
                    .tooltip-image {
                        position: relative;
                        display: inline-block;
                        cursor: pointer;
                    }
                    .tooltip-image img {
                        display: block;
                    }
                    .tooltip-image:hover::after {
                        content: attr(data-tooltip);
                        position: absolute;
                        bottom: 125%; /* Posición del tooltip */
                        left: 50%;
                        transform: translateX(-50%);
                        background-color: #555;
                        color: #fff;
                        text-align: center;
                        border-radius: 5px;
                        padding: 5px 10px;
                        white-space: nowrap;
                        font-size: 12px;
                        opacity: 1;
                        visibility: visible;
                        z-index: 1;
                        transition: opacity 0.3s;
                    }
                    .tooltip-image::after {
                        opacity: 0;
                        visibility: hidden;
                        transition: opacity 0.3s;
                    }
                </style>

                <span class="tooltip-image" data-tooltip="' . htmlspecialchars($row["detu_nom"]) . '">
                    <img src="../../public/img/avatar-2-32.png" alt="' . htmlspecialchars($row["detu_nom"]) . '">
                </span>';
                $sub_array[] = date("d/m/Y", strtotime($row["doc_fecrea"]));

                if ($_POST["usuPerfil"] != "Asesor" && $_POST["usuPerfil"] != "Coordinador" && $_POST["usuPerfil"] != "Asesor/Agente") {

                    $sub_array[] = '
                        <a href="' . htmlspecialchars($publicPath . $carpcli . $ruta) . '" id="' . htmlspecialchars($row["doc_id"]) . '"
                            class="btn btn-inline btn-success btn-sm ladda-button"
                            title="Información"
                            target="_blank">
                            <i class="fa fa-info-circle"></i>
                        </a>

                        <button type="button"
                            onClick="editardoc(' . $row["doc_id"] . ', \'' . $row["doc_nom"] . '\', ' . $row["doc_clas"] . ', ' . $row["clasdc_id"] . ');"
                            id="' . $row["doc_id"] . '" class="btn btn-inline btn-warning btn-sm ladda-button" title="Editar"><i class="fa fa-edit"></i></button>

                        <button type="button" onClick="eliminardoc(' . $row["doc_id"] . ');" id="' . $row["doc_id"] . '" class="btn btn-inline btn-danger btn-sm ladda-button" title="Eliminar documento"><i class="fa fa-trash"></i></button>
                    ';
                } else {
                    $sub_array[] = '
                    <a href="' . htmlspecialchars($publicPath . $carpcli . $ruta) . '" id="' . htmlspecialchars($row["doc_id"]) . '"
                        class="btn btn-inline btn-success btn-sm ladda-button"
                        title="Información"
                        target="_blank">
                        <i class="fa fa-info-circle"></i>
                    </a>
                ';
            }

            $data[] = $sub_array;
        }
        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data,
        );
        echo json_encode($results);
        break;

    case "guardar_titulo":
        $res = $documentocli->guardar_titulo($_POST["idcat"], $_POST["titulo"]);
        echo json_encode($res);
        break;

    case "eliminarcategoria":
        $datos = $documentocli->eliminarcategoria($_POST["idcat"]);
        echo json_encode($datos);
        break;

    case "buscarclasificacion":
        $datos = $documentocli->buscarclasificacion($_POST["perfil"]);
        $html = "";
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $html .= "<option value='" . $row['clasdi_id'] . "'>" . $row['clasdi_nom'] . "</option>";
            }
        }
        echo $html;
        break;

    case "guardaryeditar":
        $iv_dec = substr(base64_decode($_POST["id"]), 0, openssl_cipher_iv_length($cipher));
        $cifradosinIV = substr(base64_decode($_POST["id"]), openssl_cipher_iv_length($cipher));
        $decifrado = openssl_decrypt($cifradosinIV, $cipher, $key, OPENSSL_RAW_DATA, $iv_dec);
        $decifrado = str_replace(['"', "'"], '', $decifrado);
        $decifrado = (int)$decifrado;
        
        if (empty($_POST["doci_id"])) {
            $documentocli->insert_doccliente($decifrado, $_POST["doc_nombre"], $_POST["doc_clas"], $_POST["doc_cat"], $_POST["usu_id"]);
            echo "1";
        } else {
            $documentocli->update_docinterno($_POST["doci_id"], $_POST["doc_nombre"], $_POST["doc_clas"], $_POST["doc_cat"]);
            echo "2";
        }
        break;

    case "eliminardoc":
        $datos = $documentocli->eliminardoc($_POST["iddoc"]);
        echo $datos;
        break;

    case "crearcategoria":
        $datos = $documentocli->crearcategoriadoccli($_POST["nombrecat"], $_POST["clascat"]);
        echo $datos;
        break;

        //---------------------------------

}
