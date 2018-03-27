<?php
require_once '../php/Connect.php';
require_once '../php/Escape.php';
error_reporting(E_ALL);

session_start();
if(!$_SESSION['user']){
 header('Location: ../');
 exit();
}

try{
 $db = connect();
 if(isset($_GET['id'])){
  $id = es($_GET['id']);
  $sql = 'SELECT * FROM works WHERE id='.$id;
  $stmt = $db->prepare($sql);
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
  }
 }else if(isset($_GET['tag'])){
  $page = 2;
  $tag = es($_GET['tag']);
 }else{
  $page = 0;
 }

 function stmtWorks(){
  global $db;
  $sql ='SELECT * FROM works ORDER BY releaseDate desc';
  return $stmt = $db->prepare($sql);
 }
 function stmtTags(){
  global $db;
  return $tag_stmt = $db->prepare('SELECT * FROM tags');
 }
 function selectTag($tag){
  global $db;
  $row_id = '';
  $select_stmt = $db->prepare('SELECT * FROM works');
  $select_stmt->execute();
  while($select_row = $select_stmt->fetch(PDO::FETCH_ASSOC)){
   if(strpos($select_row['tag'], $tag) !== false) $row_id .= $select_row['id'].' ';
  }
  return $row_id;
 }

 switch ($page) {
  case 1:
   include('tmp_article.php');
   break;
  case 2:
   $stmt = stmtWorks();
   $tag_stmt = stmtTags();
   $select_tag = selectTag($tag);
   include('tmp_select.php');
   break;
  default:
   $stmt = stmtWorks();
   $tag_stmt = stmtTags();
   include('tmp_index.php');
 }

 $db = NULL;
}catch(PDOException $e){
 exit('読み込み失敗しました。');
}
