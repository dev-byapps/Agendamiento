<?php
require_once "../config/conexion.php";
require_once "../models/convenio.php";

$convenio = new Convenio();

switch ($_GET["op"]) {

    case "buscarconvenios":
        $datos = $convenio->buscar_convenios($_POST["ent_id"]);
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["con_nom"];
            if ($row["con_est"] == 1) {
                $sub_array[] = '<span class="label label-pill label-success">Activo</span>';
            } else {
                $sub_array[] = '<span class="label label-pill label-danger">Inactivo</span>';
            }
            $sub_array[] = '
             <button type="button" onClick="editar(' . $row["con_id"] . ', \'' . $row["con_nom"] . '\', ' . $row["con_est"] . ');" id="' . $row["con_id"] . '" class="btn btn-inline btn-warning btn-sm ladda-button"><i class="fa fa-edit"></i></button>
            <button type="button" onClick="eliminarestado(' . $row["con_id"] . ');"  id="' . $row["con_id"] . '" class="btn btn-inline btn-danger btn-sm ladda-button"><i class="fa fa-trash"></i></button>';
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

    case "guardaryeditarcon":
        if (empty($_POST["con_id"])) {
            $convenio->insert_convenio(
                $_POST["ent_id"],
                $_POST["nom_conv"],
                $_POST["con_est"]);
            echo "1";
        } else {
            $convenio->update_convenio(
                $_POST["con_id"],
                $_POST["nom_conv"],
                $_POST["con_est"]);
            echo "2";
        }
        break;

    case "eliminarconvenio":
        $convenio->delete_convenio($_POST["idconv"]);
        break;

    case "buscarconveniosInactivos":
        $datos = $convenio->buscarconveniosInactivos($_POST["ent_id"]);
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["con_nom"];
            if ($row["con_est"] == 1) {
                $sub_array[] = '<span class="label label-pill label-success">Activo</span>';
            } else {
                $sub_array[] = '<span class="label label-pill label-danger">Inactivo</span>';
            }
            $sub_array[] = '
                 <button type="button" onClick="editar(' . $row["con_id"] . ', \'' . $row["con_nom"] . '\', ' . $row["con_est"] . ');" id="' . $row["con_id"] . '" class="btn btn-inline btn-warning btn-sm ladda-button"><i class="fa fa-edit"></i></button>
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

    ///------------------------------------

    case "convenios":
        $datos = $convenio->buscar_convenios($_POST["ent_id"]);
        $html = "";
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $html .= "<option value='" . $row['con_id'] . "' data-nombre='" . $row['con_nom'] . "'>" . $row['con_nom'] . "</option>";
            }
            echo $html;
        }
        break;

    case "convenio":
        $datos = $convenio->buscar_conveniosxparam($_POST["term"], $_POST["identidad"]);

        if (is_array($datos) && count($datos) > 0) {
            echo json_encode($datos);
        } else {
            echo json_encode([]);
        }
        break;
}
