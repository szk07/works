<!DOCTYPE html>
<html lang="ja">
 <head>
  <meta charset="utf-8">
  <title><?=$row['title'] ?>| Client Works</title>
  <link rel="stylesheet" href="../css/style.css">
  <link href="https://fonts.googleapis.com/css?family=Amatic+SC|Bubbler+One" rel="stylesheet">
 </head>
 <body id="works">
  <header>
   <h1><a href="./">Client Works</a></h1>
  </header>
  <main>
  <article>
   <section class="info">
    <div class="head">
     <h2><?=$row['title'] ?></h2>
     <ul>
      <?=$tag."\n" ?>
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
        <?=$scope."\n" ?>
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
      <dd><?=date('Y.m', strtotime($row['releaseDate'])) ?></dd>
     </dl>
    </div>
   </section>
   <section class="content">
    <div class="thumb"><img src="imgs/<?=$row['thumb'] ?>" alt=""></div>
    <div class="comment">
     <?=html_entity_decode($row['summary'], ENT_QUOTES)."\n" ?>
    </div>
   </section>
  </article>
  </main>
 </body>
</html>
