<?php
class Cliente extends Conectar
{
    public function filtrar($fechaInicio, $fechaFin, $usu_perfil, $entidad, $grupo, $asesor, $filtro)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "CALL SP_Filtro_contar(?,?,?,?,?,?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_perfil);
        $sql->bindValue(2, $entidad);
        $sql->bindValue(3, $grupo);
        $sql->bindValue(4, $asesor);
        $sql->bindValue(5, $fechaInicio);
        $sql->bindValue(6, $fechaFin);
        $sql->bindValue(7, $filtro);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
    
    public function buscarclienteTodo($id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "CALL SP_Buscar_HojadevidaCli(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $id);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }


    public function listar_clientes($fechaInicio, $fechaFin, $usuPerfil, $fil_entidad, $fil_grupo, $fil_asesor, $estado, $filtro)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "CALL SP_Buscar_clientes(?,?,?,?,?,?,?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $fechaInicio);
        $sql->bindValue(2, $fechaFin);
        $sql->bindValue(3, $usuPerfil);
        $sql->bindValue(4, $fil_entidad);
        $sql->bindValue(5, $fil_grupo);
        $sql->bindValue(6, $fil_asesor);
        $sql->bindValue(7, $estado);
        $sql->bindValue(8, $filtro);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }

    public function B_ClientexID($idcli)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "call SP_Buscar_idcliente(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $idcli);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }

    public function get_cliente()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "CALL SP_Buscar_utilidades()";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }

    public function listar_comentarios_x_cliente($cli_id, $perfil)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "call SP_Buscar_comentariocli(?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $cli_id, PDO::PARAM_INT);
        $sql->bindValue(2, $perfil);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }

    public function editar_cliente($id_cli, $tipo, $cli_cc, $cli_nombre, $fec_nac, $cli_telefono, $tel_alternativo, $cli_mail, $cli_entidad, $cli_dir, $cli_ciudad, $cli_dep, $cli_convenio, $est_laboral, $tipo_contrato, $cli_cargo, $tiem_servicio, $tipo_pension, $contacto, $agente, $asesor)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call SP_Editar_cliente(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $id_cli, PDO::PARAM_INT);
        $sql->bindValue(2, $tipo);
        $sql->bindValue(3, $cli_cc);
        $sql->bindValue(4, $cli_nombre);
        $sql->bindValue(5, $fec_nac);
        $sql->bindValue(6, $cli_telefono);
        $sql->bindValue(7, $tel_alternativo);
        $sql->bindValue(8, $cli_mail);
        $sql->bindValue(9, $cli_ciudad);
        $sql->bindValue(10, $cli_dep);
        $sql->bindValue(11, $cli_convenio);
        $sql->bindValue(12, $est_laboral);
        $sql->bindValue(13, $tipo_contrato);
        $sql->bindValue(14, $cli_cargo);
        $sql->bindValue(15, $tiem_servicio);
        $sql->bindValue(16, $tipo_pension);
        $sql->bindValue(17, $contacto);
        $sql->bindValue(18, $agente);
        $sql->bindValue(19, $asesor);
        $sql->bindValue(20, $cli_entidad);
        $sql->bindValue(21, $cli_dir);
        $res = $sql->execute();
        unset($conectar);
        return $res;
    }

    public function B_ClientexDato($busqueda, $filtro, $grupo, $usuPerfil, $usu_id)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "call SP_Buscar_datocliente(?,?,?,?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $filtro);
        $sql->bindValue(2, $busqueda);
        $sql->bindValue(3, $usu_id, PDO::PARAM_INT);
        $sql->bindValue(4, $usuPerfil);
        $sql->bindValue(5, $grupo, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
//se une con BuscarxCC
    public function NoRepetirCC($c)
    {
        $conectar = parent::conexion();
        $sql = "CALL SP_Buscar_cc_norep(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $c);
        $sql->execute();
        $result = $sql->fetchAll();
        unset($conectar);
        return $result;
    }

    public function NoRepetirTel($t)
    {
        $conectar = parent::conexion();
        $sql = "CALL SP_Buscar_tel_norep(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $t);
        $sql->execute();
        $result = $sql->fetchAll();
        unset($conectar);
        return $result;
    }

    public function consulta($idcli)
    {
        $conectar = parent::conexion();
        $sql = "CALL SP_Buscar_consulta(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $idcli);
        $sql->execute();
        $result = $sql->fetchAll();
        unset($conectar);
        return $result;
    }

    public function insert_cliente($tipo, $cli_cc, $cli_nombre, $cli_edad, $cli_telefono, $tel_alternativo, $cli_mail, $cli_ciudad, $cli_depar, $cli_entidad, 
    $cli_estado, $cli_convenio, $est_laboral, $tipo_contrato, $cli_cargo, $tipo_pension, $tiem_servicio, $toma_contac, $cli_agente, $cli_asesor, $comentario, 
    $dir, $tabla, $idcli, $idcam, $observaciones, $estado)
    {

        $conectar = parent::conexion();
        parent::set_names();

        $sql = "CALL SP_Crear_cliente(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $stmt  = $conectar->prepare($sql);
        $stmt ->bindValue(1, $tipo);
        $stmt->bindValue(2, $cli_cc);
        $stmt->bindValue(3, $cli_nombre);
        $stmt->bindValue(4, $cli_edad);
        $stmt->bindValue(5, $cli_telefono);
        $stmt->bindValue(6, $tel_alternativo);
        $stmt->bindValue(7, $cli_mail);
        $stmt->bindValue(8, $cli_ciudad);
        $stmt->bindValue(9, $cli_depar);
        $stmt->bindValue(10, $cli_entidad, PDO::PARAM_INT);
        $stmt->bindValue(11, $cli_estado);
        $stmt->bindValue(12, $cli_convenio);
        $stmt->bindValue(13, $est_laboral);
        $stmt->bindValue(14, $tipo_contrato);
        $stmt->bindValue(15, $cli_cargo);
        $stmt->bindValue(16, $tipo_pension);
        $stmt->bindValue(17, $tiem_servicio);
        $stmt->bindValue(18, $toma_contac, PDO::PARAM_INT);
        $stmt->bindValue(19, $cli_agente, PDO::PARAM_INT);
        $stmt->bindValue(20, $cli_asesor, PDO::PARAM_INT);
        $stmt->bindValue(21, $dir);

        $stmt->execute();
        $id = $stmt->fetchColumn();
        $stmt->closeCursor(); // Liberar el cursor

        if ($comentario != "" && $comentario != "<p><br></p>") {
            // Crear comentario
            $sql = "CALL SP_Crear_comentario(?,?,?,?)";
            $stmt = $conectar->prepare($sql);
            $stmt->bindValue(1, $id, PDO::PARAM_INT);
            $stmt->bindValue(2, $comentario);
            $stmt->bindValue(3, $_SESSION["usu_id"], PDO::PARAM_INT);
            $stmt->bindValue(4, 1, PDO::PARAM_INT);
            $stmt->execute();
            $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor(); // Liberar el cursor
        }

        // Crear comentario
        $sql = "CALL SP_Crear_comdetconsola(?,?,?,?)";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $id, PDO::PARAM_INT);
        $stmt->bindValue(2, $_SESSION["usu_id"], PDO::PARAM_INT);
        $stmt->bindValue(3, $tabla);
        $stmt->bindValue(4, $idcli);
        $stmt->execute();
        $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor(); // Liberar el cursor

        //Editar llamada
        $sql = "CALL Sp_Editar_llamadas(?,?,?,?,?)";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, 'Cliente creado');
        $stmt->bindValue(2, $estado);
        $stmt->bindValue(3, $tabla);
        $stmt->bindValue(4, $idcli, PDO::PARAM_INT);
        $stmt->bindValue(5, '00:00:00');
        $stmt->execute();
        $stmt->fetch(PDO::FETCH_ASSOC);
        $cambio = $stmt->closeCursor(); // Liberar el cursor

        unset($conectar);
        return $cambio;
    }

    public function insertclienteform($tipo, $cli_cc, $cli_nombre, $cli_edad, $cli_telefono, $tel_alternativo, $cli_mail, $cli_ciudad, $cli_depar, $cli_entidad, 
    $cli_estado, $cli_convenio, $est_laboral, $tipo_contrato, $cli_cargo, $tipo_pension, $tiem_servicio, $toma_contac, $cli_agente, $cli_asesor)
    {

        $conectar = parent::conexion();
        parent::set_names();

        $sql = "CALL SP_Crear_cliente(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $stmt  = $conectar->prepare($sql);
        $stmt ->bindValue(1, $tipo);
        $stmt->bindValue(2, $cli_cc);
        $stmt->bindValue(3, $cli_nombre);
        $stmt->bindValue(4, $cli_edad);
        $stmt->bindValue(5, $cli_telefono);
        $stmt->bindValue(6, $tel_alternativo);
        $stmt->bindValue(7, $cli_mail);
        $stmt->bindValue(8, $cli_ciudad);
        $stmt->bindValue(9, $cli_depar);
        $stmt->bindValue(10, $cli_entidad, PDO::PARAM_INT);
        $stmt->bindValue(11, $cli_estado);
        $stmt->bindValue(12, $cli_convenio);
        $stmt->bindValue(13, $est_laboral);
        $stmt->bindValue(14, $tipo_contrato);
        $stmt->bindValue(15, $cli_cargo);
        $stmt->bindValue(16, $tipo_pension);
        $stmt->bindValue(17, $tiem_servicio);
        $stmt->bindValue(18, $toma_contac, PDO::PARAM_INT);
        $stmt->bindValue(19, $cli_agente, PDO::PARAM_INT);
        $stmt->bindValue(20, $cli_asesor, PDO::PARAM_INT);
        $stmt->bindValue(21, "");

        $stmt->execute();
        $id = $stmt->fetchColumn();
        $stmt->closeCursor(); // Liberar el cursor

        unset($conectar);
        return $id;
        
    }

    public function insert_cliente_preselecta($tipo, $cli_cc, $cli_nombre, $cli_edad, $cli_telefono, $tel_alternativo, $cli_mail, $cli_ciudad, $cli_depar, $cli_entidad, $cli_estado, $cli_convenio, $est_laboral, $tipo_contrato, $cli_cargo, $tipo_pension, $tiem_servicio, $toma_contac, $cli_agente, $cli_asesor, $comentario, $cli_dir)
    {
        try {
            $conectar = parent::conexion();
            parent::set_names();

            $sql = "CALL SP_Crear_cliente(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $tipo);
            $sql->bindValue(2, $cli_cc);
            $sql->bindValue(3, $cli_nombre);
            $sql->bindValue(4, $cli_edad);
            $sql->bindValue(5, $cli_telefono);
            $sql->bindValue(6, $tel_alternativo);
            $sql->bindValue(7, $cli_mail);
            $sql->bindValue(8, $cli_ciudad);
            $sql->bindValue(9, $cli_depar);
            $sql->bindValue(10, $cli_entidad, PDO::PARAM_INT);
            $sql->bindValue(11, $cli_estado);
            $sql->bindValue(12, $cli_convenio);
            $sql->bindValue(13, $est_laboral);
            $sql->bindValue(14, $tipo_contrato);
            $sql->bindValue(15, $cli_cargo);
            $sql->bindValue(16, $tipo_pension);
            $sql->bindValue(17, $tiem_servicio);
            $sql->bindValue(18, $toma_contac, PDO::PARAM_INT);
            $sql->bindValue(19, $cli_agente, PDO::PARAM_INT);
            $sql->bindValue(20, $cli_asesor, PDO::PARAM_INT);
            $sql->bindValue(21, $cli_dir);
            $sql->execute();
            $id = $sql->fetchColumn(); // Obtener el ID del cliente insertado

            // Crear comentario
            $sql = "CALL SP_Crear_comentario(?,?,?,?)";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $id, PDO::PARAM_INT);
            $sql->bindValue(2, $comentario);
            $sql->bindValue(3, $_SESSION["usu_id"], PDO::PARAM_INT);
            $sql->bindValue(4, 1, PDO::PARAM_INT);
            $sql->execute();
            $resultado = $sql->fetch(PDO::FETCH_ASSOC);

            //crear consulta
            $sql = "CALL SP_Crear_consulta(?)";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $id, PDO::PARAM_INT);
            $sql->execute();
            $res = $sql->fetch(PDO::FETCH_ASSOC);

            // Array de archivos a procesar
            $archivos = [
                ["name" => "cedula", "type" => "Cedula"],
                // ["name" => "desprendible", "type" => "Desprendible"],
                ["name" => "autorizacion", "type" => "Autorizacion"],
            ];

            foreach ($archivos as $archivo) {
                if ($_FILES[$archivo['name']]['error'] === UPLOAD_ERR_OK) {
                    $fileInfo = pathinfo($_FILES[$archivo['name']]["name"]);
                    $fileExtension = $fileInfo["extension"];
                    $idArchivo = uniqid();
                    $file = $idArchivo . '.' . $fileExtension;
                    $url_temp = $_FILES[$archivo['name']]["tmp_name"];
                    $url_insert = dirname(__FILE__) . "/../documents/clientes/" . $id;
                    $url_target = str_replace('\\', '/', $url_insert) . '/' . $file;

                    if (!file_exists($url_insert)) {
                        mkdir($url_insert, 0777, true);
                    }

                    if (move_uploaded_file($url_temp, $url_target)) {
                        $conectar = parent::conexion();
                        parent::set_names();
                        $sql = "CALL SP_Crear_doccli(?,?,?,?,?,?)";
                        $sql = $conectar->prepare($sql);
                        $sql->bindValue(1, $id, PDO::PARAM_INT);
                        $sql->bindValue(2, $archivo['type']);
                        $sql->bindValue(3, $file);
                        $sql->bindValue(4, 1, PDO::PARAM_INT); // Hardcoded values need review
                        $sql->bindValue(5, 1, PDO::PARAM_INT); // Hardcoded values need review
                        $sql->bindValue(6, $_SESSION["usu_id"], PDO::PARAM_INT);
                        $sql->execute();
                        unset($conectar);
                    }
                }
            }

            return $id;
        } catch (PDOException $e) {
            return "0"; // Manejar el error adecuadamente
        }
    }

    public function Buscaridcli($documento)
    {
        $conectar = parent::conexion();
        $sql = "CALL SP_Buscar_idcli(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $documento);
        $sql->execute();
        $result = $sql->fetchAll();
        unset($conectar);
        return $result;
    }

    public function insert_cliente_xdoc($cli_cc, $cli_nombre, $cli_edad, $cli_telefono, $cli_ciudad, $cli_entidad, $cli_estado, $cli_convenio, $cli_asesor, $fcreacion, $toma_contac, $tipo)
    {
        echo $fcreacion;
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "call SP_Crear_cliente_xdoc(?,?,?,?,?,?,?,?,?,?,?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $tipo);
        $sql->bindValue(2, $cli_cc);
        $sql->bindValue(3, $cli_nombre);
        $sql->bindValue(4, $cli_edad);
        $sql->bindValue(5, $cli_telefono);
        $sql->bindValue(6, $cli_ciudad);
        $sql->bindValue(7, $cli_entidad, PDO::PARAM_INT);
        $sql->bindValue(8, $cli_estado);
        $sql->bindValue(9, $cli_convenio);
        $sql->bindValue(10, $cli_asesor, PDO::PARAM_INT);
        $sql->bindValue(11, $fcreacion);
        $sql->bindValue(12, $toma_contac, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }

    public function editarclientexdoc($cccliente, $estado, $festado)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call SP_Editar_cliente_xdoc(?,?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $cccliente);
        $sql->bindValue(2, $estado);
        $sql->bindValue(3, $festado);
        $sql->execute();
        unset($conectar);
    }

    public function insert_comentarios($cli_id, $com_coment, $usu_id, $privacidad)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "CALL SP_Crear_comentario(?,?,?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $cli_id, PDO::PARAM_INT);
        $sql->bindValue(2, $com_coment);
        $sql->bindValue(3, $usu_id, PDO::PARAM_INT);
        $sql->bindValue(4, $privacidad, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetch(PDO::FETCH_ASSOC);
        unset($conectar);
        return $resultado;
    }

    public function editar_comentarios($cli_id, $com_coment, $usu_id, $privacidad, $idcom)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "CALL SP_Editar_comentario(?,?,?,?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $cli_id, PDO::PARAM_INT);
        $sql->bindValue(2, $com_coment);
        $sql->bindValue(3, $usu_id, PDO::PARAM_INT);
        $sql->bindValue(4, $privacidad, PDO::PARAM_INT);
        $sql->bindValue(5, $idcom, PDO::PARAM_INT);

        $sql->execute();
        $resultado = $sql->fetch(PDO::FETCH_ASSOC);
        unset($conectar);
        return $resultado;
    }
    public function editar_pricomentarios($com_id, $estado)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "CALL SP_Editar_comentariopri(?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $com_id, PDO::PARAM_INT);
        $sql->bindValue(2, $estado);
        $sql->execute();
        $resultado = $sql->fetch(PDO::FETCH_ASSOC);
        unset($conectar);
        return $resultado;
    }

    public function delete_operaciones($ope_id)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "CALL SP_Eliminar_operaciones(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $ope_id, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }

    public function editar_consulta($fecon, $resp, $desc, $id_cli, $pri, $conid)
    {
        try {
            $conectar = parent::Conexion();
            parent::set_names();
            $sql = "CALL SP_Editar_con(?,?,?,?,?)";
            $stmt = $conectar->prepare($sql);
            $stmt->bindValue(1, $conid);
            $stmt->bindValue(2, $fecon);
            $stmt->bindValue(3, $resp);
            $stmt->bindValue(4, $desc);
            $stmt->bindValue(5, $pri);

            $stmt->execute();

            // Verificar si se han actualizado filas
            if ($stmt->rowCount() > 0) {
                return ['status' => 'success', 'message' => 'Consulta actualizada con éxito.'];
            } else {
                return ['status' => 'error', 'message' => 'No se encontraron filas para actualizar.'];
            }
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => 'Excepción capturada: ' . $e->getMessage()];
        }
    }

    public function editar_estado($id_cli, $selectedValue)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "CALL SP_Editar_estado(?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $id_cli, PDO::PARAM_INT);
        $sql->bindValue(2, $selectedValue);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }

    public function sumadesebolsados($usu_id, $usu_perfil, $dato, $grupo)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "CALL SP_Buscar_sumadesembolsos(?,?,?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_id, PDO::PARAM_INT);
        $sql->bindValue(2, $usu_perfil);
        $sql->bindValue(3, $dato);
        $sql->bindValue(4, $grupo);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
    
    public function get_cliterm($ter, $perfil, $usu, $grupo)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "CALL SP_Buscar_cliterm(?,?,?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $ter);
        $sql->bindValue(2, $perfil);
        $sql->bindValue(3, $usu);
        $sql->bindValue(4, $grupo);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }

}
