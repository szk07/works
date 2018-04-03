<?php
session_start();
if(!$_SESSION['flug']){
 header('Location: ../');
 exit();
}

require_once '../php/Connect.php';
require_once '../php/Escape.php';
$id = es($_GET['id']);

if(!empty($_POST)){
 $title = es($_POST['title']);
 $client = !empty($_POST['client']) ? es($_POST['client']) : '';
 $url = !empty($_POST['url']) ? es($_POST['url']) : '';
 $releaseDate = !empty($_POST['releaseDate']) ? es($_POST['releaseDate']) : '';
 $source = !empty($_POST['source']) ? es($_POST['source']) : '';
 $flow = es($_POST['flow']);
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
 $tmb = es($_POST['tmb']);

 try{
  $db = connect();
  $sql = 'UPDATE works
          SET id=:id ,title=:title, client=:client, url=:url,releaseDate=:releaseDate,
              tag=:tag, scope=:scope, source=:source, thumb=:thumb, flow=:flow, summary=:summary
          WHERE id=:id';
  $stmt = $db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
  $stmt->execute(array(':id' => $id,
                       ':title' => $title,
                       ':client' => $client,
                       ':url' => $url,
                       ':releaseDate' => $releaseDate,
                       ':tag' => $tag,
                       ':scope' => $scope,
                       ':source' => $source,
                       ':thumb' => $tmb,
                       ':flow' => $flow,
                       ':summary' => $summary));
  $db = NULL;
 }catch(PDOException $e){
  exit("error: $e");
 }
}

try{
 $db = connect();
 $stmt = $db->prepare('SELECT * FROM works WHERE id='.$id);
 $stmt->execute();
 $row = $stmt->fetch(PDO::FETCH_ASSOC);
 $db = NULL;
}catch(PDOException $e){
 exit('読み込みエラーが発生しました。');
}
?>
<!DOCTYPE html>
<html lang="ja">
 <head>
  <meta charset="utf-8">
  <title>登録変更</title>
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
  input:not([type=checkbox]){
   width: 300px;
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
   <form action="<?= '?id='.$id ?>" method="post" enctype="multipart/form-data">
    <dl>
     <dt>サイト名</dt>
     <dd><input type="text" name="title" value="<?=$row['title']?>"></dd>
    </dl>
    <dl>
     <dt>クライアント</dt>
     <dd><input type="text" name="client" value="<?=$row['client']?>"></dd>
    </dl>
    <dl>
     <dt>URL</dt>
     <dd><input type="url" name="url" value="<?=$row['url']?>"></dd>
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
       $ck = '';
       if(strpos($row['tag'], $trow['tid']) !== false){
        $ck = ' checked';
       }
       print '<label><input type="checkbox" name="tag[]" value="'.$trow["tid"].'"'.$ck.'>'.$trow["tname"].'</label>';
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
     <dd><input type="date" name="releaseDate" value="<?=$row['releaseDate']?>"></dd>
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
        $ck = '';
        if(strpos($row['scope'], $srow['sid']) !== false){
         $ck = ' checked';
        }
        print '<label><input type="checkbox" name="scope[]" value="'.$srow["sid"].'"'.$ck.'>'.$srow["sname"].'</label>';
       }
       $db = NULL;
      }catch(PDOException $e){
       exit('読み込みエラーが発生しました。');
      }
      ?>
     </dd>
    </dl>
    <dl>
     <dt>制作会社</dt>
     <dd><input type="text" name="source" value="<?=$row['source']?>"></dd>
    </dl>
    <dl>
     <dt>サムネイル画像</dt>
     <dd><input type="text" name="tmb" value="<?=$row['thumb']?>"></dd>
    </dl>
    <dl>
     <dt>制作フロー<br>（100文字程度）</dt>
     <dd><input type="text" name="flow" maxlength="200" value="<?=$row['flow']?>"></dd>
    </dl>
    <textarea name="summary" rows="8" cols="80">
     <?=html_entity_decode($row['summary'], ENT_QUOTES)?>
    </textarea>
    <input type="submit" value="登録">
   </form>
  </div>
 </body>
</html>
