$(document).ready( function() {
    var current_position = 0;
    slider_data = $.parseJSON(slider_data);
    var total = slider_data.length;
    
    var $slider = $('#root_bg');
    var $click = $('#root_click');
    var $popup = $('.slider_control');
    
    var timeout = 10000;
    var speed = 400;
    
    if ( total > 1 )
    {
        var T = setInterval( function() { $arrow_right.click(); } , timeout );
        
        var $arrow_left = $('#slider_left');
        var $arrow_right = $('#slider_right');
        
        $arrow_left.click( function() {
            if ( $slider.is(':animated') )
            {
                return false;
            }

            if ( current_position == 0 )
            {
                current_position = total - 1;
            }
            else
            {
                current_position--;
            }
            
            element( current_position );
        });
        
        $arrow_right.click( function() {
            if ( $slider.is(':animated') )
            {
                return false;
            }
            
            if ( current_position == total - 1 )
            {
                current_position = 0;
            }
            else
            {
                current_position++;
            }
            
            element( current_position );
        });
    }
    
    
    function element( pos )
    {
        //get image
        var img = new Image();
        img.onload = function() {
            var src = $(this).attr('src');
            $slider.animate( { opacity: 0 }, speed , function() {  
                $(this).css({
                        'background-image' : 'url("' + src + '")', 
                    });
                    
                $(this).animate( { opacity: 1 }, speed , function() {
                    
                } );
            } );
            
            
            $click.attr('href' , $(this).attr('url') );
            
            var $elem = $popup.find('a.edit_global');
            if ( $elem.length > 0 )
            {
                var href = $elem.attr('href');
                var pos = href.indexOf( '?id=' );
                var b_id = $(this).attr('b_id');

                $elem.attr('href' , href.substr( 0 , pos ) + '?id=' + b_id  );

                $elem = $popup.find('a.delete');
                href = $elem.attr('href');
                pos = href.indexOf( '?id=' );
                var pos2 = href.indexOf( '&' , pos );
                $elem.attr('href' , href.substr( 0 , pos ) + '?id=' + b_id + href.substr( pos2 ) );
            }
        };

        $(img).attr('b_id' , slider_data[pos]['id']);
        $(img).attr('url' , slider_data[pos]['url']);
        img.src = slider_data[pos]['image'];
        
        
        clearInterval( T );
        T = setInterval( function() { $arrow_right.click(); } , timeout );
    }
});