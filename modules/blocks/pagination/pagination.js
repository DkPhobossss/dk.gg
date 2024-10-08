$(document).ready(function() {
    var pagination_count = 50;
    $(document).on('click' , 'div.pagination > sub' , function() {
        var href = $(this).attr('href');
        var start = parseInt( $(this).attr('start') );
        var anchor = $(this).attr('anchor') ? $(this).attr('anchor') : '';
        var limit = $(this).attr('limit');
        var reverse = $(this).parent().attr('reverse');

        if ( limit ) 
        {
            //insert_before
            var dif = start + pagination_count;
            var method = reverse ? 'after' : 'before';
            
            if ( dif > limit )
            {
                for ( i = start ; i < limit ; i++ )
                {
                    $(this)[method](' <a href="' + href + i + anchor + '">' + i + '</a> ');
                }
                $(this).remove();
            }
            else
            {
                for ( i = start; i < dif ; i++)
                {
                    $(this)[method](' <a href="' + href + i + anchor + '">' + i + '</a> ');
                }
                $(this).attr( 'start' , dif );
            }
        } 
        else 
        {
            //insert_after
            var dif = start - pagination_count;
            var method = reverse ? 'before' : 'after';
            
            if ( dif > 1)
            {
                for ( i = start ; i > dif ; i-- )
                {
                    $(this)[method](' <a href="' + href + i + anchor + '">' + i + '</a> ');
                }
                $(this).attr( 'start' , dif );
            }
            else
            {
                for ( i = start; i >= 2 ; i--)
                {
                    $(this)[method](' <a href="' + href + i + anchor + '">' + i + '</a> ');
                }
                $(this).remove();
            }
        }
    }); 
    $(document).on('click' , 'div.pagination a.selected' , function() {
       return false; 
    });
});