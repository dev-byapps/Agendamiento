<?php
class Sucursal extends Conectar
{
    public function insert_sucursal($ent_id, $cod_suc, $nom_suc, $est_suc, $dept_suc, $city_suc)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "CALL SP_Crear_sucursal(?,?,?,?,?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $ent_id, PDO::PARAM_INT);
        $sql->bindValue(2, $cod_suc);
        $sql->bindValue(3, $nom_suc);
        $sql->bindValue(4, $est_suc, PDO::PARAM_INT);
        $sql->bindValue(5, $dept_suc);
        $sql->bindValue(6, $city_suc);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
    public function update_sucursal($suc_id, $cod_suc, $nom_suc, $est_suc, $dept_suc, $city_suc)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "CALL SP_Editar_sucursal(?,?,?,?,?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $suc_id, PDO::PARAM_INT);
        $sql->bindValue(2, $cod_suc);
        $sql->bindValue(3, $nom_suc);
        $sql->bindValue(4, $est_suc, PDO::PARAM_INT);
        $sql->bindValue(5, $dept_suc);
        $sql->bindValue(6, $city_suc);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
    public function buscar_sucursales($ent_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call SP_Buscar_sucursales(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $ent_id, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }    
    public function listarsucInac($ent_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call SP_Buscar_sucursalesInactivas(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $ent_id, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
    public function buscarsucursalxid($suc_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call SP_Buscar_idsucursales(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $suc_id, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
    public function eliminar_sucursal($suc_id)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "CALL SP_Eliminar_sucursal(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $suc_id, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
    public function listar_sucursales($entidad)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "CALL SP_Buscar_sucursalesent(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $entidad, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
}
