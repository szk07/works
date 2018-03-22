<?php
require_once 'php/Connect.php';
require_once 'php/Escape.php';
session_start();

if(!empty($_POST)){
 $user = es($_POST['user']);
 $pass = es($_POST['pass']);
 $error = '';

 try{
  $db = connect();
  $sql = 'SELECT * FROM account WHERE user="'.$user.'"';
  $stmt = $db->prepare($sql);
  $stmt->execute();
  if($account = $stmt->fetch(PDO::FETCH_ASSOC)){
   if(password_verify($pass, $account['pass'])){
    $_SESSION['user'] = $account['user'];
    $_SESSION['flug'] = $account['flug'] ? 1 : NULL;
    if($_SESSION['flug']){
     header('Location: admin/');
     exit;
    }
    header('Location: main/');
    exit();
   }else{
    $error = 'failed';
   }
  }else{
   $error = 'failed';
  }
  $db = NULL;
 }catch(PDOException $e){
  exit("システムエラーが発生しました。");
 }
}
?>
<!DOCTYPE html>
<html lang="ja">
 <head>
  <meta charset="utf-8">
  <title>ログイン｜Client Works｜Portfolio</title>
  <link rel="stylesheet" href="css/style.css">
 </head>
 <body>
  <main>
   <div class="login_wrap">
    <h1>Client Works</h1>
    <?php if($error) print '<p class="error">ログイン失敗しました。</p>'; ?>
    <form action="" method="post" class="admin">
     <div class="field">
      <input type="text" name="user" id="user">
      <label for="user">ID</label>
     </div>
     <div class="field">
      <input type="password" name="pass" id="pass">
      <label for="pass">Password</label>
     </div>
     <button type="submit">Login</button>
    </form>
   </div>
   <p class="note">非公開クライアントワークの閲覧にはログインが必要です。<br>
    閲覧をご希望の場合はメールフォームからご連絡ください。</p>
  </main>
  <script src="http://code.jquery.com/jquery-3.1.1.min.js"></script>
  <script src="js/login.js"></script>
 </body>
</html>
