$.fn.extend({
  insertAtCaret: function(myValue){
  var obj;
  if( typeof this[0].name !='undefined' ) obj = this[0];
  else obj = this;

  if ($.browser.msie) {
    obj.focus();
    sel = document.selection.createRange();
    sel.text = myValue;
    obj.focus();
    }
  else if ($.browser.mozilla || $.browser.webkit || $.browser.opera ) {
    var startPos = obj.selectionStart;
    var endPos = obj.selectionEnd;
    var scrollTop = obj.scrollTop;
    obj.value = obj.value.substring(0, startPos)+myValue+obj.value.substring(endPos,obj.value.length);
    obj.focus();
    obj.selectionStart = startPos + myValue.length;
    obj.selectionEnd = startPos + myValue.length;
    obj.scrollTop = scrollTop;
  } else {
    obj.value += myValue;
    obj.focus();
   }
 }
})

$(document).ready(function() {
   $('div.smiley_container a.show_more').one('click' , function() {
      $(this).closest('div.smiley_container').find('img[code]:hidden').css('display' , 'inline-block');
      $(this).remove();
   });
   
   $('div.smiley_container img[code]').click(function() {
        if ( $( smiley_selector ).is(':focus') )
        {
        //.focus(); 
        }
        else
        {
            
        }
        
        $( smiley_selector ).insertAtCaret( ' ' + $(this).attr('code') );
      //$( smiley_selector )() 
      //this.insertText(' ' + oSmileyProperties.sCode);

   });
});