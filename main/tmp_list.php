<!DOCTYPE html>
<html lang="ja">
 <head>
  <meta charset="utf-8">
  <title>Client Works</title>
  <link rel="stylesheet" href="../css/style.css">
 </head>
 <body>
  <header>
   <h1>Client Works</h1>
   <div class="filter">
    <ul>
     <li><a href="./">ALL</a></li>
     <?php
     try{
      $db = connect();
      $tag_stmt = $db->prepare('SELECT * FROM tags');
      $tag_stmt->execute();
      while($trow = $tag_stmt->fetch(PDO::FETCH_ASSOC)){
       print '<li><a href="?tag='.$trow["tid"].'">'.$trow["tname"].'</a></li>'."\n";
      }
      $db = NULL;
     }catch(PDOException $e){
      exit('読み込みエラーが発生しました。');
     }
     ?>
    </ul>
   </div>
  </header>
  <main>
  </main>
 </body>
</html>
