<?php
require_once "../config/conexion.php";
require_once "../models/documentospersonales.php";

$documentoper = new Documentospersonales();

switch ($_GET["op"]) {
    //----------CATEGORIAS------------

    case "buscarcategorias":
        $datos = $documentoper->buscarcategoriasper();
        $html = "";
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $html .= "<option value='" . $row['clasdp_id'] . "'>" . $row['clasdp_nom'] . "</option>";
            }
        }
        echo $html;
        break;
    case "crearcategoria":
        $datos = $documentoper->crearcategoria($_POST["nombrecat"]);
        echo $_POST["nombrecat"];
        break;
    case "guardar_titulo":
        $res = $documentoper->guardar_titulo($_POST["idcat"], $_POST["titulo"]);
        echo json_encode($res);
        break;
    case "eliminarcategoria":
        $datos = $documentoper->eliminarcategoria($_POST["idcat"]);
        echo json_encode($datos);
        break;
    //--------------------------------
    //----------DOCUMENTOS------------
    case "documentosxidcat":
        $datos = $documentoper->documentosxidcat($_POST["idcat"], $_POST["label"], $_POST['usu'], $_SESSION['usu_perfil']);
        $data = array();
        $ruta = '../../documents/docpersonales/' . $_POST['usu'] . '/';
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["docper_nom"];
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
        <span class="tooltip-image" data-tooltip="' . htmlspecialchars($row["detu_nom"]) ." ".$row["detu_ape"] .'">
            <img src="../../public/img/avatar-2-32.png" alt="' . htmlspecialchars($row["detu_nom"]) ." ".$row["detu_ape"]. '">
        </span>';
            $sub_array[] = date("d/m/Y", strtotime($row["docper_fecrea"]));
            $sub_array[] = '
            <button type="button" onClick="datos(\'' . $ruta . $row["docper_rut"] . '\');" id="' . $row["docper_id"] . '" class="btn btn-inline btn-success btn-sm ladda-button" title="Información"><i class="fa fa-info-circle"></i></button>

            <button type="button" onClick="editardi(' . $row["docper_id"] . ', \'' . $row["docper_nom"] . '\', ' . $row["clasdp_id"] . ', ' . $row["docper_est"] . ');" id="' . $row["docper_id"] . '" class="btn btn-inline btn-warning btn-sm ladda-button" title="Editar"><i class="fa fa-edit"></i></button>

            <button type="button" onClick="eliminar(' . $row["docper_id"] . ');" id="' . $row["docper_id"] . '" class="btn btn-inline btn-danger btn-sm ladda-button" title="Eliminar"><i class="fa fa-trash"></i></button>';
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
            $documentoper->insert_docpersonal($_POST["docnom"], $_POST["cat"], $_POST["cat_est"], $_POST["usu_id"], $_POST["creado"]);
            echo "1";
        } else {
            $documentoper->update_docpersonal($_POST["catid"], $_POST["docnom"], $_POST["cat"], $_POST["cat_est"]);
            echo "2";
        }
        break;
    case "cambiarestadoeliminado":
        $datos = $documentoper->cambiarestadoeliminado($_POST["doci_id"]);
        echo json_encode($datos);
        break;

        //--------------------------------
}
