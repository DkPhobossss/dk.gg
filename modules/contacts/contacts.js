$(document).ready( function() {
    var $div_additional = $('div#additional_info');

    $('select[name=variant]').change( function() {
       var $template_block = $('div#t' + $(this).val() );
       if ( !$template_block )
        {
            $div_additional.html('');
        }
        else
        {
            $(document).ready(function() {
                $div_additional.html( $template_block.html() );
            });
        }
    });
})