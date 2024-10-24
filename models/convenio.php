<?php
class Convenio extends Conectar
{
    public function buscar_convenios($entidad)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "CALL SP_Buscar_conveniosT(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $entidad, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }    
    public function buscarconveniosInactivos($entidad)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "CALL SP_Buscar_conveniosI(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $entidad, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
    public function insert_convenio($ent_id, $nom_conv, $con_est)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "CALL SP_Crear_convenioent(?,?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $ent_id, PDO::PARAM_INT);
        $sql->bindValue(2, $nom_conv);
        $sql->bindValue(3, $con_est);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
    public function update_convenio($con_id, $nom_conv, $con_est)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "CALL SP_Editar_convenioent(?,?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $con_id, PDO::PARAM_INT);
        $sql->bindValue(2, $nom_conv);
        $sql->bindValue(3, $con_est);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
    public function delete_convenio($idconv)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "CALL SP_Eliminar_convenio(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $idconv, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
    public function buscar_conveniosxparam($term, $entidad)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "CALL SP_Buscar_conveniosxparam(?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $entidad, PDO::PARAM_INT);
        $sql->bindValue(2, $term);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
}
