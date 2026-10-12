<?php
declare(strict_types=1);
/** Devuelve una conexión PDO. El archivo privado se genera durante el despliegue. */
function ending_db(): PDO
{
    $path = __DIR__ . '/db-config.php';
    if (!is_file($path)) {
        throw new RuntimeException('No existe la configuración privada de MySQL.');
    }
    $config = require $path;
    if (!is_array($config)) {
        throw new RuntimeException('Configuración de MySQL inválida.');
    }
    foreach (['host', 'database', 'username', 'password'] as $key) {
        if (!isset($config[$key]) || !is_string($config[$key]) || $config[$key] === '') {
            throw new RuntimeException('Falta un parámetro de conexión.');
        }
    }
    $dsn = sprintf('mysql:host=%s;port=%d;dbname=%s;charset=utf8mb4', $config['host'], (int)($config['port'] ?? 3306), $config['database']);
    return new PDO($dsn, $config['username'], $config['password'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_TIMEOUT => 8,
    ]);
}
