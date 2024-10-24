<?php
require_once "../config/conexion.php";
require_once "../models/comunicados.php";

$comunicados = new Comunicados();

switch ($_GET["op"]) {

    case "numero_comeninternos":
        $res = $comunicados->numero_comeninternos();
        echo json_encode($res);
        break;

    case "comunicadosInternos":
        $datos = $comunicados->comunicadosInternos();
        $html = '';
        if (!empty($datos)) {
            foreach ($datos as $dato) {
                // Convertir la fecha al formato yyyy/mm/dd
                $fechaOriginal = $dato['comi_fecrea'];
                $fechaFormateada = DateTime::createFromFormat('Y-m-d', $fechaOriginal)->format('d/m/Y');
                $html .= '<article class="contact-row">
                                            <div class="user-card-row">
                                                <div class="tbl-row">
                                                    <div class="tbl-cell tbl-cell-photo">
                                                        <a href="#" onclick="btcomunicado(event, \'' . $dato['comi_id'] . '\')">
                                                            <img src="../../public/img/post-user-' . $dato['comi_clas'] . '.png" style="border-radius: 15%;" alt="">
                                                        </a>
                                                    </div>
                                                    <div class="tbl-cell">
                                                        <p class="user-card-row-name">' . $dato['comi_asun'] . '</p>
                                                        <p class="user-card-row-mail">' . $dato['detu_nom'] . '</p>
                                                    </div>
                                                    <div class="tbl-cell tbl-cell-date">' . $fechaFormateada . '</div>
                                                </div>
                                            </div>
                                        </article>';
            }
        } else {
            error_log('No data retrieved from the stored procedure.');
        }
        echo json_encode($html);
        break;

    case "detallecomunicadosInternos":
        $res = $comunicados->detallecomunicadosInternos($_POST['id_com']);
        echo json_encode($res);
        break;

    case "vencido":
        $comunicados->vencido();
        break;

    //-------------------------

    case "buscarcomunicadosInternos":
        if ($_POST['perfil'] == "Asesor" || $_POST['perfil'] == "Coordinador") {
            $datos = $comunicados->buscarcomunicadosInternos();
        } else {
            $datos = $comunicados->buscarcomunicados();
        }

        $data = array();
        foreach ($datos as $row) {
            $ruta = '../../documents/comunicados/' . $row["comi_rut"];

            $sub_array = array();
            $sub_array[] = $row["comi_asun"];
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
            if ($row["comi_clas"] == "1") {
                $sub_array[] = '<span class="label label-pill label-success">Bajo</span>';
            } else if ($row["comi_clas"] == "2") {
                $sub_array[] = '<span class="label label-pill label-defaultd">Medio</span>';
            } else {
                $sub_array[] = '<span class="label label-pill label-danger">Alto</span>';
            }
            $fecrea = date("d/m/Y", strtotime($row["comi_fecrea"]));
            $fefin = date("d/m/Y", strtotime($row["comi_fefin"]));
            $sub_array[] = $fecrea;
            $sub_array[] = $fefin;

            if ($row["comi_est"] == "1") {
                $sub_array[] = '<span class="label label-pill label-success">Activo</span>';
            } else {
                $sub_array[] = '<span class="label label-pill label-danger">Inactivo</span>';
            }
            $det_escapado = htmlspecialchars($row["comi_det"], ENT_QUOTES, 'UTF-8');
            $det_codificado = urlencode($row["comi_det"]);

            if ($_SESSION["usu_perfil"] != "Calidad" &&
                $_SESSION["usu_perfil"] != "Operativo" &&
                $_SESSION["usu_perfil"] != "Coordinador" &&
                $_SESSION["usu_perfil"] != "Asesor") {
                $sub_array[] = '
                    <button type="button" onClick="datos(\'' . $ruta . '\', \'' . $det_codificado . '\', \'' . $row["comi_asun"] . '\');" id="' . $row["comi_id"] . '" class="btn btn-inline btn-success btn-sm ladda-button" title="Información"><i class="fa fa-info-circle"></i></button>

                    <button type="button" onClick="editar(\'' . $row["comi_id"] . '\', \'' . $det_codificado . '\', \'' . $row["comi_asun"] . '\', \'' . $row["comi_clas"] . '\', \'' . $fefin . '\', \'' . $row["comi_est"] . '\');" id="' . $row["comi_id"] . '" class="btn btn-inline btn-warning btn-sm ladda-button" title="Editar"><i class="fa fa-edit"></i></button>

                    <button type="button" onClick="eliminar(' . $row["comi_id"] . ');" id="' . $row["comi_id"] . '" class="btn btn-inline btn-danger btn-sm ladda-button" title="Eliminar"><i class="fa fa-trash"></i></button>';

            } else {
                $sub_array[] = '
                <button type="button" onClick="datos(\'' . $ruta . '\', \'' . $det_codificado . '\', \'' . $row["comi_asun"] . '\');" id="' . $row["comi_id"] . '" class="btn btn-inline btn-success btn-sm ladda-button" title="Información"><i class="fa fa-info-circle"></i></button>
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
        $fecha = $_POST['com_fcierre'];
        $fechaven = DateTime::createFromFormat('d/m/Y', $fecha);
        $fechaven = $fechaven->format('Y-m-d');

        if (empty($_POST["com_id"])) {
            $comunicados->insert_comunicado($_POST["com_asunto"], $_POST["com_clas"], $fechaven, $_POST["com_estado"], $_POST["com_coment"], $_POST["usu_id"]);
            echo "1";
        } else {
            $comunicados->update_comunicado($_POST["com_id"], $_POST["com_asunto"], $_POST["com_coment"], $_POST["com_clas"], $_POST["usu_id"], $fechaven, $_POST["com_estado"]);
            echo "2";
        }
        break;

    case "cambiarestadoeliminado":
        $datos = $comunicados->cambiarestadoeliminado($_POST["comid"]);
        echo json_encode($datos);
        break;

        //------------------------------

}
