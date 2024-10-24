<?php
class Reconsola extends Conectar
{
    public function registrar($cam, $det, $est, $usu)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call sp_crear_reconsola(?,?,?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $cam, PDO::PARAM_INT);
        $sql->bindValue(2, $det);
        $sql->bindValue(3, $est, PDO::PARAM_INT);
        $sql->bindValue(4, $usu, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
}
?>