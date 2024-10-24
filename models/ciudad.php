<?php
class Ciudad extends Conectar
{
    public function listar_ciudades()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "CALL SP_Buscar_ciudades()";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }

    public function insert_ciudad($ciudad, $departamento, $est_ciu)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "CALL SP_Crear_ciudad(?,?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $ciudad);
        $sql->bindValue(2, $departamento);
        $sql->bindValue(3, $est_ciu, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }

    public function update_ciudad($ciu_id, $ciudad, $departamento, $est_ciu)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "CALL SP_Editar_ciudad(?,?,?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $ciu_id, PDO::PARAM_INT);
        $sql->bindValue(2, $ciudad);
        $sql->bindValue(3, $departamento);
        $sql->bindValue(4, $est_ciu, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }

    public function eliminarciudad($id)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "CALL SP_Eliminar_ciudad(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $id, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }

    public function listarciuInac()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "CALL SP_Buscar_ciudadesInac()";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }

    public function buscar_ciudad($term)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "CALL SP_Buscar_ciudad(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $term);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
}
