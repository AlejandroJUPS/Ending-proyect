<?php
declare(strict_types=1);
function db(): PDO {
 static $pdo=null;
 if ($pdo instanceof PDO) return $pdo;
 $file=__DIR__.'/.private/db-config.php';
 if (!is_file($file)) throw new RuntimeException('Configuración de base de datos pendiente.');
 $c=require $file;
 return $pdo=new PDO('mysql:host='.$c['host'].';port=3306;dbname='.$c['database'].';charset=utf8mb4',$c['user'],$c['password'],[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,PDO::ATTR_EMULATE_PREPARES=>false]);
}
