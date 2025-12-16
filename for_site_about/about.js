$(document).on('mousemove', 'body', function(){
   $('section').addClass('active');
 });

 $(document).on('mouseleave', 'body', function(){
  $('section').removeClass('active');
});