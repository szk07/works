$(function(){
 var $line = $('#filter-slide');
 var $active = $('.active');

 if($active[0]){
  $crLeft = $active.position().left;
  $crWidth = ($active.width()/2)+10;
  $activeLeft = $crLeft+$crWidth;
  $line.css('left', $activeLeft+'px');
 }
 $('.filter').find('li').hover(function(){
  $thisLeft = $(this).position().left;
  $thisWidth = ($(this).width()/2)+10;
  $hoverLeft = $thisLeft+$thisWidth;
  $line.css('left', $hoverLeft+'px');
 }, function(){
  if($active[0]){
   $crLeft = $active.position().left;
   $crWidth = ($active.width()/2)+10;
   $activeLeft = $crLeft+$crWidth;
   $line.css('left', $activeLeft+'px');
  }else{
   $line.css('left', '270px');
  }
 });
});
