<?php
require_once "../config/conexion.php";
require_once "../models/grupocc.php";

$grupocc = new grupocc();

switch ($_GET["op"]) {

    case "guardaryeditar":
        if (empty($_POST["cc_id"])) {
            $grupocc->insert_grupocc($_POST["cc_nombre"], $_POST["cc_comentario"], $_POST["cc_estado"]);
            echo "1";
        } else {
            $grupocc->update_grupocc($_POST["cc_id"], $_POST["cc_nombre"], $_POST["cc_comentario"], $_POST["cc_estado"]);
            echo "2";
        }
        break;

    case "listar":
        $datos = $grupocc->get_grupocc();
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["gcc_nom"];
            if ($row["gcc_est"] == "1") {
                $sub_array[] = '<span class="label label-pill label-success">Activo</span>';
            } else {
                $sub_array[] = '<span class="label label-pill label-danger">Inactivo</span>';
            }
            $sub_array[] = '<button type="button" onClick="editar(\'' . $row["gcc_id"] . '\', \'' . $row["gcc_nom"] . '\', \'' . $row["gcc_com"] . '\', \'' . $row["gcc_est"] . '\');"  id="' . $row["gcc_id"] . '" class="btn btn-inline btn-warning btn-sm ladda-button"><i class="fa fa-edit"></i></button>

            <button type="button" onClick="integrantes(' . $row["gcc_id"] . ', \'' . $row["gcc_nom"] . '\');"  id="' . $row["gcc_id"] . '" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-users"></i></button>

            <button type="button" onClick="eliminar(' . $row["gcc_id"] . ');"  id="' . $row["gcc_id"] . '" class="btn btn-inline btn-danger btn-sm ladda-button"><i class="fa fa-trash"></i></button>
            ';
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

    case "eliminar":
        $grupocc->delete_grupocc($_POST["cc_id"]);
        break;

    case "listarInactivos":
        $datos = $grupocc->get_grupocc_Inactivos();
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["gcc_nom"];
            if ($row["gcc_est"] == "1") {
                $sub_array[] = '<span class="label label-pill label-success">Activo</span>';
            } else {
                $sub_array[] = '<span class="label label-pill label-danger">Inactivo</span>';
            }
            $sub_array[] = '
                <button type="button" onClick="editar(\'' . $row["gcc_id"] . '\', \'' . $row["gcc_nom"] . '\', \'' . $row["gcc_com"] . '\', \'' . $row["gcc_est"] . '\');"  id="' . $row["gcc_id"] . '" class="btn btn-inline btn-warning btn-sm ladda-button"><i class="fa fa-edit"></i></button>
                ';
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

    case "listarsincc":
        $datos = $grupocc->get_user_sincc($_POST["cc_id"]);
        $html = "";
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $html .= "<option value='" . $row['usu_id'] . "'>" . $row['detu_nom'] ." ". $row['detu_ape'] . "</option>";
            }
            echo $html;
        }
        break;

    case "mostrarintegrantes":
            $datos = $grupocc->get_integrantes_all($_POST["cc_id"]);
            $data = array();
        
            foreach ($datos as $row) {
                $sub_array = array();
                $sub_array[] = $row["detu_nom"] . " " . $row["detu_ape"]; // Concatenación adecuada de nombres
                $sub_array[] = '<button type="button" onClick="eliminarintegrante(' . $row["usucc_id"] . ', ' . $_POST["cc_id"] . ');" id="' . $row["usucc_id"] . '" class="btn btn-inline btn-danger btn-sm ladda-button"><i class="fa fa-trash"></i></button>'; // Agregada la coma para separar los parámetros
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
        

    case "eliminarintegrante":
        $grupocc->delete_integrante($_POST["usucc_id"]);
        break;

    case "agregarintegrante":
        $grupocc->agregar_integrante($_POST["usu_id"], $_POST["cc_id"]);
        break;

    case "get":
        $datos = $grupocc->get_grupocc();
        if (is_array($datos) == true and count($datos) > 0) {
            $html = "";

            foreach ($datos as $row) {
                $html .= "<option value='" . $row['gcc_id'] . "'>" . $row['gcc_nom'] . "</option>";
            }
            echo $html;
        }
        break;
    case "mostrarintegrantescc":
        $datos = $grupocc->integrantescc($_POST["grupo"]);
            if (is_array($datos) == true and count($datos) > 0) {
                $html = "";
                $html .= "<option></option>";
                foreach ($datos as $row) {
                    $html .= "<option value='" . $row['usu_id'] . "'>" . $row['detu_nom'] ." ". $row['detu_ape'] . "</option>";
                }
                echo $html;
            }
            break;


    //----------------------------

    case "mostrar": //ok***********
        $datos = $grupocc->get_grupocc_x_id($_POST["cc_id"]);
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $output["cc_id"] = $row["gcc_id"];
                $output["cc_nombre"] = $row["gcc_nom"];
                $output["cc_comentario"] = $row["gcc_com"];
                $output["cc_estado"] = $row["gcc_est"];
            }
            echo json_encode($output);
        }
        break;

}
