<?php
declare(strict_types=1);
require_once __DIR__.'/db.php';
if(session_status()!==PHP_SESSION_ACTIVE){ini_set('session.use_strict_mode','1');session_set_cookie_params(['httponly'=>true,'secure'=>!empty($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off','samesite'=>'Lax']);session_start();}
function h(string $v):string{return htmlspecialchars($v,ENT_QUOTES|ENT_SUBSTITUTE,'UTF-8');}
function csrf():string{return $_SESSION['csrf']??=bin2hex(random_bytes(24));}
function currentUser():?array{if(empty($_SESSION['uid']))return null;$q=db()->prepare('SELECT id,username,avatar FROM users WHERE id=?');$q->execute([$_SESSION['uid']]);return $q->fetch()?:null;}
function consoles():array{return ['nes'=>['NES','nes'],'snes'=>['SNES','snes'],'n64'=>['Nintendo 64','n64'],'gb'=>['Game Boy','gb'],'gbc'=>['Game Boy Color','gbc'],'gba'=>['Game Boy Advance','gba'],'psx'=>['PlayStation 1','psx'],'segaMD'=>['Mega Drive','segaMD']];}
function games():array{$out=[];$extensions=['nes','sfc','smc','z64','n64','v64','gb','gbc','gba','bin','cue','iso','chd','md','gen','smd','zip'];foreach(consoles() as $key=>$info){$folder=__DIR__.'/roms/'.$key;if(!is_dir($folder))continue;foreach(new DirectoryIterator($folder) as $f){if(!$f->isFile()||!in_array(strtolower($f->getExtension()),$extensions,true))continue;$name=$f->getFilename();$out[]=['id'=>hash('sha256',$key.'/'.$name),'name'=>pathinfo($name,PATHINFO_FILENAME),'file'=>$name,'console'=>$key,'label'=>$info[0],'core'=>$info[1],'url'=>'roms/'.rawurlencode($key).'/'.rawurlencode($name)];}}usort($out,fn($a,$b)=>strcasecmp($a['name'],$b['name']));return $out;}
