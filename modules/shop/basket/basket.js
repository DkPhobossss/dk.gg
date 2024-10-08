$(document).ready( function() {
   $('select[name="lang"]').on('change' , function(){
      document.location.href = 'basket?lang=' + $(this).find(':selected').val();
   });
});