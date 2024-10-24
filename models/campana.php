<?php
class Campana extends Conectar
{
    public function todasCampanas()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call sp_Buscar_campanas()";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
    public function todasCampanasActivas()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call SP_Buscar_campanasActivas()";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
    public function campanasxusuario($usu_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call Sp_Buscar_Campanas_Usu(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_id, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
//se une con get_campana_x_id
    public function buscarcampana($camp_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call SP_Buscar_idcampana(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $camp_id, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
    public function campanasxusuarioActivas($usu_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call SP_Buscar_campanasact_usu(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_id, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
    public function campanasAdmin()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call SP_Buscar_camactivas()";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
    public function insert_campana($cam_nom, $fec_ini, $fec_fin, $hora_ini, $hora_fin, $grupocc, $cam_int, $cam_coment)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "call SP_Crear_campana(?,?,?,?,?,?,?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $cam_nom);
        $sql->bindValue(2, $fec_ini);
        $sql->bindValue(3, $fec_fin);
        $sql->bindValue(4, $hora_ini);
        $sql->bindValue(5, $hora_fin);
        $sql->bindValue(6, $grupocc, PDO::PARAM_INT);
        $sql->bindValue(7, $cam_int, PDO::PARAM_INT);
        $sql->bindValue(8, $cam_coment);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
    public function update_campana($cam_id, $cam_nom, $fec_ini, $fec_fin, $hora_ini, $hora_fin, $grupocc, $cam_int, $cam_coment, $cam_est)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "call SP_Editar_campana(?,?,?,?,?,?,?,?,?,?);";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $cam_nom);
        $sql->bindValue(2, $fec_ini);
        $sql->bindValue(3, $fec_fin);
        $sql->bindValue(4, $hora_ini);
        $sql->bindValue(5, $hora_fin);
        $sql->bindValue(6, $grupocc, PDO::PARAM_INT);
        $sql->bindValue(7, $cam_int, PDO::PARAM_INT);
        $sql->bindValue(8, $cam_coment);
        $sql->bindValue(9, $cam_est, PDO::PARAM_INT);
        $sql->bindValue(10, $cam_id, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
    public function get_campana_all()
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = " call SP_Buscar_campana_gcc()";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
    public function get_campana_all_Inactivas()
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = " call SP_Buscar_campana_gccEliminadas()";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
    public function delete_campanadef($cam_id)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "call SP_Eliminar_campana(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $cam_id, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
    public function agregarcolumnas($p_campana, $p_columnas, $p_valores)
    {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "CALL sp_Editar_columnas(?, ?, ?)";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $p_campana, PDO::PARAM_INT);
        $stmt->bindValue(2, json_encode($p_columnas), PDO::PARAM_STR);
        $stmt->bindValue(3, json_encode($p_valores), PDO::PARAM_STR);
        try {
            $stmt->execute();
            $resultado = $stmt->fetchAll();
            unset($conectar);
            return $resultado;
        } catch (PDOException $e) {
            echo "Error en la consulta: " . $e->getMessage();
            return false;
        }
    }
    public function cambiarestado($cam_id)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "call SP_Editar_campana_Activada(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $cam_id, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }    
    public function contcampact($usu_id)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "call SP_buscar_concampact(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_id, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }    
    public function agenda($usu_id)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "call SP_buscar_countagenda(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_id, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
}
