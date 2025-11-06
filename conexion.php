<?php
$host = 'localhost';
$db   = 'portivoo';
$user = 'root';
$pass = ''; // Contraseña de XAMPP por defecto
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch(PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
    exit;
}
?>
