<?php
require_once 'config.php';

class Database
{
    private static $instance = null;
    private $connection;

    // Constructor privado para evitar instanciación externa
    private function __construct()
    {
        // Cadena de conexión TNS para Oracle (Evita depender del tnsnames.ora del servidor)
        $tns = "
        (DESCRIPTION =
            (ADDRESS = (PROTOCOL = TCP)(HOST = " . DB_HOST . ")(PORT = " . DB_PORT . "))
            (CONNECT_DATA =
                (SERVER = DEDICATED)
                (SERVICE_NAME = " . DB_NAME . ")
            )
        )";

        $dsn = "oci:dbname=" . $tns . ";charset=" . DB_CHARSET;

        try {
            $this->connection = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Excepciones en errores
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Fetch como array asociativo por defecto
                PDO::ATTR_PERSISTENT => true // Conexiones persistentes para mejor rendimiento
            ]);
        } catch (PDOException $e) {
            // Manejo centralizado. Nunca exponer detalles técnicos al usuario final.
            error_log("Fallo crítico en conexión Oracle: " . $e->getMessage());
            die(json_encode([
                'status' => 'error',
                'message' => 'Error de conexión a la base de datos. El incidente ha sido reportado.'
            ]));
        }
    }

    // Método principal del patrón Singleton
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    // Devuelve el objeto PDO
    public function getConnection()
    {
        return $this->connection;
    }

    // Prevenir clonación
    private function __clone() {}
}
