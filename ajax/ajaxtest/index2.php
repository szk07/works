<?php
/**
require_once '../../php/Connect.php';

$db = connect();
$sql = 'SELECT * FROM works ORDER BY releaseDate desc';
header('Content-type: application/json');
$json = json_encode($db->query($sql)->fetchAll(PDO::FETCH_ASSOC), JSON_UNESCAPED_UNICODE);
**/

$json = '[{"title": "サイトA","client": "顧客A","url": "アドレスA"},{"title": "サイトB","client": "顧客B","url": "アドレスB"}]';
$obj = json_decode($json, true);

function test($post){
return <<<EOD
<ul>
 <li>{$post['title']}</li>
 <li>{$post['client']}</li>
 <li>{$post['url']}</li>
</ul>
EOD;
}
?>
<!DOCTYPE html>
<html lang="ja" dir="ltr">
 <head>
  <meta charset="utf-8">
  <title></title>
 </head>
 <body>
  <?php
  foreach ($obj as $post) {
  	print $test = test($post);
  }
  ?>
 </body>
</html>
