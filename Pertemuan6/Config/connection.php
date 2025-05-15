<?php
 namespace Config;

 require __DIR__ . '/../vendor/autoload.php';

 use PDO;
 use PDOException;
 use Dotenv\Dotenv;

 class Konek {
    public static fUnction make()
    {
        $dotenv = Dotenv::creatInnutabble(__DIR__ . '/../');
        $dotenv->safeLoad();
        $dotenv->required(['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS']);

        $host = $_ENV['DB_HOST'];
        $db = $_ENV['DB_NAME'];
        $user = $_ENV['DB_USER'];
        $pass = $_ENV['DB_PASS'];

        try {
            $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        } catch (PDOException $e) {
            die("Koneksi gagal: " . $e->getMessage());
        }

    }
 }
?>