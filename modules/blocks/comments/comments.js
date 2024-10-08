$(document).ready(function() {
    var $container = $('div.comment_block');
    var $post = $container.children('div.post')
    var $clone;
    var scroll_speed = 500;
    
    $container
    .on('click' , 'a.comment_button' , function() {
        var $_container = $(this).closest('div[id]');
        
        if ( $clone )
        {
            if ( $clone.prev().attr('id') == $_container.attr('id') )
            {
                return false;
            }
            $clone.remove();
        }
        
        var button = $(this);
        if ( button.hasClass('loading') )
        {
            return false;
        }
        button.addClass( 'loading' );
        
        var $author = $_container.find('div.comment > div.head > a[target]').text();
        if ( !$author )
        {
            $author = 'Author Deleted';
        }
        $clone = $post.clone( );
        
        $.ajax({
            type: "POST",
            url: comments_url ,
            cache:false,
            data: 'id=' + $_container.attr('id').substr(2) + '&mode=get_message_quote',
            dataType: 'JSON'
          }).done(function( data ) {
                if ( data[0] )
                {
                    if ( data[0]['errors'] )
                    {
                        alert( data[0]['errors'][''] );
                    }
                }
                else if ( data['html'] )
                {
                    $clone.find('textarea[name=comment]').html("[quote author='" + $author + "' ]\n" + data['html'] + "\n[/quote]\n");
                }
                button.removeClass( 'loading' );
                $_container.after( $clone );
          });
    })
    .on('click' , 'div.post a.leave_comment' ,  function() {
        var button = $(this);
        if ( button.hasClass('loading') )
        {
            return false;
        }

        button.addClass( 'loading' );
        
        $.ajax({
            type: "POST",
            url: comments_url ,
            cache:false,
            data: $(this).closest('form').serialize() + '&mode=send_message&url=' + news_url ,
            dataType: 'JSON'
          }).done(function( data ) {
                if ( data[0] )
                {
                    if ( data[0]['errors'] )
                    {
                        alert( data[0]['errors'][''] );
                    }
                }
                else
                {
                    $container.html( data['html'] );
                    $('body > div.main').scrollTo( $container.children('div[id]:last') , scroll_speed);


                    var $paginations = $container.find('div.pagination');
                    
                    var page;
                    if ( $paginations[0] === undefined )
                    {
                         page = 1;
                    }
                    else
                    {
                        var page_href = $paginations.find('a:last-child').attr('href');
                        var page_substr = page_href.indexOf('?page=');
                        page = ( page_substr == -1 ? 1 : page_href.substr( page_substr + 6 , page_href.indexOf('#') - page_substr - 6 ) );

                        $paginations.find('a.selected').removeClass('selected');
                        $paginations.find('a[href="' + news_url + ( page == 1  ? '' : '?page=' + page ) + '#comments"]').addClass('selected');
                    }
                    
                    var history_url = lang_url + news_url + ( page == 1 ? '' : '?page=' + page );
                    history.pushState(null, document.title + ' page ' + page , history_url );
                }
                button.removeClass( 'loading' );
          });
        
    })
    .on('click' , 'div[id] + div.post img.close' , function() {
        $clone.remove();
    })
    .on('click' , 'div.pagination > a' , function() {
        var page_substr = $(this).attr('href').indexOf('?page=');
        var page = ( page_substr == -1 ? 1 : $(this).attr('href').substr( page_substr + 6 , $(this).attr('href').indexOf('#') - page_substr - 6 ) );
        
        var $paginations = $container.find('div.pagination');
        $paginations.find('a.selected').removeClass('selected');
        $paginations.find('a[href="' + $(this).attr('href') + '"]').addClass('selected');
        
        var history_url = lang_url  + news_url + ( page == 1 ? '' : '?page=' + page );
        
        var field = $.url().param('field');
        var order = $.url().param('order')
        if ( field !== undefined && order !== undefined )
        {
            history_url = history_url + ( page == 1 ? '?' : '&' ) + 'field=' + field + '&order=' + order;
            tail = '&field=' + field + '&order=' + order;
        }
        else
        {
            var tail = '';
        }
        
        history.pushState(null, document.title + ' page ' + page , history_url );
        
        $.ajax({
            type: "POST",
            url: comments_url ,
            cache:false,
            data: 'mode=get_messages&page=' + page + '&id=' + news_id + '&url=' + news_url + tail,
            dataType: 'JSON'
          }).done(function( data ) {
                if ( data[0] )
                {
                    if ( data[0]['errors'] )
                    {
                        alert( data[0]['errors'][''] );
                    }
                }
                else
                {
                    $container.html( data['html'] );
                }
                $('body > div.main').scrollTo( $container , scroll_speed);
          });

        return false;
    })
    .on('click' , '.refresh' , function() {
        var page = $.url().param('page');
        if ( !page )
        {
            page = 1;
        }
        
        var field = $.url().param('field');
        var order = $.url().param('order');
        if ( field !== undefined && order !== undefined )
        {
            tail = '&field=' + field + '&order=' + order;
        }
        else
        {
            var tail = '';
        }
        
        $.ajax({
            type: "POST",
            url: comments_url ,
            cache:false,
            data: 'mode=get_messages&page=' + page + '&id=' + news_id + '&url=' + news_url + tail,
            dataType: 'JSON'
          }).done(function( data ) {
                if ( data[0] )
                {
                    if ( data[0]['errors'] )
                    {
                        alert( data[0]['errors'][''] );
                    }
                }
                else
                {
                    $container.html( data['html'] );
                }
          });
    })
    .on('click' , 'div.comment div.bottom > div.right span.respect:not(.disabled) , div.comment div.bottom > div.right span.disrespect:not(.disabled)' , function() {
       var value = $(this).hasClass('respect') ? 1 : -1;
       var $_container = $(this).closest('div[id]');
       var $parent = $(this).parent();
       $parent.children('span.respect , span.disrespect').addClass('disabled');
       
       $.ajax({
            type: "POST",
            url: comments_url ,
            cache:false,
            data: 'mode=karma&value=' + value + '&comment_id=' + $_container.attr('id').substr(2) + '&' + token,
            dataType: 'JSON'
          }).done(function( data ) {
                if ( data && data['result'] )
                {
                    var $rating =  $parent.children('span:first');
                    var res = parseInt($rating.text()) + value;
                    $rating.text( ( res > 0 ? '+' : '' ) + res );
                    if ( res == 0 )
                    {
                        $rating.removeAttr('class');
                    }
                    else if ( res > 0 )
                    {
                        $rating.addClass('positive');
                    }
                    else
                    {
                        $rating.addClass('negative');
                    }
                    
                    var $stats = $container.find('div.user[id="' + $_container.find('div.user').attr('id') + '"] > div.stats table tr:first-child');
                    var dir = $($stats[0]).find('th:eq(1) img').attr('alt');
 
                    var prev_value = parseInt( $($stats[0]).find('td:eq(1)').text() );

                    if ( prev_value == 0 && value == -1 )
                    {
                        $stats.find('th:eq(1) img').attr('src' , 'http://forum.navi-gaming.com/Themes/default/images/unrespect.png').attr('alt' , 'DisRespect');
                    }
                    else if ( prev_value == 1 && dir != 'Respect' && value == 1 )
                    {
                        $stats.find('th:eq(1) img').attr('src' , 'http://forum.navi-gaming.com/Themes/default/images/respect.png').attr('alt' , 'Respect');
                    }

                    var new_value = Math.abs( prev_value + ( dir == 'Respect' ? 1 : -1 ) * value );
                    $stats.find('td:eq(1)').text( new_value );
                }
          });
    })
    .on('click' , 'a.show' , function() {
        $(this).parent().html( $(this).next().html() );
    })
    .on('click' , '.delete' , function() {
        var $_container = $(this).closest('div[id]');
        
        $.ajax({
            type: "POST",
            url: comments_url ,
            cache:false,
            data: 'id=' + $_container.attr('id').substr(2) + '&mode=delete&' + token,
            dataType: 'JSON'
          }).done(function( ) {
              $_container.find('div.body').html('This comment was deleted.');
          });
    })
    .on('click' , '.restore' , function() {
        var $_container = $(this).closest('div[id]');
        var $this = $(this);
        
        $.ajax({
            type: "POST",
            url: comments_url ,
            cache:false,
            data: 'id=' + $_container.attr('id').substr(2) + '&mode=restore&' + token,
            dataType: 'JSON'
          }).done(function( ) {
              $this.remove();
          });
    })
    .on('click' ,'.give_gold' , function() {
        var $_container = $(this).closest('div[id]');
        
        $.ajax({
            type: "POST",
            url: comments_url ,
            cache:false,
            data: 'id=' + $_container.attr('id').substr(2) + '&mode=give_gold&' + token,
            dataType: 'JSON'
          }).done(function( ) {
                $right = $_container.find('div.bottom > div.right');
                $gold_info =  $right.next();

                if ( $gold_info.length != 0 )
                {
                    $gold_info.children('span.date_info').next().html( ( parseInt( $gold_info.children('span.date_info').next().text() ) + 1 ) + ' <img src="http://forum.navi-gaming.com/Themes/default/images/gold_theme.png" title="GOLD" alt="GOLD" />' );
                }
                else
                {
                    $right.after('<span class="gold_info right">' + 
                                          '<span class="date_info">For this comment ' + $_container.find('div.comment div.border_bottom > a[target]').text() + ' has received</span>' + 
                                          '<span>1 <img src="http://forum.navi-gaming.com/Themes/default/images/gold_theme.png" title="GOLD" alt="GOLD"></span>' +
                                      '</span>');
                }
          });
    });
});