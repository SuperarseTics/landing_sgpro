<?php
// app/core/Database.php

class Database {
    private static $instance = null;
    private $pdo;

    private function __construct() {
        // Carga las credenciales de configuración
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME;
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (\PDOException $e) {
            // Muestra un error si la conexión falla
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    // Método para obtener la única instancia de la clase (Patrón Singleton)
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    // Método para obtener el objeto PDO
    public function getConnection() {
        return $this->pdo;
    }
}