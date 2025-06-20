<?php

class Database {
    private static $instance = null;
    private $connection;
    private $host;
    private $username;
    private $password;
    private $database;

    private function __construct() {
        $this->host = $_ENV['DB_HOST'] ?? 'localhost';
        $this->username = $_ENV['DB_USER'] ?? 'root';
        $this->password = $_ENV['DB_PASSWORD'] ?? '';
        $this->database = $_ENV['DB_NAME'] ?? 'rifas_chile';

        try {
            $this->connection = new PDO(
                "mysql:host={$this->host};dbname={$this->database};charset=utf8mb4",
                $this->username,
                $this->password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]
            );
        } catch (PDOException $e) {
            error_log("Database connection error: " . $e->getMessage());
            throw new Exception("Error de conexión a la base de datos");
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->connection;
    }    public function query($sql, $params = []) {
        try {
            // Debug: Registrar la consulta SQL y los parámetros
            error_log("SQL Query: " . $sql);
            error_log("Params: " . print_r($params, true));
            
            $stmt = $this->connection->prepare($sql);
            
            // Si los parámetros son un array asociativo (con claves string), debemos usar bindValue
            if (is_array($params) && !empty($params) && is_string(key($params))) {
                foreach ($params as $key => $value) {
                    // Si la clave no tiene ':' al principio, añádelo
                    $paramName = (strpos($key, ':') === 0) ? $key : ':' . $key;
                    error_log("Binding: {$paramName} = " . var_export($value, true));
                    $stmt->bindValue($paramName, $value);
                }
                $stmt->execute();
            } else {
                // Para parámetros posicionales, ejecutar directamente
                error_log("Using positional params: " . print_r($params, true));
                $stmt->execute($params);
            }
            
            return $stmt;
        } catch (PDOException $e) {
            // Log detallado del error para diagnóstico
            error_log("Database query error: " . $e->getMessage() . " | CODE: " . $e->getCode());
            error_log("SQL: " . $sql);
            error_log("Params: " . print_r($params, true));
            error_log("Trace: " . $e->getTraceAsString());
            
            // En desarrollo, mostrar el error exacto - esto te ayudará a diagnosticar
            if (isset($_ENV['APP_ENV']) && $_ENV['APP_ENV'] === 'development') {
                throw new Exception("Error SQL: " . $e->getMessage());
            } else {
                throw new Exception("Error en la consulta de base de datos");
            }
        }
    }

    public function prepare($sql) {
        return $this->connection->prepare($sql);
    }

    public function lastInsertId() {
        return $this->connection->lastInsertId();
    }

    public function beginTransaction() {
        return $this->connection->beginTransaction();
    }

    public function commit() {
        return $this->connection->commit();
    }

    public function rollback() {
        return $this->connection->rollback();
    }
}
