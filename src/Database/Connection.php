<?php

namespace App\Database;

use PDO;
use PDOException;

class Connection
{
    private static ?PDO $instance = null;

    public static function get(): PDO
    {
        if (self::$instance === null) {
            $host = '127.0.0.1';
            $db   = 'catalogo_db';
            $user = 'root'; // seu usuário do banco
            $pass = 'adR123';     // sua senha do banco

            try {
                self::$instance = new PDO(
                    "mysql:host={$host};dbname={$db};charset=utf8mb4",
                    $user,
                    $pass,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES => false,
                    ]
                );
            } catch (PDOException $e) {
                die("Erro na conexão com o banco de dados: " . $e->getMessage());
            }
        }

        return self::$instance;
    }
}