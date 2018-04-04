<?php
/**
require_once '../../php/Connect.php';

$db = connect();
$sql = 'SELECT * FROM works ORDER BY releaseDate desc';
header('Content-type: application/json');
$json = json_encode($db->query($sql)->fetchAll(PDO::FETCH_ASSOC), JSON_UNESCAPED_UNICODE);
$obj = json_decode($json, true);
**/
$obj=array(
    array('タイトルA','顧客A','urlA'),
    array('タイトルB','顧客B','urlB'),
    array('タイトルC','顧客C','urlC')
);
function test($post){
return <<<EOD
<ul>
 <li>{$post[0]}</li>
 <li>{$post[1]}</li>
 <li>{$post[2]}</li>
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
