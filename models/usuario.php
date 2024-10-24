<?php

class Usuario extends Conectar
{
    // Función para obtener la IP del cliente
    private function getClientIP()
    {
        if (isset($_SERVER['HTTP_CLIENT_IP']) && !empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && !empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (isset($_SERVER['REMOTE_ADDR']) && !empty($_SERVER['REMOTE_ADDR'])) {
            return $_SERVER['REMOTE_ADDR'];
        } else {
            return 'UNKNOWN';
        }
    }
    public function login()
    {
        $conectar = parent::Conexion();
        parent::set_names();
        if (isset($_POST["enviar"])) {
            $user = $_POST["usu_user"];
            $pass = $_POST["usu_pass"];
            $huella = $_POST["visitor_id"];
            $client_ip = $this->getClientIP(); // Obtener la IP del cliente
            echo "IP del cliente: " . $client_ip;

            if (empty($user) and empty($pass)) {
                header("Location:" . conectar::ruta() . "index.php?m=2");
                exit();
            } else {
                $sql = "call SP_Login(?,?)";
                $stmt = $conectar->prepare($sql);
                $stmt->bindValue(1, $user);
                $stmt->bindValue(2, $pass);
                $stmt->execute();
                $resultado = $stmt->fetch();
                $stmt->closeCursor();

                if (is_array($resultado) and count($resultado) > 0) {
                    $perfil = $resultado["usu_per"];
                    $usu = $resultado["usu_id"];

                    if ($perfil == "Otros") {
                        $sql2 = "call SP_Autorizacion(?,?)";
                        $stmt2 = $conectar->prepare($sql2);
                        $stmt2->bindValue(1, $usu);
                        $stmt2->bindValue(2, $huella);
                        $stmt2->execute();
                        $autorizacion = $stmt2->fetch();
                        $stmt2->closeCursor();

                        if (!$autorizacion) {
                            $_SESSION["usu_id"] = $resultado["usu_id"];
                            // Huella no autorizada
                            header("Location:" . Conectar::ruta() . "index.php?m=3"); // Mensaje de no autorizado
                            exit();
                        } else {
                            $_SESSION["usu_id"] = $resultado["usu_id"];
                            $_SESSION["usu_perfil"] = $resultado["usu_per"];
                            $_SESSION["usu_grupocom"] = $resultado["gcom_id"];
                            $_SESSION["client_ip"] = $client_ip; // Guardar la IP en la sesión
                            $_SESSION["nom"] = $resultado["detu_nom"] + " " + $resultado["detu_ape"];


                            header("Location:" . Conectar::ruta() . "view/home/");
                            exit();
                        }
                    } else {
                        $_SESSION["usu_id"] = $resultado["usu_id"];
                        $_SESSION["usu_perfil"] = $resultado["usu_per"];
                        $_SESSION["usu_grupocom"] = $resultado["gcom_id"];
                        $_SESSION["client_ip"] = $client_ip; // Guardar la IP en la sesión
                        $_SESSION["nom"] = $resultado["detu_nom"];

                        header("Location:" . Conectar::ruta() . "view/home/");
                        exit();
                    }

                } else {
                    header("Location:" . Conectar::ruta() . "index.php?m=1");
                    exit();
                }
            }
        }
        unset($conectar);
    }
    //solo me traE el nombre
    public function buscarusuario($usu_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call SP_Buscar_datosusuario(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_id, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
    public function get_usu()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call SP_Buscar_usu()";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
    // COMBO ASESOR CUANDO ES ADMIN Y/O OPERATIVO
    public function combo_asesoradmin()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call SP_Buscar_asesoradmin()";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
    // COMBO AGENTE CUANDO ES ADMIN Y/O OPERATIVO
    public function combo_agenteadmin()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call SP_Buscar_agenteadmin()";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
    // COMBO AGENTE CUANDO ES AGENTE
    public function combo_agente()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call SP_Buscar_comboagente()";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
    public function get_usu_director($usu_grupocom)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call SP_Buscar_usugcom(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_grupocom, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
    public function get_usu_xgrupocom($usu_grupocom)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call SP_Buscar_usuxgcom(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_grupocom, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
    // COMBO ASESOR CUANDO ES COORDINADOR
    public function combogrupogcom($usu_grupocom)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call SP_Buscar_usuasegcom(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_grupocom, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
    public function Basesorxcc($cedula)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "call SP_Contar_idasesor(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $cedula);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }    
    public function nousurep($usuario)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "call SP_Buscar_usunorep(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usuario);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
    public function insert_usuario($usu_user, $usu_pass, $usu_perfil, $usu_est, $usu_tipodoc, $usu_cc, $usu_nom, $ape, $usu_mail, $usu_car, $tipocon, $usu_grupocom, $tar_fingreso, $usu_feretiro)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "call SP_Crear_usu(?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_user);
        $sql->bindValue(2, $usu_pass);
        $sql->bindValue(3, $usu_perfil);
        $sql->bindValue(4, $usu_est);
        $sql->bindValue(5, $usu_tipodoc);
        $sql->bindValue(6, $usu_cc);
        $sql->bindValue(7, $usu_nom);
        $sql->bindValue(8, $usu_mail);
        $sql->bindValue(9, $usu_car);
        $sql->bindValue(10, $usu_grupocom);
        $sql->bindValue(11, $tar_fingreso);
        $sql->bindValue(12, $usu_feretiro);
        $sql->bindValue(13, $ape);
        $sql->bindValue(14, $tipocon);

        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
    public function update_usuario($usu_id, $usu_user, $usu_pass, $usu_perfil, $usu_est, $usu_tipodoc, $usu_cc, $usu_nom, $ape, $usu_mail, $usu_cargo, $tipocon, $usu_grupocom, $tar_ingreso, $usu_feretiro)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "call SP_Editar_usu(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_id, PDO::PARAM_INT);
        $sql->bindValue(2, $usu_user);
        $sql->bindValue(3, $usu_pass);
        $sql->bindValue(4, $usu_perfil);
        $sql->bindValue(5, $usu_est, PDO::PARAM_INT);
        $sql->bindValue(6, $usu_tipodoc);
        $sql->bindValue(7, $usu_cc, PDO::PARAM_INT);
        $sql->bindValue(8, $usu_nom);
        $sql->bindValue(9, $usu_mail);
        $sql->bindValue(10, $usu_cargo);
        $sql->bindValue(11, $usu_grupocom, PDO::PARAM_INT);
        $sql->bindValue(12, $tar_ingreso);
        $sql->bindValue(13, $usu_feretiro);
        $sql->bindValue(14, $ape);
        $sql->bindValue(15, $tipocon);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
    public function update_detusuario($usuid, $fenac, $usu_tel, $usu_cel, $usu_dir, $usu_ciu, $usu_dep)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "call SP_Editar_detusu(?,?,?,?,?,?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usuid, PDO::PARAM_INT);
        $sql->bindValue(2, $usu_tel);
        $sql->bindValue(3, $usu_cel);
        $sql->bindValue(4, $usu_dir);
        $sql->bindValue(5, $usu_ciu);
        $sql->bindValue(6, $usu_dep);
        $sql->bindValue(7, $fenac);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
    public function idasesor($asesor)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call SP_Buscar_idusu(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $asesor, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
    public function bgrupocc($usu_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call SP_Buscar_usugcc(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_id, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
    public function get_usuario()
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "call SP_Buscar_usu()";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
    public function get_usuarioInac()
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "call SP_Buscar_usuInactivos()";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }

    public function get_usuario_x_id($usu_id)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "call SP_Buscar_usuid(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_id, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }

    public function delete_usuario($usu_id)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "call SP_Eliminar_usu(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_id, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }

    public function get_csip()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call SP_Buscar_sip()";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }

    public function editarUsu($usu_id,$fnac,$usu_telefono, $usu_celular, $usu_mail, $usu_direccion, $usu_ciudad, $usu_dep)
    {
        try {
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "CALL SP_Editar_usuario(?, ?, ?, ?, ?, ?, ?, ?)";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $usu_id, PDO::PARAM_INT);
            $sql->bindValue(2, $usu_telefono);
            $sql->bindValue(3, $usu_celular);
            $sql->bindValue(4, $usu_mail);
            $sql->bindValue(5, $usu_direccion);
            $sql->bindValue(6, $usu_ciudad);
            $sql->bindValue(7, $usu_dep);
            $sql->bindValue(8, $fnac);
            $sql->execute();
            unset($conectar);

            return ["success" => "Usuario actualizado con éxito"];
        } catch (PDOException $e) {
            return ["error" => $e->getMessage()];
        }
    }

    public function editarCont($usu_id, $nuevaC, $CNuevaC)
    {
        try {
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "call SP_Editar_pass(?,?,?)";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $usu_id, PDO::PARAM_INT);
            $sql->bindValue(2, $nuevaC);
            $sql->bindValue(3, $CNuevaC);
            $res = $sql->execute();
            unset($conectar);
            return "Exito";
        } catch (PDOException $e) {
            return "error";
        }

    }

    public function crear_autorizacionpc($usu_id, $nom_pc, $huellapc)
    {
        try {
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "call SP_Crear_autorizacion(?,?,?)";
            $stmt = $conectar->prepare($sql);
            $stmt->bindValue(1, $usu_id, PDO::PARAM_INT);
            $stmt->bindValue(2, $nom_pc);
            $stmt->bindValue(3, $huellapc);
            $stmt->execute();
            unset($conectar);
            return "Exito";
        } catch (PDOException $e) {
            return "error";
        }
    }

    public function indicadores_gestion($usu_id, $usu_perfil, $usu_grupocom, $dato)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call SP_Buscar_indicagestion(?,?,?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_id, PDO::PARAM_INT);
        $sql->bindValue(2, $usu_perfil);
        $sql->bindValue(3, $usu_grupocom, PDO::PARAM_INT);
        $sql->bindValue(4, $dato);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }

    public function comunicadosInternos()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call SP_Buscar_comunicadosInter()";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        unset($conectar);
        return $resultado;
    }

    public function numero_comeninternos()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call SP_Buscar_numcominternos()";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }

    public function buscardatosindicaventas($usu_id, $gcom, $perfil, $dato)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call SP_Buscar_DatosIndicaVenta(?,?,?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_id, PDO::PARAM_INT);
        $sql->bindValue(2, $gcom);
        $sql->bindValue(3, $perfil);
        $sql->bindValue(4, $dato);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }

    public function buscarnombre($usu_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call SP_Buscar_nombreusu(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_id, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
    
    public function get_usuterm($term, $perfil, $usuario)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call SP_Buscar_usuterm(?,?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $term);
        $sql->bindValue(2, $perfil);
        $sql->bindValue(3, $usuario);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
    public function datos_sip($usu_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call SP_Buscar_datosSip(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_id);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
    public function editarsip($usu, $usu_ext, $usu_passip)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call SP_Editar_datosSip(?,?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu);
        $sql->bindValue(2, $usu_ext);
        $sql->bindValue(3, $usu_passip);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
    //COMBO PARA COLOCAR PARTICIPANTES EVENTOS
    public function part_event($perfil, $idusu, $grupocom)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call SP_Buscar_usuarios(?, ?, ?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $perfil);
        $sql->bindValue(2, $idusu);
        $sql->bindValue(3, $grupocom);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
    
    
}
