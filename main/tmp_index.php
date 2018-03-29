<!DOCTYPE html>
<html lang="ja">
 <head>
  <meta charset="utf-8">
  <title>Client Works</title>
  <link rel="stylesheet" href="../css/style.css">
  <link href="https://fonts.googleapis.com/css?family=Amatic+SC:400|Titillium+Web" rel="stylesheet">
 </head>
 <body id="works">
  <header>
   <h1><a href="./">Client Works</a></h1>
   <div class="filter">
    <ul>
     <li><a href="./">ALL</a></li>
     <?php
     try{
      $tag_stmt->execute();
      while($trow = $tag_stmt->fetch(PDO::FETCH_ASSOC)){
       $active = '';
       if(isset($tag)){
        if(strpos($trow['tid'], $tag) !== false){
         $active = ' class="active"';
        }
       }
       print '<li'.$active.'><a href="?tag='.$trow["tid"].'">'.$trow["tname"].'</a></li>'."\n";
      }
     }catch(PDOException $e){
      exit('読み込みエラーが発生しました。');
     }
     ?>
    </ul>
    <span id="filter-slide"></span>
   </div>
  </header>
  <main>
   <ul class="works-list">
    <?php
    function articleBody($row, $tag){
     print <<< EOD
     <li><a href="?id={$row['id']}">
      <article>
       <div class="image"><img src="imgs/{$row['thumb']}" alt="test"></div>
       <div class="label">
        <ul class="tag">{$tag}</ul>
        <h2>{$row['title']}</h2>
       </div>
      </article>
     </a></li>
EOD;
    }
    try{
     if(isset($select_tag)){
      while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
       if(strpos($select_tag, $row['id']) !== false){
        $tag = '';
        foreach(explode(',', $row['tag']) as $value) {
         $tname = articleTag($value);
         $tag .= '<li>'.$tname.'</li>';
        }
        articleBody($row, $tag);
       }
      }
     }else{
      while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
       $tag = '';
       foreach(explode(',', $row['tag']) as $value) {
        $tname = articleTag($value);
        $tag .= '<li>'.$tname.'</li>';
       }
       articleBody($row, $tag);
      }
     }
     $db = NULL;
    }catch(PDOException $e){
     exit('読み込みエラーが発生しました。');
    }
    ?>
   </ul>
  </main>
  <script src="http://code.jquery.com/jquery-3.1.1.min.js"></script>
  <script src="../js/works.js"></script>
 </body>
</html>
