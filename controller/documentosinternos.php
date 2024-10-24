<?php
require_once "../config/conexion.php";
require_once "../models/documentosinternos.php";

$documentointer = new Documentosinternos();

switch ($_GET["op"]) {
    //-----CATEGORIAS-------------
    case "buscarcategorias":
        $datos = $documentointer->buscarcategorias();
        $html = "";
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $html .= "<option value='" . $row['clasdi_id'] . "'>" . $row['clasdi_nom'] . "</option>";
            }
        }
        echo $html;
        break;
    case "crearcategoria":
        $datos = $documentointer->crearcategoria($_POST["nombrecat"]);
        echo $_POST["nombrecat"];
        break;
    case "guardar_titulo":
        $res = $documentointer->guardar_titulo($_POST["idcat"], $_POST["titulo"]);
        echo json_encode($res);
        break;
    case "eliminarcategoria":
        $datos = $documentointer->eliminarcategoria($_POST["idcat"]);
        echo json_encode($datos);
        break;
    //----------------------------
    //-----DOCUMENTOS-------------
    case "documentosxidcat":
        $datos = $documentointer->documentosxidcat($_POST["idcat"], $_POST["label"]);
        $data = array();
        $ruta = '../../documents/docinternos/';
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["doci_nom"];
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
            $sub_array[] = date("d/m/Y", strtotime($row["doci_fecrea"]));
            if ($_SESSION["usu_perfil"] != "Calidad" &&
                $_SESSION["usu_perfil"] != "Operativo" &&
                $_SESSION["usu_perfil"] != "Coordinador" &&
                $_SESSION["usu_perfil"] != "Asesor") {
                $sub_array[] = '
                    <button type="button" onClick="datos(\'' . $ruta . $row["doci_rut"] . '\');" id="' . $row["doci_id"] . '" class="btn btn-inline btn-success btn-sm ladda-button" title="Información"><i class="fa fa-info-circle"></i></button>
                    <button type="button" onClick="editardi(' . $row["doci_id"] . ', \'' . $row["doci_nom"] . '\', ' . $row["clasdi_id"] . ', ' . $row["doci_est"] . ');"  id="' . $row["doci_id"] . '" class="btn btn-inline btn-warning btn-sm ladda-button" title="Editar"><i class="fa fa-edit"></i></button>
                    <button type="button" onClick="eliminar(' . $row["doci_id"] . ');"  id="' . $row["doci_id"] . '" class="btn btn-inline btn-danger btn-sm ladda-button" title="Eliminar"><i class="fa fa-trash"></i></button>';
            } else {
                $sub_array[] = '
                    <button type="button" onClick="datos(\'' . $ruta . $row["doci_rut"] . '\');" id="' . $row["doci_id"] . '" class="btn btn-inline btn-success btn-sm ladda-button" title="Información"><i class="fa fa-info-circle"></i></button>
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
    case "guardaryeditar":
        if (empty($_POST["catid"])) {
            $documentointer->insert_docinterno($_POST["docnom"], $_POST["cat"], $_POST["cat_est"], $_POST["usu_id"]);
            echo "1";
        } else {
            $documentointer->update_docinterno($_POST["catid"], $_POST["docnom"], $_POST["cat"], $_POST["cat_est"]);
            echo "2";
        }
        break;
    case "cambiarestadoeliminado":
        $datos = $documentointer->cambiarestadoeliminado($_POST["doci_id"]);
        echo json_encode($datos);
        break;
        //----------------------------
}
