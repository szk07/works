<?php
session_start();
if(!$_SESSION['flug']){
 header('Location: ../');
 exit();
}

require_once '../php/Connect.php';
require_once '../php/Escape.php';
?>
<!DOCTYPE html>
<html lang="ja">
 <head>
  <meta charset="utf-8">
  <title>登録変更選択</title>
  <style media="screen">
   .wrap{
    width: 600px;
    margin: 30px auto;
   }
   ul + ul{
    margin-top: 50px;
   }
  </style>
 </head>
 <body>
  <div class="wrap">
   <h1>登録変更選択</h1>
   <p>ログイン: <?php print $_SESSION['user'].'/'.$_SESSION['flug']; ?></p>
   <ul>
    <li><a href="./">作品登録</a></li>
    <li><a href="input.php">アカウント登録</a></li>
    <li><a href="../main">作品一覧ページ</a></li>
   </ul>
   <ul>
    <?php
    try{
     $db = connect();
     $stmt = $db->prepare('SELECT * FROM works');
     $stmt->execute();
     while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
      print '<li><a href="update_form.php?id='.$row['id'].'">'.$row['title'].'</a></li>';
     }
     $db = NULL;
    }catch(PDOException $e){
     exit('読み込みエラーが発生しました。');
    }
    ?>
   </ul>
  </div>
 </body>
</html>
