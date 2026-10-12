<?php
declare(strict_types=1);
$phpOk = true;
$dbOk = false;
$dbMessage = 'No se pudo comprobar la conexión.';
try {
    require_once __DIR__ . '/db.php';
    $pdo = ending_db();
    $dbOk = ((int)$pdo->query('SELECT 1')->fetchColumn() === 1);
    $dbMessage = $dbOk ? 'Conexión y consulta de prueba correctas.' : 'La consulta de prueba no respondió correctamente.';
} catch (Throwable $e) {
    error_log('Ending DB diagnostic: ' . $e->getMessage());
    $dbMessage = 'Conexión no disponible. Revisa los secretos y el despliegue.';
}
$version = is_file(__DIR__ . '/deploy-version.txt') ? trim((string)file_get_contents(__DIR__ . '/deploy-version.txt')) : 'local / sin identificar';
function h(string $s): string { return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }
?><!doctype html>
<html lang="es"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Ending | Verificación inicial</title><style>
:root{color-scheme:dark}*{box-sizing:border-box}body{margin:0;min-height:100vh;background:radial-gradient(ellipse at top,#203457,#0a1020 65%);color:#f1f5f9;font-family:system-ui,-apple-system,Segoe UI,sans-serif;display:grid;place-items:center;padding:24px}.panel{width:min(100%,590px);background:#121c30;border:1px solid #34435d;border-radius:20px;padding:36px;box-shadow:0 20px 65px #0006}h1{font-size:2rem;margin:0 0 8px}.sub{color:#aab8d0;margin-bottom:28px}.item{display:flex;gap:14px;align-items:flex-start;background:#19263e;border-radius:12px;padding:17px;margin:12px 0}.mark{font-size:24px}.ok{color:#74e2a6}.fail{color:#ffb18f}strong{display:block}small{color:#afbdd3;display:block;margin-top:4px;line-height:1.5}.foot{border-top:1px solid #34435d;padding-top:18px;margin-top:24px;color:#afbdd3;font-size:13px;overflow-wrap:anywhere}code{color:#d9e8ff}a{color:#a9c8ff}
</style></head><body><main class="panel"><h1>Ending Project</h1><p class="sub">Prueba inicial de publicación y base de datos</p>
<div class="item"><span class="mark ok">✓</span><div><strong>PHP funcionando</strong><small>InfinityFree está ejecutando esta página PHP (versión <?=h(PHP_VERSION)?>).</small></div></div>
<div class="item"><span class="mark <?= $dbOk ? 'ok' : 'fail' ?>"><?= $dbOk ? '✓' : '!' ?></span><div><strong>MySQL: <?= $dbOk ? 'conectado' : 'pendiente' ?></strong><small><?=h($dbMessage)?></small></div></div>
<div class="item"><span class="mark ok">✓</span><div><strong>Página publicada</strong><small>Este archivo está disponible en el servidor. Comprueba la ejecución de GitHub Actions para confirmar que llegó mediante el flujo automático.</small></div></div>
<p class="foot">Versión desplegada: <code><?=h($version)?></code><br>Esta es una página temporal de diagnóstico; no requiere tablas MySQL.</p></main></body></html>
