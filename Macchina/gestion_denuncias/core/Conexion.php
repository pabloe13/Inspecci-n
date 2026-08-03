<?php
/* * Clase Conexion (Singleton) * Configurada específicamente para Oracle (PDO_OCI) */
class Conexion
{
    private static $instance = null;
    private $pdo;

    private function __construct()
    {
        // Credenciales compartidas
        $host = "192.168.25.7";
        $port = "1522";
        $sid = "NEWDESA";
        $username = "DENUNCIAS";
        $password = "m9wn3kW7N";

        try {
            $tns = "oci:dbname=//$host:$port/$sid;charset=AL32UTF8";
            $this->pdo = new PDO($tns, $username, $password);

            // Configuraciones de errores y compatibilidad de minúsculas
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);

            // El antídoto para el ORA-01722 en lectura/escritura de coordenadas
            $this->pdo->exec("ALTER SESSION SET NLS_NUMERIC_CHARACTERS = '.,'");
        } catch (PDOException $e) {
            die(json_encode([
                "status" => "error",
                "mensaje" => "Error de Conexión Oracle: " . $e->getMessage()
            ]));
        }
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Conexion();
        }
        return self::$instance;
    }

    public function getPdo()
    {
        return $this->pdo;
    }
}
