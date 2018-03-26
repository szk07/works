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
      while($trow = $tag_stmt->fetch(PDO::FETCH_ASSOC)){
       print '<li><a href="?tag='.$trow["tid"].'">'.$trow["tname"].'</a></li>'."\n";
      }
     }catch(PDOException $e){
      exit('読み込みエラーが発生しました。');
     }
     ?>
    </ul>
   </div>
  </header>
  <main>
   <ul>
    <?php
    try{
     while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
      $tag = '';
      foreach(explode(',', $row['tag']) as $value) {
       $sql_tag = 'SELECT * FROM tags WHERE tid='.$value;
       $stmt_tag = $db->prepare($sql_tag);
       $stmt_tag->execute();
       $row_tag = $stmt_tag->fetch(PDO::FETCH_ASSOC);
       $tag .= '<li>'.$row_tag['tname'].'</li>';
      }
print <<< EOD
      <li>
       <article>
        <h2>{$row['title']}</h2>
        <div class="tag">
         <ul>{$tag}</ul>
        </div>
        <div class="image"><img src="imgs/{$row['thumb']}" alt=""></div>
       </article>
      </li>

EOD;
     }
     $db = NULL;
    }catch(PDOException $e){
     exit('読み込みエラーが発生しました。');
    }
    ?>
   </ul>
  </main>
 </body>
</html>
