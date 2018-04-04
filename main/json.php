<?php
if(!(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])==='xmlhttprequest')){
 header('Location: ./');
 exit();
}

require_once '../php/Connect.php';
try{
 $db = connect();
 $sql = 'SELECT * FROM works';
 header('Content-type: application/json');
 echo json_encode($db->query($sql)->fetchAll(PDO::FETCH_ASSOC), JSON_UNESCAPED_UNICODE);
 $db = NULL;
}catch(PDOException $e){
 exit("読み込み失敗しました。:$e");
}
