<?php
class Informe extends Conectar
{
    public function inf_consultas($fechaInicio, $fechaFin, $fil_entidad, $fil_grupo, $fil_asesor)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "CALL SP_Info_consultas(?,?,?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $fechaInicio);
        $sql->bindValue(2, $fechaFin);
        $sql->bindValue(3, $fil_entidad);
        $sql->bindValue(4, $fil_grupo);
        $sql->bindValue(5, $fil_asesor);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
    public function inf_operaciones($fechaInicio, $fechaFin, $fil_entidad_ope, $fil_grupo_ope, $fil_asesor_ope)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "CALL SP_Info_operaciones(?,?,?,?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $fechaInicio);
        $sql->bindValue(2, $fechaFin);
        $sql->bindValue(3, $fil_entidad_ope);
        $sql->bindValue(4, $fil_grupo_ope);
        $sql->bindValue(5, $fil_asesor_ope);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }

}
