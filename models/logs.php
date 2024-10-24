<?php
class Logs extends Conectar
{
    public function insert_logs($usu_id, $tipo, $detalle, $ip)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "CALL SP_Crear_logs(?,?,?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_id, PDO::PARAM_INT);
        $sql->bindValue(2, $tipo);
        $sql->bindValue(3, $detalle);
        $sql->bindValue(4, $ip);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }

}
