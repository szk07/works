$(function(){
 $('.filter li > a').on('click', function(e){
  e.preventDefault();
  $.ajax({
   url: '../main/json.php',
   type: 'GET',
   dataType: 'json',
   success: function(data){
    var len = data.length;
    var html = '';
    for(var i=0; i<len; i++){
     var d = data[i];
     var tag = '';
     var tagAry = d.tag.split(',');
     console.log(tagAry);
     html += '<li><a href="?id='+d.id+'"><article>'+
              '<div class="image"><img src="imgs/'+d.thumb+'" alt=""></div>'+
              '<div class="label"><ul class="tag">tag</ul><h2>'+d.title+'</h2></div>'+
             '</article></a></li>';
    }
    $('.works-list').html(html);
   }
  });
 });
});
