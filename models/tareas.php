<?php

class Tareas extends Conectar
{
    public function listarcategoria()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "CALL SP_Buscar_cattareas()";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }

    public function listartareas($usu_id, $fechaInicio, $fechaFin, $cattarea, $tarestado)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "CALL SP_Buscar_tareas(?,?,?,?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_id, PDO::PARAM_INT);
        $sql->bindValue(2, $fechaInicio);
        $sql->bindValue(3, $fechaFin);
        $sql->bindValue(4, $cattarea, PDO::PARAM_INT);
        $sql->bindValue(5, $tarestado, PDO::PARAM_INT);

        $sql->execute();
        $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        unset($conectar);
        return $resultado;
    }

    public function listartareasinicio($usu_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "CALL SP_Buscar_tareasInicio(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_id, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        unset($conectar);
        return $resultado;
    }    

    public function listar($usu_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "CALL SP_Buscar_tareasxusuario(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_id, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        unset($conectar);
        return $resultado;
    }

    public function delete_tarea($id_tar)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "CALL SP_Eliminar_tareas(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $id_tar, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        unset($conectar);
        return $resultado;
    }

    public function numtareas($usu_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "CALL SP_Buscar_numtareasxusuario(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_id, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }

    public function listarcattareas()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "CALL SP_Buscar_cattareas()";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }

    public function editar_tarea($idtarea, $asunto, $detalle, $comentario, $cliente, $cattarea, $prio, $fechaven, $estadotarea)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "CALL SP_Editar_tarea(?,?,?,?,?,?,?,?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $idtarea, PDO::PARAM_INT);
        $sql->bindValue(2, $asunto);
        $sql->bindValue(3, $detalle);
        $sql->bindValue(4, $comentario);
        $sql->bindValue(5, $cliente);
        $sql->bindValue(6, $cattarea);
        $sql->bindValue(7, $prio);
        $sql->bindValue(8, $fechaven);
        $sql->bindValue(9, $estadotarea);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }

    public function crear_tarea($tareasun, $detalle, $comen,$asignadoa, $cli, $cat, $tareaprio, $fechaven, $estadotarea, $usuid)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "CALL SP_Crear_tarea(?,?,?,?,?,?,?,?,?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $tareasun);
        $sql->bindValue(2, $detalle);
        $sql->bindValue(3, $comen);
        $sql->bindValue(4, $asignadoa, PDO::PARAM_INT);
        $sql->bindValue(5, $cli, PDO::PARAM_INT);
        $sql->bindValue(6, $cat, PDO::PARAM_INT);
        $sql->bindValue(7, $tareaprio, PDO::PARAM_INT);
        $sql->bindValue(8, $fechaven);
        $sql->bindValue(9, $estadotarea, PDO::PARAM_INT);
        $sql->bindValue(10, $usuid, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }

    public function crear_categoria($categoria, $estado)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "CALL SP_Crear_cattarea(?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $categoria);
        $sql->bindValue(2, $estado, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }

    public function editar_categoria($id, $categoria, $estado)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "CALL SP_Editar_cattarea(?,?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $id, PDO::PARAM_INT);
        $sql->bindValue(2, $categoria);
        $sql->bindValue(3, $estado, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }

    public function delete_cat($id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "CALL SP_Eliminar_cattareas(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $id, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        unset($conectar);
        return $resultado;
    }
    
    public function listarcategoriaInac()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "CALL SP_Buscar_cattareasInac()";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }

    public function listartareascli($cli, $usu, $perfil)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "CALL SP_Buscar_tareascli(?,?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $cli, PDO::PARAM_INT);
        $sql->bindValue(2, $usu, PDO::PARAM_INT);
        $sql->bindValue(3, $perfil);
        $sql->execute();
        $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        unset($conectar);
        return $resultado;
    }

    public function get_usuterm($term, $perfil, $usuario)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call SP_Buscar_usutarea(?,?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $term);
        $sql->bindValue(2, $perfil);
        $sql->bindValue(3, $usuario);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
}
