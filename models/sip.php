<?php

class SIP extends Conectar
{
    public function dsip($usu_id){
        try {
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "CALL SP_Buscar_dsip(?)";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $usu_id, PDO::PARAM_INT);
            $sql->execute();
            
            // Verificar si hay resultados
            $resultado = $sql->fetchAll();
            if (empty($resultado)) {
                throw new Exception("No se encontraron resultados.");
            }
            
            unset($conectar);
            return $resultado;
        } catch (PDOException $e) {
            throw new Exception("Error en la base de datos: " . $e->getMessage());
        } catch (Exception $e) {
            throw $e; // Relanzar excepciones personalizadas
        }
    }
    
}