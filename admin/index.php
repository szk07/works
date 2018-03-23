<?php
session_start();
if(!$_SESSION['flug']){
 header('Location: ../');
 exit();
}

require_once '../php/Connect.php';
require_once '../php/Escape.php';

if(!empty($_POST)){
 $title = es($_POST['title']);
 $client = !empty($_POST['client']) ? es($_POST['client']) : '';
 $url = !empty($_POST['url']) ? es($_POST['url']) : '';
 $releaseDate = !empty($_POST['releaseDate']) ? es($_POST['releaseDate']) : '';
 $summary = es($_POST['summary']);
 if(!empty($_POST['tag']) && is_array($_POST['tag'])){
  $tag = implode(',', $_POST['tag']);
 }else{
  $tag = '';
 }
 if(!empty($_POST['scope']) && is_array($_POST['scope'])){
  $scope = implode(',', $_POST['scope']);
 }else{
  $scope = '';
 }
 $tmp = $_FILES['tmb']['tmp_name'];
 $tmb = mb_convert_encoding($_FILES['tmb']['name'], "SJIS-WIN", 'UTF-8');
 if(!move_uploaded_file($tmp, '../main/imgs/'.$tmb)){
  $upload_err = 'アップロードに失敗しました。';
 }
 if(isset($upload_err)){
  exit('<p>'.$upload_err.'</p>');
 }

 try{
  $db = connect();
  $sql = 'INSERT INTO works(title, client, url, releaseDate, tag, scope, thumb, summary)
          VALUES (:title, :client, :url, :releaseDate, :tag, :scope, :thumb, :summary)';
  $stmt = $db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
  $stmt->execute(array(':title' => $title,
                       ':client' => $client,
                       ':url' => $url,
                       ':releaseDate' => $releaseDate,
                       ':tag' => $tag,
                       ':scope' => $scope,
                       ':thumb' => $tmb,
                       ':summary' => $summary));
  $db = NULL;
 }catch(PDOException $e){
  exit('エラーが発生しました。');
 }
}
?>
<!DOCTYPE html>
<html lang="ja">
 <head>
  <meta charset="utf-8">
  <title>作品登録フォーム</title>
  <style media="screen">
   .wrap{
    width: 600px;
    margin: 30px auto;
   }
   form{
    margin-top: 50px;
   }
   dl{
    display: flex;
   }
   dt{
    text-align: center;
    width: 150px;
   }
   label{
    display: block;
   }
  </style>
 </head>
 <body>
  <div class="wrap">
   <h1>作品登録フォーム</h1>
   <p>ログイン: <?php print $_SESSION['user'].'/'.$_SESSION['flug']; ?></p>
   <ul>
    <li><a href="input.php">アカウント登録</a></li>
    <li><a href="../main">作品一覧ページ</a></li>
   </ul>
   <form action="" method="post" enctype="multipart/form-data">
    <dl>
     <dt>サイト名</dt>
     <dd><input type="text" name="title" required></dd>
    </dl>
    <dl>
     <dt>タグ</dt>
     <dd>
     <?php
     try{
      $db = connect();
      $tag_stmt = $db->prepare('SELECT * FROM tags');
      $tag_stmt->execute();
      while($trow = $tag_stmt->fetch(PDO::FETCH_ASSOC)){
       print '<label><input type="checkbox" name="tag[]" value="'.$trow["tid"].'">'.$trow["tname"].'</label>';
      }
      $db = NULL;
     }catch(PDOException $e){
      exit('読み込みエラーが発生しました。');
     }
     ?>
     </dd>
    </dl>
    <dl>
     <dt>クライアント</dt>
     <dd><input type="text" name="client"></dd>
    </dl>
    <dl>
     <dt>URL</dt>
     <dd><input type="url" name="url" value="http://"></dd>
    </dl>
    <dl>
     <dt>担当個所</dt>
     <dd>
      <?php
      try{
       $db = connect();
       $scope_stmt = $db->prepare('SELECT * FROM scopes');
       $scope_stmt->execute();
       while($srow = $scope_stmt->fetch(PDO::FETCH_ASSOC)){
        print '<label><input type="checkbox" name="scope[]" value="'.$srow["sid"].'">'.$srow["sname"].'</label>';
       }
       $db = NULL;
      }catch(PDOException $e){
       exit('読み込みエラーが発生しました。');
      }
      ?>
     </dd>
    </dl>
    <dl>
     <dt>公開日</dt>
     <dd><input type="date" name="releaseDate"></dd>
    </dl>
    <dl>
     <dt>サムネイル画像</dt>
     <dd><input type="file" name="tmb" required></dd>
    </dl>
    <textarea name="summary" rows="8" cols="80" required></textarea>
    <input type="submit" value="登録">
   </form>
  </div>
 </body>
</html>
