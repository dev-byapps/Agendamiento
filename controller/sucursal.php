<?php
require_once "../config/conexion.php";
require_once "../models/sucursal.php";

$sucursal = new Sucursal();

switch ($_GET["op"]) {
    case "guardaryeditarsuc":
        if (empty($_POST["suc_id"])) {
            $sucursal->insert_sucursal($_POST["ent_id"], $_POST["cod_suc"], $_POST["nom_suc"], $_POST["est_suc"], $_POST["dept_suc"], $_POST["city_suc"]);
            echo "1";
        } else {
            $sucursal->update_sucursal($_POST["suc_id"], $_POST["cod_suc"], $_POST["nom_suc"], $_POST["est_suc"], $_POST["dept_suc"], $_POST["city_suc"]);
            echo "2";
        }
        break;

    case "listarsuc":
        $datos = $sucursal->buscar_sucursales($_POST["ent_id"]);
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["suc_cod"];
            $sub_array[] = $row["suc_nom"];
            $sub_array[] = $row["suc_dep"];
            $sub_array[] = $row["suc_ciu"];
            if ($row["suc_est"] == "1") {
                $sub_array[] = '<span class="label label-pill label-success">Activo</span>';
            }
            if ($row["suc_est"] == "2") {
                $sub_array[] = '<span class="label label-pill label-warning">Inactivo</span>';
            }

            $sub_array[] = '<button type="button" onClick="editar(' . $row["suc_id"] . ', \'' . $row["suc_cod"] . '\', \'' . $row["suc_nom"] . '\', \'' . $row["suc_dep"] . '\', \'' . $row["suc_ciu"] . '\', \'' . $row["suc_est"] . '\');" id="' . $row["suc_id"] . '" class="btn btn-inline btn-warning btn-sm ladda-button"><i class="fa fa-edit"></i></button>
            <button type="button" onClick="eliminarestado(' . $row["suc_id"] . ');" id="' . $row["suc_id"] . '" class="btn btn-inline btn-danger btn-sm ladda-button"><i class="fa fa-trash"></i></button>';

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

    case "eliminarsucursal":
        $sucursal->eliminar_sucursal($_POST["suc_id"]);
        break;

    case "listarsucInac":
        $datos = $sucursal->listarsucInac($_POST["ent_id"]);
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["suc_cod"];
            $sub_array[] = $row["suc_nom"];
            $sub_array[] = $row["suc_dep"];
            $sub_array[] = $row["suc_ciu"];
            if ($row["suc_est"] == "1") {
                $sub_array[] = '<span class="label label-pill label-success">Activo</span>';
            }
            if ($row["suc_est"] == "2") {
                $sub_array[] = '<span class="label label-pill label-warning">Inactivo</span>';
            }

            $sub_array[] = '<button type="button" onClick="editar(' . $row["suc_id"] . ', \'' . $row["suc_cod"] . '\', \'' . $row["suc_nom"] . '\', \'' . $row["suc_dep"] . '\', \'' . $row["suc_ciu"] . '\', \'' . $row["suc_est"] . '\');" id="' . $row["suc_id"] . '" class="btn btn-inline btn-warning btn-sm ladda-button"><i class="fa fa-edit"></i></button>';

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

    ///-----------------------

    case "mostrarsucursal":
        $datos = $sucursal->buscarsucursalxid($_POST["suc_id"]);
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $output["suc_id"] = $row["suc_id"];
                $output["suc_cod"] = $row["suc_cod"];
                $output["suc_nom"] = $row["suc_nom"];
                $output["suc_dep"] = $row["suc_dep"];
                $output["suc_ciu"] = $row["suc_ciu"];
                $output["suc_est"] = $row["suc_est"];
            }
            echo json_encode($output);
        }
        break;

    case "sucursales":
        $datos = $sucursal->listar_sucursales($_POST["entidad"]);
        $html = "<option value='0'>Seleccionar...</option>"; // Opción en blanco

        if (is_array($datos) && count($datos) > 0) {
            foreach ($datos as $row) {
                $html .= "<option value='" . $row['suc_id'] . "' data-codigo='" . $row['suc_cod'] . "' data-nombre='" . $row['suc_nom'] . "'>" . $row['suc_cod'] . " - " . $row['suc_nom'] . "</option>";
            }
        }

        echo $html;
        break;
}
