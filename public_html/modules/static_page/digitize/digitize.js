$(document).ready( function() {
    var $mmr = $('#mmr'),
        $mmr2 = $('#mmr_2'),
        user_mmr = null,
        user_mmr2 = null,
        $player_rank_image = $('#player_rank_image'),
        $player_rank_image2 = $('#player_rank_image_2'),
        $player_rank_title = $('#player_rank_title'),
        $player_rank_title2 = $('#player_rank_title_2'),
        $player_rank_image_content = $('#player_rank_image_content'),
        $player_rank_image_content2 = $('#player_rank_image_content_2'),
        $tbody = $('#skill_calculation > tbody');

    function change_medal( value , $el, $el_title )
    {

        if ( value === '' || value === null )
        {
            $el.attr('src' , '/images/medals/0.png');
            $el_title.html('Uncalibrated');
            return true;
        }

        var index = RANKS.length - 1;
        for ( var i in RANKS )
        {
            if ( RANKS[i].start > value )
            {
                index = i - 1;
                break;
            }
        }

        $el.attr('src' , RANKS[index].url);
        $el_title.html(RANKS[index].text);



        return true;
    }

    function get_range( mmr )
    {
        for ( var i in MMR_RANGE )
        {
            if ( MMR_RANGE[i][0] <= mmr & MMR_RANGE[i][1] >= mmr  )
            {
                return i;
            }
        }
    }

    function specify_skill( mmr , selector , hide)
    {
        var user_range = get_range(mmr);

        for ( var i in DATA )
        {
            var temp_range = null;
            var index = null;
            var $tr = $('#table_skill_' + i);

            if ( DATA[i].range.length == 1 )
            {
                if (user_range >= DATA[i].range[0])
                {
                    temp_range = DATA[i].range[0];
                }
            }
            else
            {
                for (var j in DATA[i].range)
                {
                    if (user_range < DATA[i].range[j])
                    {
                        break;
                    }
                    temp_range = DATA[i].range[j];
                    index = j;
                }
            }

            if ( temp_range === null )//skill not found
            {
                if ( hide === true)
                {
                    $tr.addClass('none');
                }
                else
                {
                    $tr.addClass('missing');

                    if ( DATA[i].range.length > 1 )
                    {
                        $tr.find(selector).attr('lvl', 0);
                        $tr.find(selector).attr('user_lvl', 0);
                    }
                }
            }
            else
            {
                if ( hide === true)
                {
                    $tr.removeClass('none');
                    if ( index !== null)
                    {
                        $tr.find(selector).attr('lvl', parseInt(index ) + 1);
                        $tr.find(selector).attr('user_lvl', parseInt(index ) + 1);
                    }
                }
                else
                {
                    $tr.removeClass('missing user_change');
                    if ( index !== null)
                    {
                        $tr.find(selector).attr('lvl', parseInt(index) + 1);
                        $tr.find(selector).attr('user_lvl', parseInt(index ) + 1);
                    }
                }
            }
        }

        if ( hide === true)
        {
            $tbody.find('tr.global_skill').each( function() {
                var t = $(this).nextUntil('tr.global_skill' , 'tr:not(.none)');

                if ( t.length > 0)
                {
                    $(this).removeClass('none');
                    return;
                }

                $(this).addClass('none');
            });
        }
    }

    function calculate_row( $row )  {
        if ( $row.hasClass('none') )
        {
            return;
        }

        var $th = $row.find('th.result');
        $th.removeClass('yes no');


        var user_skill_lvl = parseInt( $row.find('td:first-child').attr('lvl') );
        var user_skill_lvl2 = parseInt( $row.find('td:last-child').attr('lvl') );

        if ( isNaN( user_skill_lvl ) )
        {
            if ( $row.hasClass('missing'))
            {
                $th.addClass('no');
            }
            else
            {
                $th.addClass('yes');
            }
        }
        else if ( user_skill_lvl >= user_skill_lvl2 )
        {
            $th.addClass('yes');
            $row.removeClass('missing');
        }
        else
        {
            $th.addClass('no');
            $row.addClass('missing');
        }
    }


    function calculate_result()
    {
        $tbody.find('tr:not(.global_skill)').each( function() {
            calculate_row( $(this) )
        } );
    }


    $('#popup').on($.modal.OPEN, function(event, modal) {
        $(this).html(  $('#skill_' + modal.$anchor.attr('data') + ' .skill' ).html() );
        $(this).find('a').attr('href' , null);
    });


    $mmr.on( 'focusout', function(){
        var value = parseInt( $(this).val() );

        user_mmr = value;

        if ( !Number.isInteger(value) || value < 0 ) {
            value = 0;
            user_mmr = null;
        }

        $mmr2.attr('min' , value);

        change_medal( user_mmr  , $player_rank_image, $player_rank_title );

        specify_skill( user_mmr , 'td:first-child' , false );

        if ( user_mmr !== null & user_mmr2 !== null  )
        {
            calculate_result();
        }
    });

    $mmr2.on( 'focusout', function(){
        var value = $(this).val();
        var min = parseInt( $mmr2.attr('min') );
        if ( value <  min )
        {
            $(this).val( min );
        }

        user_mmr2 = value;

        change_medal( user_mmr2  , $player_rank_image2, $player_rank_title2 );

        specify_skill( user_mmr2 , 'td:last-child' , true );

        if ( user_mmr !== null & user_mmr2 !== null )
        {
            calculate_result();
        }
    });

    $('#player_rank_image').tooltipster({
        side: 'left',
        interactive: true,
        theme: 'tooltipster-light',
        trigger: 'custom',
        triggerOpen: {
            click: true,
            tap: true
        },
        triggerClose: {
            click: true,
            tap: true
        },
        functionAfter : function () {
            $player_rank_image_content.find('.selected').removeClass('selected');
        }
    });


    $player_rank_image_content.find('img').each( function() {
        $(this).on('click', function() {
            if ( $(this).hasClass('selected'))
                return;

            $player_rank_image_content.find('.selected').removeClass('selected');
            $(this).addClass('selected');

            $mmr.val( $(this).attr('mmr') ).trigger('focusout');
        });
    });


    $('#player_rank_image_2').tooltipster({
        side: 'right',
        interactive: true,
        theme: 'tooltipster-light',
        trigger: 'custom',
        triggerOpen: {
            click: true,
            tap: true
        },
        triggerClose: {
            click: true,
            tap: true
        },
        functionAfter : function () {
            $player_rank_image_content2.find('.selected').removeClass('selected');
        },
        functionBefore : function () {
            $player_rank_image_content2.find('img').each(function() {
                var mmr = parseInt( $(this).attr('mmr') );
                if ( mmr < user_mmr )
                {
                    $(this).addClass('disabled');
                }
                else
                {
                    $(this).removeClass('disabled');
                }

            });
        },
    });

    $player_rank_image_content2.find('img').each( function() {
        $(this).on('click', function() {
            if ( $(this).hasClass('selected'))
                return;

            var mmr = parseInt($(this).attr('mmr'));
            if ( mmr < user_mmr )
                return;

            $player_rank_image_content2.find('.selected').removeClass('selected');
            $(this).addClass('selected');

            $mmr2.val( mmr ).trigger('focusout');
        });
    });


    function user_change_row( $row, lvl, skill_id )
    {
        if ( lvl === null )
        {
            $row.toggleClass('missing').toggleClass('user_change');
        }
        else
        {
            $td = $row.find('td:first-child');
            $td.attr('lvl' , lvl);

            if ( lvl != parseInt( $td.attr('user_lvl' )) )
            {
                $row.addClass('user_change');
            }
            else
            {
                $row.removeClass('user_change');
            }

            calculate_row($row);
        }

        return;
    }


    $('th.result').on('click', function() {
        var $th = $(this);

        var id = parseInt( $(this).attr('skill') );
        var length = DATA[id].range.length;
        var $user_row = $th.parent();

        if ( length == 1)
        {
            user_change_row( $user_row, null, id );
        }
        else
        {
            if ( $th.hasClass('tooltipstered') )
            {
                //$th.tooltipster();
            }
            else
            {
                var html = '<div class="choose_lvl"><select>';
                for ( var i = 0 ; i <= length; i++ )
                {
                    html += '<option value="' + i + '">LVL ' + i + '</option>'
                }
                html += '</select></div>';

                $th.tooltipster({
                        content: html,
                        contentAsHTML: true,
                        side: 'top',
                        animationDuration: 100,
                        interactive: true,
                        theme: 'tooltipster-light',
                        distance : 0,
                        trigger: 'custom',
                        arrow : false,
                        functionPosition: function(instance, helper, position){
                            position.coord.top += 36;
                            return position;
                        },
                        triggerOpen: {
                            click: true,
                            tap: true
                        },
                        triggerClose: {
                            click: true,
                            tap: true
                        },
                        functionReady : function (instance, helper) {
                            var $select = instance._$tooltip.find('select');
                            $select.on( 'change' , function() {
                                user_change_row( $user_row, parseInt( $(this).val() ) , id );
                                $th.tooltipster('close');
                            });
                            $select.val( $user_row.find('td:first-child').attr('lvl') );
                        },
                    }
                ).tooltipster('open');
            }
        }

        calculate_row( $user_row );
    });


});