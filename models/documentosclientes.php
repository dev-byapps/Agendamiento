<?php

class Documentosclientes extends Conectar
{
    //----------CATEGORIAS------------
    public function buscarcategoriasdoccli($perfil)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call SP_Buscar_catdoccli(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $perfil);
        $sql->execute();
        $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        unset($conectar);
        return $resultado;
    }
    public function crearcategoriadoccli($nombre, $clascat)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call SP_Crear_categoriadoccli(?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $nombre);
        $sql->bindValue(2, $clascat);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
    public function guardar_titulo($id_cat, $titulo)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call SP_Editar_titulocatdoccli(?,?)";
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
        $sql = "call SP_Eliminar_categoriadoccli(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $idcat, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll();
        unset($conectar);
        return $resultado;
    }
    //--------------------------------
    //----------DOCUMENTOS------------
    public function documentosclixidcat($id_cat, $label, $usuPerfil, $id_cli)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "CALL SP_Buscar_doccli_idcat(?,?,?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $id_cat, PDO::PARAM_INT);
        $sql->bindValue(2, $label);
        $sql->bindValue(3, $usuPerfil);
        $sql->bindValue(4, $id_cli);
        $sql->execute();
        $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        unset($conectar);
        return $resultado;
    }
    public function insert_doccliente($idcli, $doc_nombre, $doc_clas, $doc_cat, $usu_id)
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
        $url_insert = dirname(__FILE__) . "/../documents/clientes/" . $idcli; //Carpeta donde subiremos nuestros archivos
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
            $sql = "call SP_Crear_doccli(?,?,?,?,?,?)";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $idcli, PDO::PARAM_INT);
            $sql->bindValue(2, $doc_nombre);
            $sql->bindValue(3, $file);
            $sql->bindValue(4, $doc_clas, PDO::PARAM_INT);
            $sql->bindValue(5, $doc_cat, PDO::PARAM_INT);
            $sql->bindValue(6, $usu_id, PDO::PARAM_INT);
            $sql->execute();
            $sql->fetchAll();
            unset($conectar);

        } else {
            echo "Fracaso";
        }
    }
    public function update_docinterno($doci_id, $doc_nombre, $doc_clas, $doc_cat)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "CALL SP_Editar_docclientedatos(?,?,?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $doci_id, PDO::PARAM_INT);
        $sql->bindValue(2, $doc_nombre);
        $sql->bindValue(3, $doc_clas, PDO::PARAM_INT);
        $sql->bindValue(4, $doc_cat, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        unset($conectar);
        return $resultado;
    }
    public function eliminardoc($iddoc)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "CALL SP_Eliminar_doccliente(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $iddoc, PDO::PARAM_INT);
        $sql->execute();
        $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        unset($conectar);
        return $resultado;
    }
    public function buscarclasificacion($perfil)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call SP_Buscar_clasdoccli()";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $perfil);
        $sql->execute();
        $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        unset($conectar);
        return $resultado;
    }
    //--------------------------------
}
