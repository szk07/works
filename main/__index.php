<?php
require_once '../php/Connect.php';
require_once '../php/Escape.php';

session_start();
if(!$_SESSION['user']){
 header('Location: ../');
 exit();
}

if($_GET['id']){
 $id = es($_GET['id']);
}

try{
 $db = connect();
 $stmt = $db->prepare('SELECT * FROM works WHERE id='.$id);
 $stmt->execute();
 $row = $stmt->fetch(PDO::FETCH_ASSOC);

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
?>
<!DOCTYPE html>
<html lang="ja">
 <head>
  <meta charset="utf-8">
  <title><?php print $row['title'] ?>| Client Works</title>
  <link rel="stylesheet" href="../css/style.css">
 </head>
 <body>
  <header>
   <h1>Client Works</h1>
  </header>
  <main>
  <article>
   <section class="info">
    <div class="head">
     <h2><?php print $row['title'] ?></h2>
     <ul>
      <?php print $tag."\n" ?>
     </ul>
    </div>
    <div class="detail">
     <?php
     if($row['client']){
      print '<dl><dt>Client</dt><dd>'.$row['client'].'</dd></dl>'."\n\t";
     }
     if($row['url']){
      print '<dl><dt>URL</dt><dd><a href="'.$row['url'].'" target="_blank">'.$row['url'].'</a></dd></dl>'."\n";
     }
     ?>
     <dl>
      <dt>Scope</dt>
      <dd>
       <ul>
        <?php print $scope ?>
       </ul>
      </dd>
     </dl>
     <?php
     if($row['source']){
      print '<dl><dt>Source</dt><dd>'.$row['source'].'</dd></dl>'."\n\t";
     }
     ?>
     <dl>
      <dt>DATE</dt>
      <dd><?php print date('Y.m', strtotime($row['releaseDate'])) ?></dd>
     </dl>
    </div>
   </section>
   <section class="content">
    <div class="thumb"><img src="imgs/<?php print $row['thumb'] ?>" alt=""></div>
    <div class="comment">
     <?php print html_entity_decode($row['summary'], ENT_QUOTES) ?>
    </div>
   </section>
  </article>
  </main>
  <?php
   $db = NULL;
  }catch(PDOException $e){
   exit('読み込みエラーが発生しました。');
  }
  ?>
 </body>
</html>
