<?php
require_once "../config/conexion.php";
require_once "../models/ciudad.php";

$ciudad = new Ciudad();

switch ($_GET["op"]) {
    case "listarciu":
        $datos = $ciudad->listar_ciudades();
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["ciu_nom"];
            $sub_array[] = $row["ciu_dep"];
            if ($row["ciu_est"] == 1) {
                $sub_array[] = '<span class="label label-pill label-success">Activo</span>';
            } else {
                $sub_array[] = '<span class="label label-pill label-danger">Inactivo</span>';
            }
            $sub_array[] = '
            <button type="button" onClick="editar(\'' . $row["ciu_id"] . '\', \'' . $row["ciu_nom"] . '\', \'' . $row["ciu_dep"] . '\', \'' . $row["ciu_est"] . '\');" id="' . $row["ciu_id"] . '" class="btn btn-inline btn-warning btn-sm ladda-button" title="Editar"><i class="glyphicon glyphicon-edit"></i></button>

            <button type="button" onClick="eliminar(' . $row["ciu_id"] . ');"  id="' . $row["ciu_id"] . '" class="btn btn-inline btn-danger btn-sm ladda-button" title="Eliminar"><i class="glyphicon glyphicon-trash"></i></button>';
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

    case "guardaryeditarciu":
        if (empty($_POST["ciu_id"])) {
            $ciudad->insert_ciudad(
                $_POST["ciudad"],
                $_POST["departamento"],
                $_POST["est_ciu"]);
            echo "1";
        } else {
            $ciudad->update_ciudad(
                $_POST["ciu_id"],
                $_POST["ciudad"],
                $_POST["departamento"],
                $_POST["est_ciu"]);
            echo "2";
        }
        break;

    case "eliminarciudad":
        $ciudad->eliminarciudad($_POST["id"]);
        break;

    case "listarciuInac":
        $datos = $ciudad->listarciuInac();
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["ciu_nom"];
            $sub_array[] = $row["ciu_dep"];

            if ($row["ciu_est"] == 1) {
                $sub_array[] = '<span class="label label-pill label-success">Activo</span>';
            } else {
                $sub_array[] = '<span class="label label-pill label-danger">Inactivo</span>';
            }

            $sub_array[] = '
                    <button type="button" onClick="editar(\'' . $row["ciu_id"] . '\', \'' . $row["ciu_nom"] . '\', \'' . $row["ciu_dep"] . '\', \'' . $row["ciu_est"] . '\');" id="' . $row["ciu_id"] . '" class="btn btn-inline btn-warning btn-sm ladda-button" title="Editar"><i class="glyphicon glyphicon-edit"></i></button>';
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

    case "ciudad":
        $datos = $ciudad->buscar_ciudad($_POST["term"]);
        if (is_array($datos) && count($datos) > 0) {
            echo json_encode($datos);
        } else {
            echo json_encode([]);
        }
        break;
}
