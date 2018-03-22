<?php
session_start();
if(!$_SESSION['flug']){
 header('Location: ../');
 exit();
}

require_once '../php/Connect.php';
require_once '../php/Escape.php';

if(!empty($_POST)){
 $user = es($_POST['user']);
 $pass = password_hash(es($_POST['pass']), PASSWORD_DEFAULT);
 $flug = !empty($_POST['flug']) ? 1 : 0;

 try{
  $db = connect();
  $sql = 'INSERT INTO account(user, pass, flug) VALUES (:user, :pass, :flug)';
  $stmt = $db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
  $stmt->execute(array(':user' => $user, ':pass' => $pass, ':flug' => $flug));
  $db = NULL;
 }catch(PDOException $e){
  exit('エラーが発生しました。');
 }
}

function random($length = 8){
 return substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstuvwxyz', $length)), 0, $length);
}
?>
<!DOCTYPE html>
<html lang="ja">
 <head>
  <meta charset="utf-8">
  <title>アカウント登録フォーム</title>
  <style media="screen">
   body{
    background: #eee;
   }
   .wrap{
    width: 600px;
    margin: 30px auto 0;
   }
   form{
    margin-top: 50px;
   }
   label{
    display: block;
    margin: 30px 0;
   }
  </style>
 </head>
 <body>
  <div class="wrap">
   <h1>アカウント登録フォーム</h1>
   <p>ログイン: <?php print $_SESSION['user'].'/'.$_SESSION['flug']; ?></p>
   <ul>
    <li><a href="./">作品登録</a></li>
    <li><a href="../main">作品一覧ページ</a></li>
   </ul>
   <form action="" method="post">
    <dl>
     <dt>ユーザー名</dt>
     <dd><input type="text" name="user"></dd>
    </dl>
    <dl>
     <dt>パスワード</dt>
     <dd><input type="text" name="pass" value="<?php print random(); ?>"></dd>
    </dl>
    <label><input type="checkbox" name="flug" value="1">管理者フラグを付ける</label>
    <input type="submit" value="登録">
   </form>
  </div>
 </body>
</html>
