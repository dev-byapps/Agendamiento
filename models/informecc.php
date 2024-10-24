<?php
class Informecc extends Conectar
{
    public function inf_llamadas($fechaInicio, $fechaFin, $campana, $asesor)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "CALL SP_Info_llamadas(?,?,?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $fechaInicio);
        $sql->bindValue(2, $fechaFin);
        $sql->bindValue(3, $campana);
        $sql->bindValue(4, $asesor);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }    
    public function inf_ragente($fechaInicio, $fechaFin, $grupo, $asesor)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "CALL SP_Info_RAgentes(?,?,?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $fechaInicio);
        $sql->bindValue(2, $fechaFin);
        $sql->bindValue(3, $grupo);
        $sql->bindValue(4, $asesor);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
    public function inf_base($campaña)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "CALL SP_Info_basecomp(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $campaña);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }    
    public function info_agenda($fechaInicio, $fechaFin, $grupo, $asesor)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "CALL SP_Info_agendacc(?,?,?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $fechaInicio);
        $sql->bindValue(2, $fechaFin);
        $sql->bindValue(3, $grupo);
        $sql->bindValue(4, $asesor);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
}
