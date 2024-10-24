<?php

use Seld\JsonLint\Undefined;

require_once "../config/conexion.php";
require_once "../models/usuario.php";
require_once "../models/entidad.php";

$usuario = new Usuario();
$entidad = new Entidad();

switch ($_GET["op"]) {

    case "listar":
        $datos = $usuario->get_usuario();
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["usu_usu"];
            $sub_array[] = $row["detu_nom"]." ".$row['detu_ape'];
            $sub_array[] = $row["usu_per"];
            if ($row["usu_est"] == "1") {
                $sub_array[] = '<span class="label label-pill label-success">Activo</span>';
            } else {
                $sub_array[] = '<span class="label label-pill label-danger">Inactivo</span>';
            }


            // fecha Ingreso
            if ($row["detu_feing"] != "" && $row["detu_feing"] != null) {
                $feing = $row["detu_feing"];
                $formatted_feing = date("d/m/Y", strtotime($feing));
            } else {
                $formatted_feing = "";
            }

            // fecha Retiro
            if ($row["detu_feret"] != "" && $row["detu_feret"] != null) {
                $feret = $row["detu_feret"];
                $formatted_feret = date("d/m/Y", strtotime($feret));
            } else {
                $formatted_feret = "";
            }
            
            $sub_array[] = '
                <button type="button" onClick="editar(' . 
                $row["usu_id"] . ', \'' . 
                $row["usu_usu"] . '\', \'' . 
                $row["usu_pass"] . '\', \'' . 
                $row["usu_per"] . '\', \'' . 
                $row["usu_est"] . '\', \'' . 
                $row["detu_tip"] . '\', \'' . 
                $row["detu_doc"] . '\', \'' . 
                $row["detu_nom"] . '\', \'' . 
                $row["detu_ape"] . '\', \'' . 
                $row["detu_cor"] . '\', \'' . 
                $row["detu_car"] . '\', \'' . 
                $row["detu_tcon"] . '\', \'' . 
                $row["gcom_id"] . '\', \'' . 
                $formatted_feing . '\', \'' . 
                $formatted_feret . '\');" id="' . $row["usu_id"] . '" class="btn btn-inline btn-warning btn-sm ladda-button"><i class="fa fa-edit"></i></button>

                <button type="button" onClick="datos(' . $row["usu_id"] . ');" id="' . $row["usu_id"] . '" class="btn btn-inline btn-success btn-sm ladda-button" title="Información"><i class="fa fa-info-circle"></i></button>

                <button type="button" onClick="sip(' . $row["usu_id"] . ');" id="' . $row["usu_id"] . '" class="btn btn-inline btn-secondary btn-sm ladda-button" title="SIP"><i class="fa fa-phone"></i></button>

                <button type="button" onClick="eliminar(' . $row["usu_id"] . ');" id="' . $row["usu_id"] . '" class="btn btn-inline btn-danger btn-sm ladda-button" title="Eliminar"><i class="fa fa-trash"></i></button>
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

    case 'admin':
        $html = "";
        $datos = $usuario->get_usu();
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $html .= "<option value='" . $row['usu_id'] . "'>" . $row['detu_nom'] ." ".$row['detu_ape']. "</option>";
            }
            echo $html;
        }
        break;
    // COMBO ASESOR CUANDO ES ADMIN Y/O OPERATIVO
    case 'combo_asesoradmin':
        $html = "";
        $datos = $usuario->combo_asesoradmin();
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $html .= "<option value='" . $row['usu_id'] . "'>" . $row['detu_nom'] ." ".$row['detu_ape']. "</option>";
            }
            echo $html;
        }
        break;
    // COMBO AGENTE CUANDO ES ADMIN Y/O OPERATIVO
    case 'combo_agenteadmin':
        $html = "";
        $datos = $usuario->combo_agenteadmin();
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $html .= "<option value='" . $row['usu_id'] . "'>" . $row['detu_nom'] ." ".$row['detu_ape']. "</option>";
            }
            echo $html;
        }
        break;
    // COMBO AGENTE CUANDO ES ADMIN Y/O OPERATIVO
    case 'combo_agente':
        $html = "";
        $datos = $usuario->combo_agente();
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $html .= "<option value='" . $row['usu_id'] . "'>" . $row['detu_nom'] ." ".$row['detu_ape']. "</option>";
            }
            echo $html;
        }
        break;
    case 'adminselect':
        $datos = $usuario->get_usuterm($_POST["term"],$_POST["usuPerfil"], $_SESSION["usu_id"]);
        if (is_array($datos) && count($datos) > 0) {
            echo json_encode($datos);
        }else {
            echo json_encode([]);
        }
        break;

    case "nousurep":
        $res = $usuario->nousurep($_POST["usuario"]);
        echo json_encode($res);
        break;

    case "guardaryeditar":
        if (empty($_POST["tar_fingreso"])) {
            $formatted_ingreso = null;
        } else {
            $date = $_POST["tar_fingreso"];
            $formatted_ingreso = DateTime::createFromFormat('d/m/Y', $date);
            $formatted_ingreso = $formatted_ingreso ? $formatted_ingreso->format('Y-m-d') : null;
        }

        if (empty($_POST["usu_feretiro"])) {
            $formatted_retiro = null;
        } else {
            $date2 = $_POST["usu_feretiro"];
            $formatted_retiro = DateTime::createFromFormat('d/m/Y', $date2);
            $formatted_retiro = $formatted_retiro ? $formatted_retiro->format('Y-m-d') : null;
        }

        if (empty($_POST["usu_grupocom"])) {
            $gcom = "0";
        } else {
            $gcom = $_POST["usu_grupocom"];
        }

        if (empty($_POST["usu_fenac"])) {
            $formatted_fenac = null;
        } else {
            $date = $_POST["usu_fenac"];
            $formatted_fenac = DateTime::createFromFormat('d/m/Y', $date);
            $formatted_fenac = $formatted_fenac ? $formatted_fenac->format('Y-m-d') : null;
        }

        if (empty($_POST["usu_id"]) && empty($_POST["usuid"])) {
            $usuario->insert_usuario(
                $_POST["usu_user"],
                $_POST["usu_pass"],
                $_POST["usu_perfil"],
                $_POST["usu_est"],
                $_POST["usu_tipodoc"],
                $_POST["usu_cc"],
                $_POST["usu_nom"],
                $_POST["usu_ape"],
                $_POST["usu_mail"],
                $_POST["usu_car"],
                $_POST["usu_tipcontrato"],
                $gcom,
                $formatted_ingreso,
                $formatted_retiro
            );
            echo "1";
        } else {
            if (empty($_POST["usuid"])) {
                $usuario->update_usuario(
                    $_POST["usu_id"],
                    $_POST["usu_user"],
                    $_POST["usu_pass"],
                    $_POST["usu_perfil"],
                    $_POST["usu_est"],
                    $_POST["usu_tipodoc"],
                    $_POST["usu_cc"],
                    $_POST["usu_nom"],
                    $_POST["usu_ape"],
                    $_POST["usu_mail"],
                    $_POST["usu_car"],
                    $_POST["usu_tipcontrato"],
                    $gcom,
                    $formatted_ingreso,
                    $formatted_retiro
                );
                echo "2";
            } else {
                $usuario->update_detusuario(
                    $_POST["usuid"],
                    $formatted_fenac,
                    $_POST["usu_tel"],
                    $_POST["usu_cel"],
                    $_POST["usu_dir"],
                    $_POST["usu_ciu"],
                    $_POST["usu_dep"]
                );
                echo "3";
            }
        }
        break;

    case "mostrar":
        $datos = $usuario->get_usuario_x_id($_POST["usu_id"]);
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $output["usu_id"] = $row["usu_id"];
                $output["usu_user"] = $row["usu_usu"];
                $output["usu_pass"] = $row["usu_pass"];
                $output["usu_per"] = $row["usu_per"];
                $output["usu_est"] = $row["usu_est"];
                $output["usu_tipocc"] = $row["detu_tip"];
                $output["usu_cc"] = $row["detu_doc"];
                $output["usu_nom"] = $row["detu_nom"]." ".$row['detu_ape'];
                $output["detu_cor"] = $row["detu_cor"];
                $output["detu_car"] = $row["detu_car"];
                $output["gcom_id"] = $row["gcom_id"];
                $output["usu_ape"] = $row["detu_ape"];
                $output["tipo_contrato"] = $row["detu_tcon"];
                // fecha nacimiento
                if ($row["detu_fenac"] != "" && $row["detu_fenac"] != null) {
                    $datenac = $row["detu_fenac"];
                    $formatted_datenac = date("d/m/Y", strtotime($datenac));
                } else {
                    $formatted_datenac = "";
                }
                $output["fecha_nac"] = $formatted_datenac;
                // fecha ingreso
                if ($row["detu_feing"] != "" && $row["detu_feing"] != null) {
                    $date = $row["detu_feing"];
                    $formatted_date = date("d/m/Y", strtotime($date));
                } else {
                    $formatted_date = "";
                }
                $output["detu_feing"] = $formatted_date;

                if ($row["detu_feret"] != "" && $row["detu_feret"] != null) {
                    $date = $row["detu_feret"];
                    $formatted_date = date("d/m/Y", strtotime($date));
                } else {
                    $formatted_date = "";
                }
                $output["detu_feret"] = $formatted_date;

                $output["detu_tel"] = $row["detu_tel"];
                $output["detu_cel"] = $row["detu_cel"];
                $output["detu_dir"] = $row["detu_dir"];
                $output["detu_ciu"] = $row["detu_ciu"];
                $output["detu_dep"] = $row["detu_dep"];
            }
            echo json_encode($output);
        }
        break;

    case "eliminar":
        $usuario->delete_usuario($_POST["usu_id"]);
        break;

    case "listarInactivos":
        $datos = $usuario->get_usuarioInac();
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["usu_usu"];
            $sub_array[] = $row["detu_nom"]." ".$row['detu_ape'];
            $sub_array[] = $row["usu_per"];
            if ($row["usu_est"] == "1") {
                $sub_array[] = '<span class="label label-pill label-success">Activo</span>';
            } else {
                $sub_array[] = '<span class="label label-pill label-danger">Inactivo</span>';
            }

            // fecha Ingreso
            if ($row["detu_feing"] != "" && $row["detu_feing"] != null) {
                $feing = $row["detu_feing"];
                $formatted_feing = date("d/m/Y", strtotime($feing));
            } else {
                $formatted_feing = "";
            }

            // fecha Retiro
            if ($row["detu_feret"] != "" && $row["detu_feret"] != null) {
                $feret = $row["detu_feret"];
                $formatted_feret = date("d/m/Y", strtotime($feret));
            } else {
                $formatted_feret = "";
            }
            
            $sub_array[] = '
                    <button type="button" onClick="editar(' . $row["usu_id"] . ', \'' . $row["usu_usu"] . '\', \'' . $row["usu_pass"] . '\', \'' . $row["usu_per"] . '\', \'' . $row["usu_est"] . '\', \'' . $row["detu_tip"] . '\', \'' . $row["detu_doc"] . '\', \'' . $row["detu_nom"] . '\', \'' . $row["detu_ape"] . '\', \'' . $row["detu_cor"] . '\', \'' . $row["detu_car"] . '\', \'' . $row["detu_tcon"] . '\', \'' . $row["gcom_id"] . '\', \'' . $formatted_feing . '\', \'' . $formatted_feret . '\');" id="' . $row["usu_id"] . '" class="btn btn-inline btn-warning btn-sm ladda-button" title="Editar"><i class="fa fa-edit"></i></button>
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

        ///--------------------------

    case 'buscarusuario':
        $nom = $usuario->buscarusuario($_POST["usu_id"]);
        echo json_encode($nom);
        break;

    case "indicadores_gestion":
        if ($_POST["usu_grupocom"] == "" || $_POST["usu_grupocom"] == null) {
            $grupo = 0;
        } else {
            $grupo = $_POST["usu_grupocom"];
        }
        $datos = $usuario->indicadores_gestion(
            $_POST["usu_id"],
            $_POST["usu_perfil"],
            $grupo,
            $_POST["dato"]
        );
        $output = array(
            "interesado" => 0,
            "radicado" => 0,
            "sumaradicadas" => 0,
            "gestiones" => 0,
            "fecrea" => 0,
            "feradicado" => 0,
            "feconsola" => 0,
        );
        if (isset($datos[0])) {
            $output["interesado"] = isset($datos[0]['intere']) ? $datos[0]['intere'] : 0;
            $output["radicado"] = isset($datos[0]['radic']) ? $datos[0]['radic'] : 0;
            $output["sumaradicadas"] = isset($datos[0]['sumradi']) ? '$ ' . number_format($datos[0]['sumradi'], 0, ',', '.') : '$ 0';
            $output["gestiones"] = isset($datos[0]['gestion']) ? $datos[0]['gestion'] : '0';
            $output["fecrea"] = isset($datos[0]['feccreacli']) ? $datos[0]['feccreacli'] : 0;
            $output["feradicado"] = isset($datos[0]['feradicli']) ? $datos[0]['feradicli'] : 0;
            $output["feconsola"] = isset($datos[0]['feconsc']) ? $datos[0]['feconsc'] : 0;
        }
        echo json_encode($output);
        break;

    case 'director':
        $grupoCom = $_SESSION["usu_grupocom"];
        $datos = $usuario->get_usu_director($grupoCom);
        if (is_array($datos) == true and count($datos) > 0) {
            $html = "";
            foreach ($datos as $row) {
                $html .= "<option value='" . $row['usu_id'] . "'>" . $row['detu_nom'] ." ".$row['detu_ape']. "</option>";
            }
            echo $html;
        }
        break;
    case 'usuxgrupocom':
        $grupoCom = $_POST["idgrupocom"];
        $datos = $usuario->get_usu_xgrupocom($grupoCom);
            if (is_array($datos) == true and count($datos) > 0) {
                $html = "";
                foreach ($datos as $row) {
                    $html .= "<option value='" . $row['usu_id'] . "'>" . $row['detu_nom'] ." ".$row['detu_ape']. "</option>";
                }
                echo $html;
            }
            break;
    // COMBO ASESOR CUANDO ES COORDINADOR
    case 'combogrupogcom':
            $grupoCom = $_SESSION["usu_grupocom"];
            $datos = $usuario->combogrupogcom($grupoCom);
            if (is_array($datos) == true and count($datos) > 0) {
                $html = "";
                foreach ($datos as $row) {
                    $html .= "<option value='" . $row['usu_id'] . "'>" . $row['detu_nom'] ." ".$row['detu_ape']. "</option>";
                }
                echo $html;
            }
            break;
    
    //COMBOS PARA COLOCAR SOLO EL USUARIO
    case "usuario":
        $html = "";
        $usu_id = $_SESSION["usu_id"];
        $nombre = $usuario->buscarnombre($usu_id);
        if (is_array($nombre) && count($nombre) > 0) {
            $nombre_mostrar = $nombre[0]['detu_nom']." ".$nombre[0]['detu_ape'];
        } else {
            $nombre_mostrar = "Nombre no encontrado";
        }
        $html .= "<option value='" . $usu_id . "'>" . $nombre_mostrar . "</option>";
        echo $html;
        break;
    // COMBO PARA COLOCAR EL AGENTE
    case "agente":
        $html = "";
        $usu_id = $_SESSION["usu_id"];
        $nombre = $usuario->buscarnombre($usu_id);
        if (is_array($nombre) && count($nombre) > 0) {
            $nombre_mostrar = $nombre[0]['detu_nom']." ".$nombre[0]['detu_ape'];
        } else {
            $nombre_mostrar = "Nombre no encontrado";
        }
        $html .= "<option value='" . $usu_id . "'>" . $nombre_mostrar . "</option>";
        echo $html;
        break;



    case "Basesorxcc":
        $res = $usuario->Basesorxcc($_POST["cedula"]);
        echo json_encode($res);
        break;

    case "idasesor":
        $datos = $usuario->idasesor($_POST["asesor"]);
        echo json_encode($datos);
        break;

    case 'bgrupocc':
        $usu_id = $_SESSION["usu_id"];
        $datos = $usuario->bgrupocc($usu_id);
        echo json_encode($datos);
        break;

    case "editarUsu":
        $usu_direccion = !empty($_POST["usu_direccion"]) ? strtoupper($_POST["usu_direccion"]) : $_POST["usu_direccion"];
        $usu_ciudad = !empty($_POST["usu_ciudad"]) ? strtoupper($_POST["usu_ciudad"]) : $_POST["usu_ciudad"];
        $usu_departamento = !empty($_POST["usu_dep"]) ? strtoupper($_POST["usu_dep"]) : $_POST["usu_dep"];

        //FECHA DE NACIMIENTO
        $fecha = "";

        if($_POST['usu_fnac'] != '0000-00-00'){
            $fechaOriginal = $_POST['usu_fnac'];
            $fechaObj = DateTime::createFromFormat('d/m/Y', $fechaOriginal);
            if ($fechaObj) {
                $fecha = $fechaObj->format('Y-m-d'); // Convertir a formato Y-m-d para la base de datos
            } else {
                $fecha = '0000-00-00'; 
            }
        }else{
            $fecha = '0000-00-00';
        }

        $res = $usuario->editarUsu(
            $_POST["usu_id"],
            $fecha,
            $_POST["usu_telefono"],
            $_POST["usu_celular"],
            $_POST["usu_mail"],
            $usu_direccion,
            $usu_ciudad,
            $usu_departamento
        );
        echo json_encode($res);
        break;

    case "editarCont":
        $res = $usuario->editarCont($_POST["usu_id"], $_POST["nuevac"], $_POST["rnuevac"]);
        echo $res;
        break;

    case "indicadoresventa":
        if ($_SESSION["usu_grupocom"] == "") {
            $grupo = 0;
        } else {
            $grupo = $_SESSION["usu_grupocom"];
        }
        $resultado = $usuario->buscardatosindicaventas($_POST["usu_id"], $grupo, $_POST["usu_perfil"], $_POST["dato"]);
        echo json_encode($resultado);
        break;

    case "get_csip":
        $datos = $usuario->get_csip();
        $html = "";
        if (is_array($datos) == true and count($datos) > 0) {
            $html .= "<option value=''>Sin Cuenta</option>";
            foreach ($datos as $row) {
                $html .= "<option value='" . $row['sip_id'] . "'>" . $row['sip_nom'] . "</option>";
            }
        } else {
            $html .= "<option value=''>Sin Cuenta</option>";
        }
        echo $html;
        break;

    case "crear_autorizacionpc":
        $res = $usuario->crear_autorizacionpc($_POST["usu_id"], $_POST["nom_pc"], $_POST["huellapc"]);
        echo $res;
        break;

    case "comunicadosInternos":
        $datos = $usuario->comunicadosInternos();
        $html = '';
        if (!empty($datos)) {
            foreach ($datos as $dato) {
                $fechaOriginal = $dato['com_fecrea'];
                $fechaFormateada = DateTime::createFromFormat('Y-m-d', $fechaOriginal)->format('d/m/Y');

                $html .= '<article class="contact-row">
                                <div class="user-card-row">
                                    <div class="tbl-row">
                                        <div class="tbl-cell tbl-cell-photo">
                                            <a href="#" onclick="btcomunicado(event)">
                                                <img src="../../public/img/post-user-' . ($dato['com_clas']) . '.png" style="border-radius: 15%;" alt="">
                                            </a>
                                        </div>
                                        <div class="tbl-cell">
                                            <p class="user-card-row-name"><a href="#" id="btcomunicado2">' . ($dato['com_asun']) . '</a></p>
                                            <p class="user-card-row-mail">' . ($dato['usu_nom']) . '</p>
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

    case "numero_comeninternos":
        $res = $usuario->numero_comeninternos();
        echo json_encode($res);
        break;
    case "datossip":
        $res = $usuario->datos_sip($_POST["usu_id"]);
        echo json_encode($res);
        break;
    case "editarsip":
        $res = $usuario->editarsip($_POST["usu"],$_POST["usu_ext"],$_POST["usu_passip"]);
        echo json_encode($res);
        break;
    case "nombre_usu":
        $res = $_SESSION["nom"];
        echo $res;
        break;
    //COMBO PARA COLOCAR PARTICIPANTES EVENTOS
    case 'part_event':
        $html = "";
        $datos = $usuario->part_event($_SESSION["usu_perfil"], $_SESSION["usu_id"], $_SESSION["usu_grupocom"] );
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $html .= "<option value='" . $row['usuid'] . "'>" . $row['nomusu'] . "</option>";
            }
            echo $html;
        }
        break;

}
