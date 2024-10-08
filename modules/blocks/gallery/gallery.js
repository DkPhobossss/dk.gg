(function($) {
	$.fn.foba_gallery = function() {
            var speed = 110;
            var $dialog = $(this).next(),
                $dialog_title = $dialog.find('h1'),
                $dialog_photo = $dialog.find('.photo'),
                    photo_max_height = $dialog_photo.height(),
                    photo_max_width = 784,
                $dialog_arrow_left = $dialog.find('.arrow_left'),
                $dialog_arrow_right = $dialog.find('.arrow_right'),
                $dialog_source = $dialog.find('a.source'),
                $dialog_comments = $dialog.find('.watch_comments'),
                $dialog_stats = $dialog.find('.stats'),
            $current_element,
            current_position;

            
            var $slider = $(this).find('div.slider');
            var slider_width = $slider.width();
            var $offset = $('div.info span.offset');
            
            var position = 0;
            var vision = 0;
            var total = $slider.children().length;
            
            var $arrow_left = $(this).find('a.arrow_left');
            var $arrow_right = $(this).find('a.arrow_right');
            
            var _gallery_id = $(this).attr('id').substr(1);
            var _gallery_url = $(this).attr('url');
            var _url = 'http://watch.navi-gaming.com' + lang_url + 'gallery/' + _gallery_url + '/';
            var _title = document.title;
            var _base = document.location.href;
            
            //comments
            attach_comment_events( $dialog );

            $arrow_right.click( function(){
                if ( $(this).hasClass('disabled') || position == total || $slider.is(':animated') || ( vision ) == total )
                {
                    return false;
                }

                if ( position == 0 )
                    $arrow_left.removeClass('disabled');
                 
                position++;
                
                $slider.animate({
                    marginLeft: '-=' + $slider.children(':eq(' + position + ')' ).outerWidth( true )
                  }, speed , set_visible( position ) );
                
                if ( vision == total )
                {
                    $(this).addClass('disabled');
                }
                
                return false;
            });
            
            $arrow_left.click( function(){
                if ( $(this).hasClass('disabled') || position == 0 || $slider.is(':animated') )
                {
                    return false;
                }
                
                if ( vision == total )
                    $arrow_right.removeClass('disabled');
                 
                
                if ( --position == 0 )
                {
                    $(this).addClass('disabled');
                }
                
                $slider.animate({
                    marginLeft: '+=' + $slider.children(':eq(' + ( position + 1 ) + ')' ).outerWidth( true )
                 }, speed , set_visible( position ) );
                
                
                return false;
            });
            
            function visible( pos, $slider , width )
            {
                var _width = 0;
                var count = 0;
                
                $slider.children().slice( pos ).each( function() {
                    if ( $(this).width() == 0 )
                    {
                        var style = $(this).getStyleObject();
                        _width += parseInt( style['width'] ) + parseInt( style['marginLeft'] );
                    }
                    else
                    {   
                        _width += $(this).outerWidth( true );
                    }
                    

                    if ( _width > width )
                    {
                        return false;
                    }
                    
                    count++;
                });
                
                return count;
            }
            
            function set_visible( pos )
            {
                if (!pos)
                    pos = 0;
                
                vision = visible( pos , $slider, slider_width ) + pos; 

                $offset.text( vision );
            }
            setTimeout( set_visible , 150 ) ;
            
            
            $dialog.on( 'close', function ( e ) {
                    document.title = _title;

                    $('.overlay').scrollTo( 0 );
                    
                    if ( popstate_gallery )
                    {

                    }
                    else 
                    {
                        history.pushState( null , _title , _base );
                    }

            } );
            
            
            var popped = window.history.state;
            var popstate_gallery;
            window.addEventListener("popstate", function( e ) {
                // Ignore inital popstate that some browsers fire on page load
                var initialPop = !popped;
                popped = true;
                if ( initialPop ) return;
                
                if ( e.state &&  e.state.photo_id )
                {
                    openPhoto( e.state.photo_id  , e.state.title, true, e.state.photo_url , e.state.source_url )
                }
                else
                {
                    popstate_gallery = true;
                    activate( document.body );
                }
            } , false);
            

            $dialog_arrow_left.add( $dialog_arrow_right ).click( function() {
                if ( $(this).hasClass('disabled') )
                {
                    return false;
                }
                
                return openPhoto( 
                    $(this).attr('photo_id'), 
                    $(this).attr('title') , 
                    false , 
                    $(this).attr('_src') , 
                    $(this).attr('source') 
                );
            });
            
            
            function openPhoto( id , title, popstate, photo_url , source_url )
            {
                //loading
                $dialog_photo.css( {'background-image' : 'url("http://s.navi-gaming.com/images/system/loading.gif")' , 'background-size' : 'auto' } );
                
                $dialog.click();
                
                $current_element = $('#p' + id);
                current_position = $current_element.index();
                
                var 
                    $prev = $current_element.prev(),
                        prev_id = $prev.attr('id'),
                    $next = $current_element.next(),
                        next_id = $next.attr('id');
                
                if ( prev_id )
                {
                    $dialog_arrow_left.attr({
                        'photo_id'  : prev_id.substr(1),
                        'title'     : $prev.find('img').attr('alt'),
                        '_src'      : $prev.find('img').attr('_src'),
                        'source'    : $prev.attr('source')
                    }).removeClass('disabled');
                }
                else
                {
                    $dialog_arrow_left.removeAttr('photo_id title _src source').addClass('disabled');
                }
                
                if ( next_id )
                {
                    $dialog_arrow_right.attr({
                        'photo_id'  : next_id.substr(1),
                        'title'     : $next.find('img').attr('alt'),
                        '_src'      : $next.find('img').attr('_src'),
                        'source'    : $next.attr('source')
                    }).removeClass('disabled');
                }
                else
                {
                    $dialog_arrow_right.removeAttr('photo_id title _src source').addClass('disabled');
                }
                
                
                document.title = title;

                $dialog_title.html( title );
                $dialog_source.attr('href' , source_url ).prev().find('span').text( current_position + 1 );

                //get image
                var img = new Image();
                img.onload = function() {
                    $dialog_photo.css({
                        'background-image' : 'url("' + photo_url + '")', 
                        'background-size' : ( this.width < photo_max_width && this.height < photo_max_height ? 'auto' : 'contain' )
                    });
                };
                img.src = photo_url;
                
                if ( !popstate )
                {
                    history.pushState( { photo_id: id , title: title , photo_url: photo_url , source_url : source_url } , title , _url + id );
                }
                
                $.ajax({
                    type: 'POST',
                    url: lang_url + 'ajax/json/watch/photo' ,
                    cache : false,
                    data: 'id=' + id + '&gallery_url=' + _gallery_url + '&' + token ,
                    dataType: 'JSON'
                  }).done(function( data ) {
                        if ( data && data['html'] )
                        {
                            $dialog_stats.children('div.s').html( data['html'] );

                            //comments
                            _comments_url = lang_url + 'ajax/json/watch/photo_comments';
                            _news_url = 'http://watch.navi-gaming.com' + lang_url + 'gallery/' + _gallery_url + '/' + id;
                            _news_id = id;

                            $.ajax({
                                type: "POST",
                                url: _comments_url ,
                                cache:false,
                                data: 'mode=get_short_messages&page=1&id=' + _news_id + '&url=' + _news_url,
                                dataType: 'JSON'
                              }).done(function( data2 ) {
                                    if ( data2[0] )
                                    {
                                        if ( data2[0]['errors'] )
                                        {
                                            alert( data2[0]['errors'][''] );
                                        }
                                    }
                                    else
                                    {
                                        $dialog_comments.html( data2['html'] );
                                        tail = '';
                                    }
                              });
                        }
                        else if ( data[0] )
                        {
                            if ( data[0]['errors'] )
                            {
                                var s = '';
                                for ( i in data[0]['errors'] )
                                {
                                    s += data[0]['errors'][i] + "\r\n";
                                }
                                alert( s );
                            }
                        }
                }); 
            
                
                
                popstate_gallery = undefined;
            }

            document.querySelectorAll( 'div#' + $(this).attr('id') + ' div.slider > a' ).on('click', function( e ) {
                var img = $(this).children('img');

                openPhoto( $(this).attr('id').substr(1) , img.attr('alt') , false, img.attr('_src'), $(this).attr('source')  );
                
                e.preventDefault();
            });
            
            $( 'div#' + $(this).attr('id') + ' div.slider > a > span' ).on('click', function( e ) {
                e.preventDefault();
                e.stopPropagation();
                
                if ( $(this).hasClass('delete') )
                {
                    if ( !window.confirm('Are you sure?') )
                    {
                        return false;
                    }
                }

                document.location.href = $(this).attr('href');
            });
	};
})(jQuery);

$(document).ready(function() {
   $('div.foba_gallery').foba_gallery();
});