<?php
    $host = $_ENV['DB_HOST'] ?? 'localhost';
    $user = $_ENV['DB_USER'] ?? 'root';
    $pass = $_ENV['DB_PASS'] ?? 'Mimi117117';
    $name = $_ENV['DB_NAME'] ?? 'APPSALON';
    $port =  $_ENV['DB_PORT'] ?? 21316;
$db = mysqli_connect(
    $host,
    $user,
    $pass, 
    $name,
    $port
);

$db->set_charset("utf8");

if (!$db) {
    echo "Error: No se pudo conectar a MySQL.";
    echo "errro de depuración: " . mysqli_connect_errno();
    echo "error de depuración: " . mysqli_connect_error();
    exit;
}
