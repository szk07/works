<!DOCTYPE html>
<html lang="ja">
 <head>
  <meta charset="utf-8">
  <title>test</title>
 </head>
 <body>
  <h1>Ajax実装テスト</h1>
  <p><input type="button" value="test"></p>
  <p id="ajax">読み込み前テキスト</p>

  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script>
   $(function(){
    $('input').on('click', function(){
     $.ajax({
      url: 'test/json.json',
      dataType: 'json',
      success: function(json){
       $('#ajax').append('<p>読み込み成功しました。</p>');
      },
      error: function(json){
       $('#ajax').append('<p>読み込み失敗しました。</p>');
      }
     });
    })
   });
  </script>
 </body>
</html>
