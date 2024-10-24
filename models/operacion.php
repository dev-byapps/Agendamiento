<?php

class Operacion extends Conectar
{
    public function filtrar_ope($fechaInicio, $fechaFin, $usu_perfil, $entidad, $grupo, $asesor, $filtro)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "CALL SP_Filtro_ope(?,?,?,?,?,?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_perfil);
        $sql->bindValue(2, $entidad);
        $sql->bindValue(3, $grupo);
        $sql->bindValue(4, $asesor);
        $sql->bindValue(5, $fechaInicio);
        $sql->bindValue(6, $fechaFin);
        $sql->bindValue(7, $filtro);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }

    public function filtrar_suma_ope($fechaInicio, $fechaFin, $usu_perfil, $entidad, $grupo, $asesor, $filtro)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "CALL SP_Filtro_sumaope(?,?,?,?,?,?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_perfil);
        $sql->bindValue(2, $entidad);
        $sql->bindValue(3, $grupo);
        $sql->bindValue(4, $asesor);
        $sql->bindValue(5, $fechaInicio);
        $sql->bindValue(6, $fechaFin);
        $sql->bindValue(7, $filtro);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }

    public function bopexno($noope, $ident)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "CALL SP_Buscar_openum(?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $noope);
        $sql->bindValue(2, $ident, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }

    public function insert_ope($ope_numero, $ope_operacion, $ope_entidad, $ope_sucursal, $ope_monto, $ope_maprobado, $ope_plazo, $ope_tasa, $ope_estadoOP, $ope_estado, $ope_feradicacion, $id_cli)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "CALL SP_Crear_Ope(?,?,?,?,?,?,?,?,?,?,?,?);";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $ope_numero);
        $sql->bindValue(2, $ope_operacion);
        $sql->bindValue(3, $ope_entidad, PDO::PARAM_INT);
        $sql->bindValue(4, $ope_sucursal, PDO::PARAM_INT);
        $sql->bindValue(5, $ope_monto);
        $sql->bindValue(6, $ope_maprobado);
        $sql->bindValue(7, $ope_plazo);
        $sql->bindValue(8, $ope_tasa);
        $sql->bindValue(9, $ope_estadoOP);
        $sql->bindValue(10, $ope_estado);
        $sql->bindValue(11, $ope_feradicacion);
        $sql->bindValue(12, $id_cli, PDO::PARAM_INT);
        $resultado = $sql->execute();
        unset($conectar);

        if ($resultado) {
            return true;
        } else {
            return false;
        }
    }

    public function update_operacion($ope_id, $ope_numero, $ope_operacion, $ope_sucursal, $ope_monto, $ope_maprobado, $ope_plazo, $ope_tasa, $ope_estadoOP, $ope_estado, $ope_festado, $ope_fcierre)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "call SP_Editar_Ope(?,?,?,?,?,?,?,?,?,?,?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $ope_id, PDO::PARAM_INT);
        $sql->bindValue(2, $ope_numero);
        $sql->bindValue(3, $ope_operacion);
        $sql->bindValue(4, $ope_sucursal, PDO::PARAM_INT);
        $sql->bindValue(5, $ope_monto);
        $sql->bindValue(6, $ope_maprobado);
        $sql->bindValue(7, $ope_plazo);
        $sql->bindValue(8, $ope_tasa);
        $sql->bindValue(9, $ope_estadoOP);
        $sql->bindValue(10, $ope_estado);
        $sql->bindValue(11, $ope_festado);
        $sql->bindValue(12, $ope_fcierre);

        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }

    public function idoperacion($noope, $ident)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "CALL SP_Buscar_ope(?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $noope);
        $sql->bindValue(2, $ident, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }

    public function mostrar($op_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "CALL SP_Buscar_opeid(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $op_id, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }

    public function validarDato($ope_num, $ope_entidad)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "CALL SP_Buscar_ope_ncodent(?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $ope_num);
        $sql->bindValue(2, $ope_entidad, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }

    public function listar_operaciones(
        $fechaInicio,
        $fechaFin,
        $usuPerfil,
        $fil_entidad,
        $fil_grupo,
        $fil_asesor,
        $estado,
        $filtro
    ) {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call SP_Buscar_operaciones(?,?,?,?,?,?,?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $fechaInicio);
        $sql->bindValue(2, $fechaFin);
        $sql->bindValue(3, $usuPerfil);
        $sql->bindValue(4, $fil_entidad);
        $sql->bindValue(5, $fil_grupo);
        $sql->bindValue(6, $fil_asesor);
        $sql->bindValue(7, $estado);
        $sql->bindValue(8, $filtro);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }

    public function listar_operaciones_x_cliente($cli_id)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "call SP_Buscar_ope_cliente(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $cli_id, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
}
