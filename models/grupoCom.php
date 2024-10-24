<?php
class GrupoCom extends Conectar
{
    public function get_grupocom()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call sp_Buscar_grupocom()";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }

    public function get_grupocom_usuario($grupoCom)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call SP_Buscar_gcom_usu(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $grupoCom, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }

    public function get_grupocom_x_id($com_id)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "CALL SP_Buscar_idgcom(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $com_id, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }

    public function get_grupocom_all()
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "CALL SP_Buscar_gcom()";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }

    public function listar_Inactivos()
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "CALL SP_Buscar_gcomInactivos()";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }

    public function insert_grupocom($com_nombre, $com_comentario, $com_estado)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "CALL SP_Crear_gcom(?,?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $com_nombre);
        $sql->bindValue(2, $com_comentario);
        $sql->bindValue(3, $com_estado, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }

    public function update_grupocom($com_id, $com_nombre, $com_comentario, $com_estado)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "CALL SP_Editar_gcom(?,?,?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $com_nombre);
        $sql->bindValue(2, $com_comentario);
        $sql->bindValue(3, $com_estado, PDO::PARAM_INT);
        $sql->bindValue(4, $com_id, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }

    public function delete_grupocom($com_id)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "CALL SP_Editar_est_gcom(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $com_id, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }

    public function get_user_sincom()
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "CALL SP_Buscar_usu_singcom()";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }

    public function get_integrantes_all($com_id)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "CALL SP_Buscar_integrantesgcom(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $com_id, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }

    public function agregar_integrante($com_id, $usu_id)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "CALL SP_Editar_integrantegcom(?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $com_id, PDO::PARAM_INT);
        $sql->bindValue(2, $usu_id, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }

    public function delete_integrante($usu_id)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "CALL SP_Eliminar_integrantegcom(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_id, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
}
