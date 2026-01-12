<?php


class Database
{
    private static ?PDO $pdo = null;

    public static function connect()
    {
        if (!self::$pdo) {
            $host = $_ENV['DB_HOST'];
            $db = $_ENV['DB_NAME'];
            $user = $_ENV['DB_USER'];
            $pwd = $_ENV['DB_PASS'];

            self::$pdo = new PDO(
                "mysql:host=$host;dbname=$db;charset=utf8",
                $user,
                $pwd
            );
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        }
        return self::$pdo;
    }
}