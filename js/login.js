$(function(){
 var $input = $('.field input');
 $input.focus(function(){
  $(this).parents('.field').addClass('focus');
 });
 $input.blur(function(){
  if(!$(this).val()){
   $(this).parents('.field').removeClass('focus');
  }
 });
});
