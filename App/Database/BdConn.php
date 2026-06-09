<?php

namespace App\Database;
use PDO;
require_once __DIR__ . '/../Support/config.php';

class BdConn
{
    private static $instance = null;

    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            try {
                $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
                $options = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8mb4'",
                ];

                self::$instance = new PDO(
                    $dsn,
                    DB_USER,
                    DB_PASS,
                    $options
                );
            } catch (\PDOException $e) {
                die('Erro de conexão: ' . $e->getMessage());
            }
        }
        return self::$instance;
    }

    public function __clone()
    {
        // Impede a clonagem da instância
        throw new \Exception("Clonagem de instância não permitida.");
    }

    public function __wakeup()
    {
        // Impede a desserialização da instância
        throw new \Exception("Desserialização de instância não permitida.");
    }

    public function __construct()
    {
        // Impede a criação de múltiplas instâncias
        if (self::$instance !== null) {
            throw new \Exception("Instância já existe. Use BdConn::getInstance() para obter a instância.");
        }
    }
}