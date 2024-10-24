<?php
require_once "../config/conexion.php";
require_once "../models/grupoCom.php";

$grupocom = new GrupoCom();

switch ($_GET["op"]) {

    case "admin":
        $datos = $grupocom->get_grupocom();
        if (is_array($datos) == true and count($datos) > 0) {
            $html = "";
            $html .= "<option></option>";
            foreach ($datos as $row) {
                $html .= "<option value='" . $row['gcom_id'] . "'>" . $row['gcom_nom'] . "</option>";
            }
            echo $html;
        }
        break;

    case "usuario":
        $com_id = $_SESSION["usu_grupocom"];
        $datos = $grupocom->get_grupocom_usuario($com_id);
        if (is_array($datos) == true and count($datos) > 0) {
            $html = "";
            foreach ($datos as $row) {
                $html .= "<option value='" . $row['gcom_id'] . "'>" . $row['gcom_nom'] . "</option>";
            }
            echo $html;
        }
        break;

    case "mostrar":
        $datos = $grupocom->get_grupocom_x_id($_POST["com_id"]);
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $output["com_id"] = $row["gcom_id"];
                $output["com_nombre"] = $row["gcom_nom"];
                $output["com_comentario"] = $row["gcom_com"];
                $output["com_estado"] = $row["gcom_est"];
            }
            echo json_encode($output);
        }
        break;

    case "listar":
        $datos = $grupocom->get_grupocom_all();
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["gcom_nom"];
            if ($row["gcom_est"] == "1") {
                $sub_array[] = '<span class="label label-pill label-success">Activo</span>';
            } else {
                $sub_array[] = '<span class="label label-pill label-danger">Inactivo</span>';
            }
            $sub_array[] = '
            <button type="button" onClick="editar(' . $row["gcom_id"] . ');"  id="' . $row["gcom_id"] . '" class="btn btn-inline btn-warning btn-sm ladda-button"><i class="fa fa-edit"></i></button>

            <button type="button" onClick="integrantes(' . $row["gcom_id"] . ', \'' . $row["gcom_nom"] . '\');"  id="' . $row["gcom_id"] . '" class="btn btn-inline btn-info btn-sm ladda-button"><i class="fa fa-users"></i></button>

            <button type="button" onClick="eliminar(' . $row["gcom_id"] . ');"  id="' . $row["gcom_id"] . '" class="btn btn-inline btn-danger btn-sm ladda-button"><i class="fa fa-trash"></i></button>
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

    case "listarInactivos":
        $datos = $grupocom->listar_Inactivos();
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["gcom_nom"];
            if ($row["gcom_est"] == "1") {
                $sub_array[] = '<span class="label label-pill label-success">Activo</span>';
            } else {
                $sub_array[] = '<span class="label label-pill label-danger">Inactivo</span>';
            }
            $sub_array[] = '
                <button type="button" onClick="editar(' . $row["gcom_id"] . ');"  id="' . $row["gcom_id"] . '" class="btn btn-inline btn-warning btn-sm ladda-button"><i class="fa fa-edit"></i></button>
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

    case "guardaryeditar":
        if (empty($_POST["com_id"])) {
            $grupocom->insert_grupocom($_POST["com_nombre"], $_POST["com_comentario"], $_POST["com_estado"]);
            echo "1";
        } else {
            $grupocom->update_grupocom($_POST["com_id"], $_POST["com_nombre"], $_POST["com_comentario"], $_POST["com_estado"]);
            echo "2";
        }
        break;

    case "eliminar":
        $grupocom->delete_grupocom($_POST["com_id"]);
        break;

    case "listarsincom":
        $datos = $grupocom->get_user_sincom();
        $html = "";
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $html .= "<option value='" . $row['usu_id'] . "'>" . $row['detu_nom']." ". $row['detu_ape']. "</option>";
            }
            echo $html;
        }
        break;

    case "mostrarintegrantes":
        $datos = $grupocom->get_integrantes_all($_POST["com_id"]);
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["detu_nom"]." ".$row["detu_ape"];
            $sub_array[] = '<button type="button" onClick="eliminarintegrante(' . $row["usu_id"] . ');"  id="' . $row["usu_id"] . '" class="btn btn-inline btn-danger btn-sm ladda-button"><i class="fa fa-trash"></i></button>';
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

    case "agregarintegrante":
        $grupocom->agregar_integrante($_POST["com_id"], $_POST["usu_id"]);
        break;

    case "eliminarintegrante":
        $grupocom->delete_integrante($_POST["usu_id"]);
        break;
}
