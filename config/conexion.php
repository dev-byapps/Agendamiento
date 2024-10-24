<?php
session_start();

class Conectar
{
    protected $dbh;

    public  function Conexion()
    {
        require_once __DIR__ . '/../path/config.php'; // Ruta al archivo Local
        // require_once '/var/www/config/config.php'; // Ruta al archivo servidor

        try {
            $conectar = $this->dbh = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
            return $conectar;

        } catch (Exception $e) {
            print "¡Error DB!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function set_names()
    {
        return $this->dbh->query("SET NAMES 'utf8'");
    }

    public static function ruta()
    {
        require_once __DIR__ . '/../path/config.php'; // Ruta al archivo Local
        // require_once '/var/www/config/config.php'; // Ruta al archivo servidor
        // return "https://conektamos.byapps.co/";
        return RUTA;
    }
}
