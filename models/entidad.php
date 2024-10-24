<?php
class Entidad extends Conectar
{
    public function insert_entidad($ent_nombre, $ent_coment, $ent_estado)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "CALL SP_Crear_entidad(?,?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $ent_nombre);
        $sql->bindValue(2, $ent_coment);
        $sql->bindValue(3, $ent_estado, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
    public function update_entidad($ent_id, $ent_nombre, $ent_coment, $ent_estado)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "CALL SP_Editar_entidad(?,?,?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $ent_nombre);
        $sql->bindValue(2, $ent_coment);
        $sql->bindValue(3, $ent_estado, PDO::PARAM_INT);
        $sql->bindValue(4, $ent_id, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
    public function get_entidad_all()
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "CALL SP_Buscar_entidades()";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
    public function listarInactivos()
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "CALL SP_Buscar_entidadesInactivos()";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
    public function get_entidad_x_id($ent_id)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "CALL SP_Buscar_entidadid(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $ent_id, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
    public function delete_entidad($ent_id)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "CALL SP_Eliminar_entidad(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $ent_id, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
    public function get_entidad()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "CALL SP_Buscar_entidad()";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
    public function identidad($entidad)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call SP_Buscar_identidad(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $entidad);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
}
