<?php
require_once "../config/conexion.php";
require_once "../models/estadosent.php";

$estadosent = new Estadosent();

switch ($_GET["op"]) {

    case "guardaryeditarestado":
        if (empty($_POST["est_id"])) {
            $estadosent->insert_estado($_POST["ent_id"], $_POST["est_ent"], $_POST["est_crm"]);
            echo "1";
        } else {
            $estadosent->update_estado($_POST["est_id"], $_POST["est_ent"], $_POST["est_crm"]);
            echo "2";
        }
        break;

    case "listarestados":
        $datos = $estadosent->get_estado_all($_POST["ent_id"]);
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["estent_est"];
            if ($row["estent_estcrm"] == "Radicacion") {
                $sub_array[] = '<span class="label label-pill label-success">Radicación</span>';
            }
            if ($row["estent_estcrm"] == "Devolucion") {
                $sub_array[] = '<span class="label label-pill label-warning">Devolucion</span>';
            }
            if ($row["estent_estcrm"] == "Negado") {
                $sub_array[] = '<span class="label label-pill label-danger">Negado</span>';
            }
            if ($row["estent_estcrm"] == "Desembolsado") {
                $sub_array[] = '<span class="label label-pill label-primary">Desembolsado</span>';
            }
            if ($row["estent_estcrm"] == "Proceso") {
                $sub_array[] = '<span class="label label-pill label-info">Proceso</span>';
            }

            $sub_array[] = '
            <button type="button" onClick="editar(\'' . $row["estent_id"] . '\', \'' . $row["estent_est"] . '\', \'' . $row["estent_estcrm"] . '\', \'' . $row["estent_estado"] . '\');" id="' . $row["ent_id"] . '" class="btn btn-inline btn-warning btn-sm ladda-button" title="Editar"><i class="glyphicon glyphicon-edit"></i></button>

            <button type="button" onClick="eliminarestado(' . $row["estent_id"] . ');"  id="' . $row["estent_id"] . '" class="btn btn-inline btn-danger btn-sm ladda-button"><i class="fa fa-trash"></i></button>';

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

    case "eliminarestado":
        $estadosent->delete_estado($_POST["est_id"]);
        break;

    case "listarInactivos":
        $datos = $estadosent->listar_inactivos($_POST["ent_id"]);
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["estent_est"];
            if ($row["estent_estcrm"] == "Radicacion") {
                $sub_array[] = '<span class="label label-pill label-success">Radicación</span>';
            }
            if ($row["estent_estcrm"] == "Devolucion") {
                $sub_array[] = '<span class="label label-pill label-warning">Devolucion</span>';
            }
            if ($row["estent_estcrm"] == "Negado") {
                $sub_array[] = '<span class="label label-pill label-danger">Negado</span>';
            }
            if ($row["estent_estcrm"] == "Desembolsado") {
                $sub_array[] = '<span class="label label-pill label-primary">Desembolsado</span>';
            }
            if ($row["estent_estcrm"] == "Proceso") {
                $sub_array[] = '<span class="label label-pill label-info">Proceso</span>';
            }
            
            $sub_array[] = '<button type="button" onClick="activar(\'' . $row["estent_id"] . '\');" id="' . $row["estent_id"] . '" class="btn btn-inline btn-danger btn-sm ladda-button"><i class="fa fa-edit"></i></button>';

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

    case "activar":
        $estadosent->activar($_POST["estent_id"]);
        break;

    //---------------------------

    case "mostrarestado":
        $datos = $estadosent->get_estado_x_id($_POST["est_id"]);
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $output["est_id"] = $row["estent_id"];
                $output["ent_id"] = $row["ent_id"];
                $output["est_ent"] = $row["estent_est"];
                $output["est_crm"] = $row["estent_estcrm"];
            }
            echo json_encode($output);
        }
        break;

    case "estadosradicadosxentidad":
        $datos = $estadosent->estadosradicadosxentidad($_POST["entidad"]);
        $html = "";
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $html .= "<option value='" . $row['estent_est'] . "' data-nombre='" . $row['estent_est'] . "' data-crm='" . $row['estent_estcrm'] . "'>" . $row['estent_est'] . "</option>";
            }
            echo $html;
        }
        break;

    case "obtenerestadoCRM":
        $datos = $estadosent->obtenerestadoCRM($_POST["estado"], $_POST["entidad"]);
        echo json_encode($datos);
        break;

    case "estadoxentidad":
        $datos = $estadosent->estadoxentidad($_POST["entidad"]);
        $html = "";
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $html .= "<option value='" . $row['estent_est'] . "' data-nombre='" . $row['estent_est'] . "' data-crm='" . $row['estent_estcrm'] . "'>" . $row['estent_est'] . "</option>";
            }
            echo $html;
        }
        break;

    case "obtenerestado":
        $datos = $estadosent->obtenerestado($_POST["estado"], $_POST["entidad"]);
        echo json_encode($datos);
        break;
}
