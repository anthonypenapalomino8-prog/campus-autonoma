
<?php

$host = getenv('DB_HOST') ?: 'localhost';
$port = getenv('DB_PORT') ?: '3306';
$dbname = getenv('DB_NAME') ?: 'sistema_ventas';
$user = getenv('DB_USER') ?: 'root';
$password = getenv('DB_PASSWORD') ?: '';

$opciones = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false
];

if ($host !== 'localhost' && $host !== '127.0.0.1') {
    $ca = __DIR__ . '/certificados/ca.pem';

    if (!file_exists($ca)) {
        error_log('No se encuentra el certificado CA de MySQL.');
        exit('Error de configuración de la base de datos.');
    }

    $opciones[PDO::MYSQL_ATTR_SSL_CA] = $ca;
    $opciones[PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT] = true;
}

try {
    $conexion = new PDO(
        "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4",
        $user,
        $password,
        $opciones
    );
} catch (PDOException $e) {
    error_log($e->getMessage());
    exit('No se pudo conectar con la base de datos.');
}
