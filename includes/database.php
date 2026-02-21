<?php

$host = $_ENV['DB_HOST'] ?? '127.0.0.1'; 
$user = $_ENV['DB_USER'] ?? 'root';
$pass = $_ENV['DB_PASS'] ?? 'Mimi117117';
$name = $_ENV['DB_NAME'] ?? 'APPSALON';
$port = $_ENV['DB_PORT'] ?? 3306;

// El truco está en asegurar que el host y el puerto sean correctos
$db = mysqli_connect($host, $user, $pass, $name, $port);

// ESTO ES NUEVO: Forzamos el set de caracteres
if ($db) {
    mysqli_set_charset($db, "utf8");
}

if (!$db) {
    echo "Error: No se pudo conectar a MySQL.";
    echo "error de depuración: " . mysqli_connect_error();
    exit;
}