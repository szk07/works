<?php
require_once '../../php/Connect.php';

$db = connect();
$sql = 'SELECT * FROM works ORDER BY releaseDate desc';
header('Content-type: application/json');
$json = json_encode($db->query($sql)->fetchAll(PDO::FETCH_ASSOC), JSON_UNESCAPED_UNICODE);
$obj = json_decode($json, true);


foreach ($obj as $post) {
?>
 <ul>
  <li><?=$post['title']?></li>
  <li><?=$post['client']?></li>
  <li><?=$post['url']?></li>
 </ul>
<?php
}
?>
