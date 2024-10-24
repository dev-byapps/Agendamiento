<?php
class Estadosent extends Conectar
{
    public function insert_estado($ent_id, $est_ent, $est_crm)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "CALL SP_Crear_estadoent(?,?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $ent_id, PDO::PARAM_INT);
        $sql->bindValue(2, $est_ent);
        $sql->bindValue(3, $est_crm);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
    public function update_estado($est_id, $est_ent, $est_crm)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "CALL SP_Editar_estadoent(?,?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $est_ent);
        $sql->bindValue(2, $est_crm);
        $sql->bindValue(3, $est_id, PDO::PARAM_INT);

        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }    
    public function activar($est_id)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "CALL SP_Editar_estadoentActivar(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $est_id);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
    public function get_estado_all($ent_id)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "CALL SP_Buscar_estadoent(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $ent_id, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }    
    public function listar_inactivos($ent_id)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "CALL SP_Buscar_estadoentInactivos(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $ent_id, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
    public function get_estado_x_id($est_id)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "CALL SP_Buscar_idestadoent(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $est_id, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
    public function delete_estado($est_id)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "CALL SP_Eliminar_estadoent(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $est_id, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
    public function estadosradicadosxentidad($entidad)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call SP_Buscar_estRadicadosxentidad(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $entidad, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
    public function obtenerestadoCRM($estado, $entidad)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call SP_Buscar_estadocrm(?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $estado);
        $sql->bindValue(2, $entidad);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
    public function estadoxentidad($entidad)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call SP_Buscar_estentidad(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $entidad, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
    public function obtenerestado($estado, $entidad)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call SP_Buscar_estestadocrm(?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $estado);
        $sql->bindValue(2, $entidad, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
}
