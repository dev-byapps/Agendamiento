<?php
require_once "../config/conexion.php";
require_once "../models/entidad.php";

$entidad = new Entidad();

switch ($_GET["op"]) {

    case "guardaryeditar":
        if (empty($_POST["ent_id"])) {
            $entidad->insert_entidad($_POST["ent_nombre"], $_POST["ent_coment"], $_POST["ent_estado"]);
            echo "1";
        } else {
            $entidad->update_entidad($_POST["ent_id"], $_POST["ent_nombre"], $_POST["ent_coment"], $_POST["ent_estado"]);
            echo "2";
        }
        break;

    case "listar":
        $datos = $entidad->get_entidad_all();
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["ent_nom"];
            if ($row["ent_est"] == 1) {
                $sub_array[] = '<span class="label label-pill label-success">Activo</span>';
            } else {
                $sub_array[] = '<span class="label label-pill label-danger">Inactivo</span>';
            }
            $sub_array[] = '
            <button type="button" onClick="editar(\'' . $row["ent_id"] . '\', \'' . $row["ent_nom"] . '\', \'' . $row["ent_est"] . '\', \'' . $row["ent_com"] . '\');" id="' . $row["ent_id"] . '" class="btn btn-inline btn-warning btn-sm ladda-button" title="Editar"><i class="glyphicon glyphicon-edit"></i></button>

            <button type="button" onClick="estados(' . $row["ent_id"] . ', \'' . $row["ent_nom"] . '\');"  id="' . $row["ent_id"] . '" class="btn btn-inline btn-primary btn-sm ladda-button" title="Estados"><i class="glyphicon glyphicon-check"></i>
            </button>
            
            <button type="button" onClick="convenios(' . $row["ent_id"] . ', \'' . $row["ent_nom"] . '\');"  id="' . $row["ent_id"] . '" class="btn btn-inline btn-success btn-sm ladda-button" title="Convenios"><i class="glyphicon glyphicon-briefcase"></i>
            </button>
            
            <button type="button" onClick="sucursales(' . $row["ent_id"] . ', \'' . $row["ent_nom"] . '\');"  id="' . $row["ent_id"] . '" class="btn btn-inline btn-info btn-sm ladda-button" title="Sucursales"><i class="glyphicon glyphicon-menu-hamburger"></i>
            </button>
            
            <button type="button" onClick="eliminar(' . $row["ent_id"] . ');"  id="' . $row["ent_id"] . '" class="btn btn-inline btn-danger btn-sm ladda-button" title="Eliminar"><i class="glyphicon glyphicon-trash"></i></button>
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
        $entidad->delete_entidad($_POST["ent_id"]);
        break;

    case "listarInactivos":
        $datos = $entidad->listarInactivos();
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["ent_nom"];
            if ($row["ent_est"] == 1) {
                $sub_array[] = '<span class="label label-pill label-success">Activo</span>';
            } else {
                $sub_array[] = '<span class="label label-pill label-danger">Inactivo</span>';
            }
            $sub_array[] = '
                <button type="button" onClick="editar(\'' . $row["ent_id"] . '\', \'' . $row["ent_nom"] . '\', \'' . $row["ent_est"] . '\', \'' . $row["ent_com"] . '\');" id="' . $row["ent_id"] . '" class="btn btn-inline btn-warning btn-sm ladda-button" title="Editar"><i class="glyphicon glyphicon-edit"></i></button>';
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

    //--------------------------****

    case "comboent":
        $datos = $entidad->get_entidad();
        $html = "";
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $html .= "<option value='" . $row['ent_id'] . "' data-nombre='" . $row['ent_nom'] . "'>" . $row['ent_nom'] . "</option>";
            }
            echo $html;
        }
        break;


    case "mostrar":
        $datos = $entidad->get_entidad_x_id($_POST["ent_id"]);
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $output["ent_id"] = $row["ent_id"];
                $output["ent_nombre"] = $row["ent_nom"];
                $output["ent_coment"] = $row["ent_com"];
                $output["ent_estado"] = $row["ent_est"];
            }
            echo json_encode($output);
        }
        break;

    case "identidad":
        $datos = $entidad->identidad($_POST["entidad"]);
        echo json_encode($datos);
        break;
}
