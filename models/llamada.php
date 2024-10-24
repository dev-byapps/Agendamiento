<?php

class Llamada extends Conectar
{
    public function SIP($usu_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "CALL SP_Buscar_dsip(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_id, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }

    public function filtrar($fechaInicio, $fechaFin, $campana, $agente)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "CALL Sp_Crear_llamadas(?,?,?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $fechaInicio);
        $sql->bindValue(2, $fechaFin);
        $sql->bindValue(3, $campana, PDO::PARAM_INT);
        $sql->bindValue(4, $agente);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }

    public function listar_llamadas($fechaInicio, $fechaFin, $campana, $agente, $estado)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "CALL Sp_Buscar_Llamadas(?,?,?,?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $fechaInicio);
        $sql->bindValue(2, $fechaFin);
        $sql->bindValue(3, $campana, PDO::PARAM_INT);
        $sql->bindValue(4, $agente);
        $sql->bindValue(5, $estado);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }

    public function Bcomentario($idcli, $campana)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "CALL Sp_Buscar_comentario(?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $idcli, PDO::PARAM_INT);
        $sql->bindValue(2, $campana, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }

    public function clillamada($id_cli, $cam)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "CALL SP_Buscar_clillamada(?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $id_cli, PDO::PARAM_INT);
        $sql->bindValue(2, $cam, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }

    public function llamadasinUsuario($camp_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call Sp_Buscar_llamsinagente(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $camp_id);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }

    public function guardarsec($observaciones, $estado, $tabla, $id, $hora)
    {
        $conectar = parent::conexion();
        parent::set_names();
        try {
            $sql = "CALL Sp_Editar_llamadas(?,?,?,?,?)";
            $stmt = $conectar->prepare($sql);
            $stmt->bindValue(1, $observaciones);
            $stmt->bindValue(2, $estado);
            $stmt->bindValue(3, $tabla);
            $stmt->bindValue(4, $id, PDO::PARAM_INT);
            $stmt->bindValue(5, $hora);
            $stmt->execute();

            // Obtener el resultado de la consulta
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            // Enviar el resultado como JSON
            return $resultado; // Cambiado de `echo json_encode($resultado);` a `return $resultado;`
        } catch (Exception $e) {
            return array('status' => 'error', 'message' => $e->getMessage()); // Cambiado de `echo` a `return`
        } finally {
            unset($conectar);
        }
    }

    public function contactos($cam_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call Sp_Buscar_tabla(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $cam_id, PDO::PARAM_INT);
        try {
            $sql->execute();
            $resultado = $sql->fetch(PDO::FETCH_ASSOC);

            // Verificar si la consulta fue exitosa y retornó resultados
        if ($resultado) {
            // Devolver tanto Tcount como vacios
            return [
                'Tcount' => $resultado['Tcount'],
                'vacios' => $resultado['vacios']
            ];
        } else {
            // Retornar -1 si no hay resultados
            return [
                'Tcount' => -1,
                'vacios' => -1
            ];
        }

        } catch (PDOException $e) {
            // Manejar errores en caso de fallo
        return [
            'Tcount' => -1,
            'vacios' => -1
        ];
        }
        unset($conectar);
    }

    public function subirdatos($cam_id, $valores)
    {
        $conectar = parent::conexion();
        parent::set_names();

        // Convertir los valores adicionales a JSON
        $valores_json = json_encode($valores);

        $sql = "CALL SP_Editar_datostabla(?, ?)";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $cam_id, PDO::PARAM_INT);
        $stmt->bindValue(2, $valores_json, PDO::PARAM_STR);
        $stmt->execute();

        unset($conectar);
        return "Éxito";
    }

    public function agenteLlamada($usu_id, $nombreTabla)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call Sp_Editar_agentellamada(?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_id, PDO::PARAM_INT);
        $sql->bindValue(2, $nombreTabla);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }

    public function crear_agenda($idcampa,$idcli,$conve,$fecha,$hora,$usu){
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call Sp_Crear_agenda(?,?,?,?,?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $idcampa, PDO::PARAM_INT);
        $sql->bindValue(2, $idcli, PDO::PARAM_INT);
        $sql->bindValue(3, $conve);
        $sql->bindValue(4, $fecha);
        $sql->bindValue(5, $hora);
        $sql->bindValue(6, $usu, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
    
    public function listaragenda($usu){
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call Sp_Buscar_agenda(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }

    public function aum_intentos($cli, $camp){
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call Sp_Editar_intentos(?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $cli, PDO::PARAM_INT);
        $sql->bindValue(2, $camp, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
    
    public function validar_llamada($cli, $camp){
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call Sp_Validar_intentos(?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $cli, PDO::PARAM_INT);
        $sql->bindValue(2, $camp, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
    public function ingresoConsola($usu){
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call Sp_buscar_ultingresoconsola(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
}
