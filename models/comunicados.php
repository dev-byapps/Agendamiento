<?php
class Comunicados extends Conectar
{
    public function numero_comeninternos()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call SP_Buscar_numcominternos()";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }

    public function comunicadosInternos()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call SP_Buscar_comunicadosInter()";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        unset($conectar);
        return $resultado;
    }

    public function detallecomunicadosInternos($id_com)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call SP_Buscar_detcomunicadosInter(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $id_com);
        $sql->execute();
        $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        unset($conectar);
        return $resultado;
    }

    public function vencido()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call SP_Validar_vencimientocom()";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        unset($conectar);
        return $resultado;
    }

    public function buscarcomunicadosInternos()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call SP_Buscar_comunicadosIntertodos()";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        unset($conectar);
        return $resultado;
    }
    public function buscarcomunicados()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call SP_Buscar_comunicadosInter()";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        unset($conectar);
        return $resultado;
    }
    public function insert_comunicado($asunto, $clasi, $fcierre, $estado, $detalle, $usu)
    {
        // Obtener la información del archivo
        $fileInfo = pathinfo($_FILES["fileTest"]["name"]);
        // Obtener la extensión del archivo
        $fileExtension = $fileInfo["extension"];
        // Generar un identificador único para el archivo
        $idArchivo = uniqid();
        // Construir el nombre del archivo
        $file = $idArchivo . '.' . $fileExtension;
        //Ruta temporal a donde se carga el archivo
        $url_temp = $_FILES["fileTest"]["tmp_name"];
        //dirname(__FILE__) nos otorga la ruta absoluta hasta el archivo en ejecución
        $url_insert = dirname(__FILE__) . "/../documents/comunicados/"; //Carpeta donde subiremos nuestros archivos
        //Ruta donde se guardara el archivo, usamos str_replace para reemplazar los "\" por "/"
        $url_target = str_replace('\\', '/', $url_insert) . '/' . $file;
        //Si la carpeta no existe, la creamos
        if (!file_exists($url_insert)) {
            mkdir($url_insert, 0777, true);
        };
        //movemos el archivo de la carpeta temporal a la carpeta objetivo y verificamos si fue exitoso
        if (move_uploaded_file($url_temp, $url_target)) {
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "call SP_crear_comunicado(?,?,?,?,?,?,?)";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $asunto);
            $sql->bindValue(2, $clasi);
            $sql->bindValue(3, $fcierre);
            $sql->bindValue(4, $estado);
            $sql->bindValue(5, $detalle);
            $sql->bindValue(6, $usu);
            $sql->bindValue(7, $file);
            $sql->execute();
            $sql->fetchAll();
            unset($conectar);
        } else {
            echo "Fracaso";
        }
    }
    public function update_comunicado($idcom, $asunto, $detalle, $clasifi, $usu, $fcierre, $estado)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call SP_editar_comunicado(?,?,?,?,?,?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $idcom);
        $sql->bindValue(2, $asunto);
        $sql->bindValue(3, $detalle);
        $sql->bindValue(4, $clasifi);
        $sql->bindValue(5, $usu);
        $sql->bindValue(6, $fcierre);
        $sql->bindValue(7, $estado);
        $sql->execute();
        $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        unset($conectar);
        return $resultado;
    }
    public function cambiarestadoeliminado($comid)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call SP_Editar_comuni_estadoeliminado(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $comid);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }

}
