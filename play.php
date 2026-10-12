<?php
require __DIR__.'/functions.php';$id=(string)($_GET['id']??'');$game=null;foreach(games() as $g){if(hash_equals($g['id'],$id)){$game=$g;break;}}if(!$game){http_response_code(404);exit('Juego no encontrado');}
?>
<!doctype html><html lang="es"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title><?=h($game['name'])?> · Ending</title><style>body{background:#080609;color:#fff;font:16px system-ui;margin:0}header{padding:15px 25px;background:#190b11;display:flex;gap:20px;align-items:center}a{color:#ff7188}#game{width:100%;height:calc(100vh - 70px);min-height:400px}</style></head><body><header><a href="index.php">← Volver</a><strong><?=h($game['name'])?></strong><span><?=h($game['label'])?></span></header><div id="game"></div><script>
window.EJS_player='#game';window.EJS_core=<?=json_encode($game['core'])?>;window.EJS_gameUrl=<?=json_encode($game['url'])?>;window.EJS_pathtodata='data/';window.EJS_startOnLoaded=true;
</script><script src="data/loader.js"></script></body></html>
