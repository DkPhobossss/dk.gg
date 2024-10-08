function parseUrlQuery() {
    var data = {};
    if(location.search) {
        var pair = (location.search.substr(1)).split('&');
        for(var i = 0; i < pair.length; i ++) {
            var param = pair[i].split('=');
            data[param[0]] = param[1];
        }
    }
    return data;
}

function randomInteger(min, max) {
    // случайное число от min до (max+1)
    let rand = min + Math.random() * (max + 1 - min);
    return Math.floor(rand);
}

var test = '';
var tooltip_delay = 5000;
var fade_delay = 500;
var hexagons_criteria_height = 2000;
var hexagons_step = 1200;
var CACHE = {};

function create_hexagons( $container, step, num )
{
    var hexagon = {
        offset : step,
        size_dispersion : 150,
        height_dispersion : 0.5,
        size_start : 100,
        height : 0,
        witdth : 0
    };

    for ( i = 0 ; i < num; i++ )
    {
        hexagon.width = randomInteger( hexagon.size_start, hexagon.size_start + hexagon.size_dispersion );
        hexagon.height = randomInteger( hexagon.width, hexagon.width + hexagon.width * hexagon.height_dispersion );
        $container.append('<div class="hexagon" style="top:' + hexagon.offset + 'px;width:' + hexagon.width + 'px;height:' + hexagon.height + 'px;"></div>');
        hexagon.offset += step;
    }
}


var f = {};
f.ajax = function( options , $el, callback ){
    var defaults = {
        success: function(response){
            $el.removeClass('loading');

            try {
                var data = JSON.parse(response);
            }
            catch (e) {
                $.tooltip( 'wrong response', 'ajax_error_tooltip');
                return false;
            }


            if ((typeof data[0]) == 'undefined' || typeof (data[0]['type']) == 'undefined') {
                $.tooltip( 'wrong response', 'ajax_error_tooltip');
            }

            data = data[0];

            switch (data['type']) {
                case 'reload' :
                    location.reload();
                    return;

                case 'redirect' :
                    location.href = data['url'];
                    return;

                case 'errors' :
                    var errors = data['errors'];
                    if ( !Array.isArray(errors ) ) {
                        $.tooltip(errors, 'ajax_error_tooltip');
                    }
                    else {
                        var s = '';
                        for (var key in errors) {
                            s += errors[key] + "\r\n";
                        }
                        $.tooltip( s, 'ajax_error_tooltip' );
                    }
                    return;

                case 'tooltip' :
                    $.tooltip( data['text'], 'ajax_success_tooltip');
                    break;
            }

            callback( data );
        },
        error: function(){
            $el.removeClass('loading');
            $.tooltip( 'ajax error', 'ajax_error_tooltip');
        },
        beforeSubmit: function (){
            if ( $el.hasClass('loading'))
                return false;
            $el.addClass('loading');
        },
    };

    $.extend(options,defaults);
    return $.ajax(options);
}

__ = function( key )
{
    return ( typeof BOOK[ key ] === 'undefined' ) ? key : BOOK[ key ] ;
}


$(document).ready(function() {
    $content = $('div#content');
    content_height = $content.height();
    if ( content_height > hexagons_criteria_height && !$('.row_2').length )
    {
        create_hexagons( $('#wrap'), hexagons_step, Math.floor( content_height / hexagons_step ) );
    }

    $('.debug').on( 'mouseenter mouseleave', function(){
        $(this).toggleClass('active');
    })

    $("table.sortable").each(function() {
        $(this).tablesorter()
    });

    $('a[href*="#"]').each(function() {
        $(this).smoothscroll({
            duration: 400,
            easing: 'linear',
            offset: -50
        });
    });

    $('#youtube_play').on($.modal.OPEN, function(event, modal) {
        $(this).children('iframe').attr( 'src', modal.$anchor.attr('data') );
    }).on($.modal.CLOSE, function(event, modal) {
        var $iframe = $(this).children('iframe');
        setTimeout(function(){ $iframe[0].contentWindow.postMessage('{"event":"command","func":"stopVideo","args":""}', '*'); }, 3000);
        $iframe[0].contentWindow.postMessage('{"event":"command","func":"stopVideo","args":""}', '*');
        $iframe.attr( 'src', null);
    });


    var $body = $('body');
    if( $(window).scrollTop() > 30 ) {
        if (!$body.hasClass('scrolled'))
            $body.addClass('scrolled');
    }


    $(window).scroll(function() {
        if( $(window).scrollTop() > 30 ) {
            if (!$body.hasClass('scrolled'))
                $body.addClass('scrolled');
        } else {
            $body.removeClass('scrolled');
        }
    });



    var $ajax_response_container = $('#ajax_container');

    $('a.logo').mouseenter(function(){
        var $visible = $(this).children('.visible');
        if ( $visible.length == 0)
            return false;

        var child_index = $visible.index();
        var logos_count = $(this).children().length - 2;
        var new_visible_child_index = ( randomInteger(1,logos_count) + child_index ) % ( logos_count + 1);

        $('a.logo').each(function() {
            $(this).children('.visible').removeClass('visible');
            $(this).children(":eq(" + new_visible_child_index + ")").addClass('visible')
        });
    });


    var $controller = $("#login_controller");

    $("[popup]").each( function() {
        var selector = $(this).attr('popup');
        var $popup = $(document).find( $(this).attr('popup') );
        var modal = $popup.attr('modal').length;


        $(this).magnificPopup({
            items: {
                src: selector,
                type: 'inline',
                modal : modal,

            }
        })
    });




    $controller.find('a.button_main').click(function(){
        var $el = $(this);
        if ( $(this).hasClass('selected') ) return;

        $controller.find('div.login_controller:not(.none)').addClass('none');
        $controller.find('div.login_controller#' + $el.attr('rel')).removeClass('none');
        $(this).parent().find('a.selected').removeClass('selected');
        $(this).addClass('selected');
    });

    $.tooltip = function(text, html_class){
        var $el = $('<div class="' + html_class + '">' + text + '</div>"').appendTo($ajax_response_container);
        $el.click(function () {
            $(this).remove();
        }).delay(tooltip_delay).fadeOut(fade_delay, function () {
            $(this).remove();
        });
    }


    $('form.ajax_form').each(function(){
        var $form = $(this);
        var $captcha  = $form.find('[name="recaptcha_response"]');
        var $submit = $form.find('button[type="submit"]');
            $form.ajaxForm({
            beforeSubmit: function (){
                if ( $submit.hasClass('loading'))
                    return false;
                $submit.addClass('loading');
                $form.find('[error]').attr('error' , null);
            },
            error: function(){
                $submit.removeClass('loading');
                $.tooltip( 'ajax error', 'ajax_error_tooltip');

                if ( $captcha.length  ){
                    window[$captcha.attr('callback')]();
                }

            },
            success: function(response) {
                $submit.removeClass('loading');

                if ( $captcha.length  ){
                    window[$captcha.attr('callback')]();
                }

                var data = JSON.parse(response);
                if ($.isEmptyObject(data)) {
                    return true;
                }


                if ((typeof data[0]) == 'undefined' || typeof (data[0]['type']) == 'undefined') {
                    $.tooltip( 'wrong response', 'ajax_error_tooltip');
                }

                data = data[0];

                switch (data['type']) {
                    case 'reload' :
                        location.reload();
                        break;

                    case 'redirect' :
                        location.href = data['url'];
                        break;

                    case 'errors' :
                        var errors = data['errors'];
                        for (var key in errors) {
                            if (key === '' || !isNaN(key) ) {
                                $.tooltip(errors[key], 'ajax_error_tooltip');
                            } else {
                                $el = $form.find('[name="' + key + '"]');
                                $el.parent().attr('error' , $el.attr('error') ? ( $el.attr('error') + '\n' + errors[key] ) : errors[key] );
                                $el.change(function(){ $(this).parent().attr('error', null) });
                            }
                        }
                        break;

                    case 'tooltip' :
                        $.tooltip( data['text'], 'ajax_success_tooltip');
                        break;

                }
            }

        })
    });


    var $social_img = $('.socials .pugna');
    var $social_container = $('.social-networks');
    $social_img.mouseenter(function(){
        $social_container.find('a.fi').addClass('hover');
    }).mouseleave(function(){
        $social_container.find('a.fi').removeClass('hover');
    });


    $('.tooltip').each(function() {
        return make_tooltip( $(this) );
    });

    $('.popup').each(function() {
       $(this).on("click", function(e){
           e.stopPropagation();

           var $popup  = $(this).find('.popup_menu');
           $popup.on("click", function(e2){
               e2.stopPropagation();
           });

           $popup.css('display' , $popup.css('display') == 'block' ? 'none' : 'block');
       });
    });

    $(document).click(function() {
        $('.popup .popup_menu').css('display' , 'none');
    });


    var inputQuantity = [];

    $("input[type=number]").on("keyup", function (e) {
        var $field = $(this),
            val=this.value,
            max_length = $field.attr("maxlength");

        if (this.validity && this.validity.badInput || isNaN(val)  ) {
            this.value = null;
            console.log(val);
            return;
        }
        if (val.length > Number(max_length)) {
            val=val.slice(0, max_length);
            $field.val(val);
            console.log('trigger_2');
        }

    });
});

var make_tooltip = function( $el ) {
    var data = $el.attr('tooltip_data');
    if ( !data || data.length == 0 )
    {
        $el.tooltipster();
        return;
    }

    $el.tooltipster( JSON.parse(data) );
};

function $ajax_reload( method , url , data , no_processData )
{
    $.ajax({
        type: method,
        url: url ,
        cache : false,
        data: data,
        dataType: 'JSON',
        processData: no_processData ? false : true
      }).done(function( data ) {
            if ( data && data['reload'] )
            {
                window.location.reload();
            }
            else
            {
                if ( data[0] )
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
                else
                {
                    alert( 'unknown answer' );
                }
            }
      }); 
}




