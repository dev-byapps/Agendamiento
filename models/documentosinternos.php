<?php

class Documentosinternos extends Conectar
{
    //-----CATEGORIAS-------------
    public function buscarcategorias()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call SP_Buscar_catdocint()";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        unset($conectar);
        return $resultado;
    }
    public function crearcategoria($nombre)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call SP_Crear_categoriadocin(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $nombre);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
    public function guardar_titulo($id_cat, $titulo)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call SP_Editar_titulocatdocint(?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $id_cat, PDO::PARAM_INT);
        $sql->bindValue(2, $titulo);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
    public function eliminarcategoria($idcat)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call SP_Eliminar_categoriadocin(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $idcat);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
    //----------------------------
    //-----DOCUMENTOS-------------
    public function documentosxidcat($id_cat, $label)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "CALL SP_Buscar_docinter_idcat(?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $id_cat, PDO::PARAM_INT);
        $sql->bindValue(2, $label);
        $sql->execute();
        $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        unset($conectar);
        return $resultado;
    }
    public function insert_docinterno($docnom, $cat, $cat_est, $usu_id)
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
        $url_insert = dirname(__FILE__) . "/../documents/docinternos"; //Carpeta donde subiremos nuestros archivos
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
            $sql = "call SP_Crear_docint(?,?,?,?,?)";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $docnom);
            $sql->bindValue(2, $cat, PDO::PARAM_INT);
            $sql->bindValue(3, $cat_est, PDO::PARAM_INT);
            $sql->bindValue(4, $file);
            $sql->bindValue(5, $usu_id, PDO::PARAM_INT);
            $sql->execute();
            $sql->fetchAll();
            unset($conectar);

        } else {
            echo "Fracaso";
        }
    }
    public function update_docinterno($docid, $docnom, $cat, $cat_est)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call SP_Editar_docintxid(?,?,?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $docid, PDO::PARAM_INT);
        $sql->bindValue(2, $docnom);
        $sql->bindValue(3, $cat, PDO::PARAM_INT);
        $sql->bindValue(4, $cat_est, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        unset($conectar);
        return $resultado;
    }
    public function cambiarestadoeliminado($docid)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call SP_Editar_docin_estadoeliminado(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $docid);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
    //----------------------------
}
