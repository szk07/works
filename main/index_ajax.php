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

 // 共通ステートメント
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
 function articleTag($value){
  global $db;
  $sql_tag = 'SELECT * FROM tags WHERE tid='.$value;
  $stmt_tag = $db->prepare($sql_tag);
  $stmt_tag->execute();
  $row_tag = $stmt_tag->fetch(PDO::FETCH_ASSOC);
  return $row_tag['tname'];
 }

 if(isset($_GET['id'])){
  // 個別ページ
  $id = es($_GET['id']);
  $sql = 'SELECT * FROM works WHERE id='.$id;
  $stmt = $db->prepare($sql);
  $stmt->execute();
  if($row = $stmt->fetch(PDO::FETCH_ASSOC)){
   $page = 1;
   $tag = '';
   foreach(explode(',', $row['tag']) as $value) {
    $tname = articleTag($value);
    $tag .= '<li>'.$tname.'</li>';
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
 // }else if(isset($_GET['tag'])){
 //  // フィルター
 //  $page = 2;
 //  $tag = es($_GET['tag']);
 //  $stmt = stmtWorks();
 //  $stmt->execute();
 //  $tag_stmt = stmtTags();
 //  $tag_stmt->execute();
 //  $select_tag = selectTag($tag);
 }else{
  // 一覧
  $page = 0;
  $stmt = stmtWorks();
  $stmt->execute();
  $tag_stmt = stmtTags();
  $tag_stmt->execute();
 }

 switch ($page) {
  case 1: include('tmp_article.php');break;
  case 2: include('tmp_index.php');break;
  default: include('tmp_index_ajax.php');
 }

 $db = NULL;
}catch(PDOException $e){
 exit('読み込み失敗しました。');
}
