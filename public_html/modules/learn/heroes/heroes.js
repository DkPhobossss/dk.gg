$(document).ready( function() {
    var playPromise = [],
        search = {
            needle : '',
            $search_container : $('div.heroes_list'),
            timeout : 1500,
            max_letters : 32,
            timeout_event : null,
            dom_id : 'search_text',
            $text : null
        };

    $('div.main').append('<div id="' + search.dom_id + '"></div>');
    search.$text = $('#' + search.dom_id);

    $('img.hero_avatar_animated').mouseenter( function() {
        var $video = $(this).next();

        $(this).css('z-index' , 4);
        $(this).css('filter' , 'opacity(0)');

        $video.removeClass('none');

        playPromise[$video.attr('src')] = $video[0].play();

    }).mouseleave(function() {
        var $video = $(this).next();

        $(this).css('z-index' , 1);
        $(this).removeAttr('style');

        $video.addClass('none');

        if (playPromise[$video.attr('src')] !== undefined) {
            playPromise[$video.attr('src')].then(_ => {
                // Automatic playback started!
                // Show playing UI.
                // We can now safely pause video...
                $video[0].pause();
                $video[0].currentTime = 0;
            })
            .catch(error => {
                // Auto-play was prevented
                // Show paused UI.
            });
        }
    });

    //restore opacity
    function sleep(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }

    async function update_search()
    {
        clearTimeout( search.timeout_event );

        search.$text.finish();
        await sleep(1);
        search.$text.css({
            'display' : 'block' ,
            'opacity' : 1}
        );

        search.$text.html(search.needle);

        search.$text.animate( { opacity: 0 } ,
            search.timeout,
            'linear',
            function() { $(this).css('display' , 'none'); }
        );
        search.timeout_event = setTimeout( function () {
            search.$text.html('');
            search.needle = '';
        }, search.timeout);



        search.$search_container.find('span.hero_name').each(function() {
            var $hero_img = $(this).parent().find('img.hero_avatar_animated');

            if ( search.needle.length == 0 )
            {
                $hero_img.removeClass('disabled selected');
            }
            else if ( search.needle.length == 1)
            {
                var first_letter = $(this).html().charAt(0);

                if ( search.needle == first_letter.toUpperCase() )
                {
                    $hero_img.addClass('selected').removeClass('disabled');
                }
                else
                {
                    $hero_img.addClass('disabled').removeClass('selected');
                }
            }
            else
            {
                if ( $(this).html().toUpperCase().includes( search.needle ) )
                {
                    $hero_img.addClass('selected').removeClass('disabled');
                }
                else
                {
                    $hero_img.addClass('disabled').removeClass('selected');
                }
            }
        })

    }

    $(document).on('keydown', function(e) {
        //27 escape, 8 - backspace 65-a 90-z
        var letter = e.key;
        if ( letter.length > 1)
        {
            //27 escape
            if ( e.keyCode == 27 )
            {
                search.needle = '';
                update_search();
            }
            //8 backspace
            else if ( e.keyCode == 8 )
            {
                search.needle = search.needle.slice( 0, -1 );
                update_search();
            }
        }
        else if( letter.length == 1 )
        {
            if(e.keyCode == 32 && e.target == document.body) {
                e.preventDefault();
            }

            if ( search.needle.length < search.max_letters ) {
                search.needle += letter.toUpperCase();
                update_search();
            }
        }
    })
    .on('click', function() {
        search.needle = '';
        update_search();
    });


})