<!DOCTYPE html>
<html lang="ja">
 <head>
  <meta charset="utf-8">
  <title><?=$row['title'] ?>| Client Works</title>
  <link rel="stylesheet" href="../css/style.css">
  <link href="https://fonts.googleapis.com/css?family=Titillium+Web" rel="stylesheet">
  <link href="https://fonts.googleapis.com/earlyaccess/notosansjapanese.css" rel="stylesheet">
 </head>
 <body id="works">
  <header>
   <h1><a href="./">Client Works</a></h1>
   <p class="flow"><?=$row['flow'] ?></p>
  </header>
  <main>
  <article class="content">
   <section class="info">
    <div class="head">
     <ul class="tag">
      <?=$tag."\n" ?>
     </ul>
     <h2><?=$row['title'] ?></h2>
    </div>
    <dl class="detail">
     <?php
     if($row['client']){
      print '<dt>Client</dt><dd>'.$row['client'].'</dd>'."\n\t";
     }
     if($row['url']){
      print '<dt>URL</dt><dd><a href="'.$row['url'].'" target="_blank">'.$row['url'].'</a></dd>'."\n";
     }
     ?>
     <dt>Scope</dt>
     <dd>
      <ul>
       <?=$scope."\n" ?>
      </ul>
     </dd>
     <?php
     if($row['source']){
      print '<dt>Source</dt><dd>'.$row['source'].'</dd>'."\n\t";
     }
     ?>
     <dt>DATE</dt>
     <dd><?=date('Y.m', strtotime($row['releaseDate'])) ?></dd>
    </dl>
   </section>
   <section class="body">
    <div class="thumb"><img src="imgs/<?=$row['thumb'] ?>" alt=""></div>
    <div class="comment">
     <?=html_entity_decode($row['summary'], ENT_QUOTES)."\n" ?>
    </div>
   </section>
  </article>
  <p class="back"><a href="./">back</a></p>
  </main>
 </body>
</html>
