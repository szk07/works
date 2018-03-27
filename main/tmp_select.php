<!DOCTYPE html>
<html lang="ja">
 <head>
  <meta charset="utf-8">
  <title>Client Works</title>
  <link rel="stylesheet" href="../css/style.css">
  <link href="https://fonts.googleapis.com/css?family=Amatic+SC|Bubbler+One" rel="stylesheet">
 </head>
 <body id="works">
  <header>
   <h1><a href="./">Client Works</a></h1>
   <ul class="filter">
    <li><a href="./">ALL</a></li>
    <?php
    try{
     $tag_stmt->execute();
     while($trow = $tag_stmt->fetch(PDO::FETCH_ASSOC)){
      print '<li><a href="?tag='.$trow["tid"].'">'.$trow["tname"].'</a></li>'."\n";
     }
    }catch(PDOException $e){
     exit('読み込みエラーが発生しました。');
    }
    ?>
   </ul>
  </header>
  <main>
   <ul class="works-list">
    <?php
    try{
     $stmt->execute();
     while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
      if(strpos($select_tag, $row['id']) !== false){
       $tag = '';
       foreach(explode(',', $row['tag']) as $value) {
        $sql_tag = 'SELECT * FROM tags WHERE tid='.$value;
        $stmt_tag = $db->prepare($sql_tag);
        $stmt_tag->execute();
        $row_tag = $stmt_tag->fetch(PDO::FETCH_ASSOC);
        $tag .= '<li>'.$row_tag['tname'].'</li>';
       }
       print <<< EOD
       <li><a href="?id={$row['id']}">
       <article>
       <div class="image"><img src="imgs/{$row['thumb']}" alt="test"></div>
       <div class="caption">
        <h2>{$row['title']}</h2>
        <ul class="tag">{$tag}</ul>
       </div>
       </article>
       </a></li>
EOD;
      }
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
