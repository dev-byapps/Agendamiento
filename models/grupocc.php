<?php
class grupocc extends Conectar
{
    public function get_grupocc()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "CALL SP_Buscar_gcc()";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }

    public function get_grupocc_Inactivos()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "CALL SP_Buscar_gccInactivos()";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }

    public function insert_grupocc($cc_nombre, $cc_comentario, $cc_estado)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "CALL SP_Crear_gcc(?,?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $cc_nombre);
        $sql->bindValue(2, $cc_comentario);
        $sql->bindValue(3, $cc_estado, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }

    public function update_grupocc($cc_id, $cc_nombre, $cc_comentario, $cc_estado)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "CALL SP_Editar_gcc(?,?,?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $cc_nombre);
        $sql->bindValue(2, $cc_comentario);
        $sql->bindValue(3, $cc_estado, PDO::PARAM_INT);
        $sql->bindValue(4, $cc_id, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }

    public function delete_grupocc($cc_id)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "CALL SP_Eliminar_gcc(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $cc_id, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }

    public function get_grupocc_x_id($cc_id)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "CALL SP_Buscar_idgcc(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $cc_id, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }

    public function get_integrantes_all($cc_id)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "CALL SP_Buscar_ingrantesgcc(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $cc_id, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }

    public function get_user_sincc($cc_id)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "call SP_Buscar_usu_singcc(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $cc_id, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }

    public function agregar_integrante($usu_id, $cc_id)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "CALL SP_Editar_integrantegcc(?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_id, PDO::PARAM_INT);
        $sql->bindValue(2, $cc_id, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }

    public function delete_integrante($usucc_id)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "CALL SP_Eliminar_integrantegcc(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usucc_id, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
    
    public function integrantescc($grupo)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "CALL SP_Buscar_integrantesgrupocc(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $grupo, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }

}
