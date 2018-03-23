<?php
require_once '../php/Connect.php';
require_once '../php/Escape.php';
error_reporting(E_ALL);

session_start();
if(!$_SESSION['user']){
 header('Location: ../');
 exit();
}

$page = '';
if(!$_GET){
 $page = 0;
}else if(isset($_GET['id'])){
 $id = es($_GET['id']);
 try{
  $db = connect();
  $stmt = $db->prepare('SELECT * FROM works WHERE id='.$id);
  $stmt->execute();
  if($row = $stmt->fetch(PDO::FETCH_ASSOC)){
   $page = 1;
   $tag = '';
   foreach(explode(',', $row['tag']) as $value) {
    $sql_tag = 'SELECT * FROM tags WHERE tid='.$value;
    $stmt_tag = $db->prepare($sql_tag);
    $stmt_tag->execute();
    $row_tag = $stmt_tag->fetch(PDO::FETCH_ASSOC);
    $tag .= '<li>'.$row_tag['tname'].'</li>';
   }
   $scope = '';
   foreach(explode(',', $row['scope']) as $value) {
    $sql_scope = 'SELECT * FROM scopes WHERE sid='.$value;
    $stmt_scope = $db->prepare($sql_scope);
    $stmt_scope->execute();
    $row_scope = $stmt_scope->fetch(PDO::FETCH_ASSOC);
    $scope .= '<li>'.$row_scope['sname'].'</li>';
   }
   $db = NULL;
  }else{
   $page = 0;
   $stmt = $db->prepare('SELECT * FROM works');
   $stmt->execute();
   $row = $stmt->fetch(PDO::FETCH_ASSOC);
  }
 }catch(PDOException $e){
  exit('読み込みエラーが発生しました。');
 }
}

switch ($page) {
 case 1: include('tmp_article.php');break;
 default: include('tmp_list.php');break;
}
$db = NULL;
