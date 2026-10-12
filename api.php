<?php
declare(strict_types=1);
require __DIR__.'/functions.php';header('Content-Type: application/json; charset=utf-8');header('Cache-Control: no-store');
function reply(bool $ok,string $message='',array $data=[]):never{echo json_encode(['ok'=>$ok,'message'=>$message]+$data,JSON_UNESCAPED_UNICODE);exit;}
if($_SERVER['REQUEST_METHOD']!=='POST')reply(false,'Método no permitido');
if(!hash_equals(csrf(),(string)($_POST['csrf']??'')))reply(false,'Sesión caducada; actualiza la página');
$a=(string)($_POST['action']??'');$username=trim((string)($_POST['username']??''));$password=(string)($_POST['password']??'');
try{
 if($a==='register'){
  if(!preg_match('/^[\p{L}\p{N}_-]{3,24}$/u',$username)||strlen($password)<8)reply(false,'Usuario de 3 a 24 caracteres y contraseña de al menos 8');
  $q=db()->prepare('INSERT INTO users(username,password_hash) VALUES(?,?)');$q->execute([$username,password_hash($password,PASSWORD_DEFAULT)]);session_regenerate_id(true);$_SESSION['uid']=(int)db()->lastInsertId();reply(true,'Cuenta creada');
 }
 if($a==='login'){
  $q=db()->prepare('SELECT id,password_hash FROM users WHERE username=?');$q->execute([$username]);$u=$q->fetch();if(!$u||!password_verify($password,$u['password_hash']))reply(false,'Credenciales incorrectas');session_regenerate_id(true);$_SESSION['uid']=(int)$u['id'];reply(true,'Sesión iniciada');
 }
 if($a==='logout'){$_SESSION=[];session_regenerate_id(true);reply(true,'Sesión cerrada');}
 $u=currentUser();if(!$u)reply(false,'Inicia sesión primero');
 if($a==='avatar'){$n=(int)($_POST['avatar']??0);if($n<1||$n>12)reply(false,'Avatar no válido');$q=db()->prepare('UPDATE users SET avatar=? WHERE id=?');$q->execute([$n,$u['id']]);reply(true,'Avatar actualizado');}
 if($a==='rename'){if(!preg_match('/^[\p{L}\p{N}_-]{3,24}$/u',$username))reply(false,'Nombre no válido');$q=db()->prepare('UPDATE users SET username=? WHERE id=?');$q->execute([$username,$u['id']]);reply(true,'Nombre actualizado');}
 if($a==='favorite'){$id=(string)($_POST['game']??'');$valid=array_column(games(),null,'id');if(!isset($valid[$id]))reply(false,'Juego no disponible');$q=db()->prepare('SELECT 1 FROM favorites WHERE user_id=? AND game_id=?');$q->execute([$u['id'],$id]);if($q->fetch()){$q=db()->prepare('DELETE FROM favorites WHERE user_id=? AND game_id=?');$q->execute([$u['id'],$id]);reply(true,'Eliminado de favoritos',['favorite'=>false]);}$q=db()->prepare('INSERT INTO favorites(user_id,game_id) VALUES(?,?)');$q->execute([$u['id'],$id]);reply(true,'Añadido a favoritos',['favorite'=>true]);}
 reply(false,'Acción desconocida');
}catch(PDOException $e){error_log($e->getMessage());reply(false,$e->getCode()==='23000'?'Ese nombre ya está en uso':'Error de base de datos');}catch(Throwable $e){error_log($e->getMessage());reply(false,'Error del servidor');}
