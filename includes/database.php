<?php

// Usamos ?? para dar un valor por defecto si la variable de entorno falla
$host = $_ENV['DB_HOST'] ?? 'mysql.railway.internal';
$user = $_ENV['DB_USER'] ?? 'root';
$pass = $_ENV['DB_PASS'] ?? 'OdsUxsqYyjLSWXSZOpFwxIIBpWyTUwad';
$name = $_ENV['DB_NAME'] ?? 'railway';
$port = $_ENV['DB_PORT'] ?? 3306;

// El orden es: host, user, password, database, port
$db = mysqli_connect($host, $user, $pass, $name, $port);

if (!$db) {
    echo "Error: No se pudo conectar a MySQL.";
    echo "error de depuración: " . mysqli_connect_error();
    exit;
}

$db->set_charset("utf8");