$(document).ready( function() {
    var talent = {
        $object : $('#talents')  ,
        $content : $('#talents_content'),
        src : static_url + 'images/dota_2/talent.png',
        src_full : static_url + 'images/dota_2/talent_full.png',
    };

    var lvl = {
        current : 1,
        $lvl_up : $('#lvl_up'),
        $lvl_down : $('#lvl_down'),
        max : 30,
        $content : $('#lvl'),
        $str : $('#str'),
        $agi : $('#agi'),
        $int : $('#int'),
        $dmg_min : $('#start_dmg_min'),
        $dmg_max : $('#start_dmg_max'),
        $attack_per_second : $('#attack_per_second'),
        $armor : $('#start_armor'),
        $hp : $('div.hp'),
        $mp : $('div.mp'),
        $ms : $('#ms'),
        $magic_resist : $('#magic_resist'),
        $attack_range : $('#attack_range')
    };

    HERO.attack_speed_per_second = function() {
        return ( ( HERO.base_as + HERO.agi ) * 0.01 / HERO.bas );
    }

    lvl.update = function() {
        var lvl_inc = lvl.current - 1;
        HERO.str = HERO.str_base + lvl_inc * HERO.str_inc;
        HERO.agi = HERO.agi_base + lvl_inc * HERO.agi_inc;
        HERO.int = HERO.int_base + lvl_inc * HERO.int_inc;

        var dmg_increase = HERO.primary_attribute == 'str'  ? HERO.str
                                                            : HERO.primary_attribute == 'agi'   ? HERO.agi
                                                                                                : HERO.int;
        HERO.dmg_min = HERO.base_dmg_min + dmg_increase * ATTRIBUTE_GROWTH.DMG_PER_PRIMARY_ATTRIBUTE;
        HERO.dmg_max = HERO.base_dmg_max + dmg_increase * ATTRIBUTE_GROWTH.DMG_PER_PRIMARY_ATTRIBUTE;

        HERO.hp = HERO.BASE_HP + Math.floor( HERO.str ) * ATTRIBUTE_GROWTH.HP_PER_STR;
        HERO.hp_reg = HERO.base_hp_reg + HERO.str * ATTRIBUTE_GROWTH.HP_REG_PER_STR;

        HERO.mp = HERO.BASE_MP + Math.floor( HERO.int ) * ATTRIBUTE_GROWTH.MP_PER_INT;
        HERO.mp_reg = HERO.base_mp_reg + HERO.int * ATTRIBUTE_GROWTH.MP_REG_PER_INT;

        HERO.armor = HERO.base_armor + HERO.agi * ATTRIBUTE_GROWTH.ARMOR_PER_AGI;
        HERO.as = HERO.attack_speed_per_second();

        lvl.update_html();
    }

    lvl.update_html = function() {
        lvl.$content.html( lvl.current );

        lvl.$str.html( Math.floor( HERO.str ) );
        lvl.$agi.html( Math.floor( HERO.agi ) );
        lvl.$int.html( Math.floor( HERO.int ) );

        var t = Math.floor( HERO.hp );
        lvl.$hp.html( t + ' / ' + t );
        lvl.$hp.attr( 'reg', HERO.hp_reg.toFixed(1) );

        t = Math.round( HERO.mp );
        lvl.$mp.html(  t + ' / ' + t );
        lvl.$mp.attr( 'reg', HERO.mp_reg.toFixed(1) );

        lvl.$attack_per_second.html( HERO.as.toFixed(2) );
        lvl.$armor.html( HERO.armor.toFixed(2) );

        lvl.$dmg_min.html( Math.floor(HERO.dmg_min) );
        lvl.$dmg_max.html( Math.floor(HERO.dmg_max) );

        lvl.$ms.html( HERO.ms );

        lvl.$magic_resist.html( HERO.magic_resist + '%' );

        lvl.$attack_range.html( HERO.attack_range );
    }


    lvl.collect_talents_stats = function(){
        if ( HERO.TALENT_STATS !== null )
            return false;

        HERO.TALENT_STATS = {
            str_base : 0,
            int_base : 0,
            agi_base : 0
        };

        talent.$content.find('div.talent > span').each(function () {

            var text = $(this).text();

            var matches = text.match(/\+(\d+\.?\d?)%? \s?(Damage|Movement Speed|Armor|Health regen|Health|Mana regen|Mana|Attack Speed|Magic Resistance|Attack Range|All Stats|Strength|Intelligence|Agility)/i);
            if ( matches !== null )
            {
                var stat = matches[2].toLowerCase();
                var value = matches[1];

                if ( stat == 'mana regen' || stat == 'health regen' )
                {
                    value = parseFloat( value );
                }
                else
                {
                    value = parseInt( value );
                }

                switch ( stat ) {
                    case 'damage':
                        HERO.TALENT_STATS.base_dmg_min = value;
                        HERO.TALENT_STATS.base_dmg_max = value;
                    break;

                    case 'movement speed':
                        HERO.TALENT_STATS.ms = value;
                        break;

                    case 'armor':
                        HERO.TALENT_STATS.base_armor = value;
                        break;

                    case 'health regen':
                        HERO.TALENT_STATS.base_hp_reg = value;
                        break;

                    case 'health':
                        HERO.TALENT_STATS.BASE_HP = value;
                        break;

                    case 'mana regen':
                        HERO.TALENT_STATS.base_mp_reg = value;
                        break;

                    case 'mana':
                        HERO.TALENT_STATS.BASE_MP = value;
                        break;

                    case 'attack speed':
                        HERO.TALENT_STATS.base_as = value;
                        break;

                    case 'magic resistance':
                        HERO.TALENT_STATS.magic_resist = value;
                        break;

                    case 'attack range':
                        HERO.TALENT_STATS.attack_range = value;
                        break;

                    case 'all stats':
                        HERO.TALENT_STATS.str_base += value;
                        HERO.TALENT_STATS.int_base += value;
                        HERO.TALENT_STATS.agi_base += value;
                        break;

                    case 'strength':
                        HERO.TALENT_STATS.str_base += value;
                        break;

                    case 'intelligence':
                        HERO.TALENT_STATS.int_base += value;
                        break;

                    case 'agility':
                        HERO.TALENT_STATS.agi_base += value;
                        break;
                }
            }

        });
    }

    lvl.apply_talents = function() {
        lvl.collect_talents_stats();

        for ( var stat in HERO.TALENT_STATS ) {
            HERO[stat] += HERO.TALENT_STATS[stat];
        }

        talent.$object.attr( 'src', talent.src_full );
        talent.$content.addClass('active');
    }

    lvl.unapply_talents = function() {
        for ( var stat in HERO.TALENT_STATS ) {
            HERO[stat] -= HERO.TALENT_STATS[stat];
        }

        talent.$object.attr( 'src', talent.src );
        talent.$content.removeClass('active');
    }


    lvl.$lvl_up.on( 'click', function() {
        if ( lvl.current == lvl.max )
            return;

        lvl.current++;

        if ( lvl.current == lvl.max )
            lvl.apply_talents();

        lvl.update();
    });

    lvl.$lvl_down.on('click' ,  function() {
        if ( lvl.current == 1 )
            return;

        if ( lvl.current == lvl.max )
            lvl.unapply_talents();

        lvl.current--;

        lvl.update();
    })

    var content = {
        $data : $('div#third'),
        $waiting : $('#waiting'),
        $list : $('div.list'),
        $branching : $('#first'),
        $branching_second : $('#second'),
        $branching_third : $('#third'),
        chart_tempo_id : 'highcharts_tempo',
        Highcharts_tempo : {},
        chart_macrotask_id : 'highcharts_macrotask',
        Highcharts_macrotask : {},
        create_Highchar_macrotask : function(id,data){
            return Highcharts.chart( id  , {
                chart: {
                    backgroundColor : $('#' + id).css('background-color'),
                    type : 'column',
                    spacing:[10,40,15,10],
                },
                title: {
                    text: null,
                    margin : 10,
                },
                xAxis: {
                    type: 'category',
                    Width:1,
                    labels: {
                        useHTML : true,
                        style : {fontSize:'9px'},
                        formatter: function () {
                            return '<a href="learn/glossarij/' + macrotasks.data[ this.value ].url + '" target="_blank">' + macrotasks.data[ this.value ].text + '</a>';
                        }
                    },
                    lineColor: '#555',
                    categories:  macrotasks.keys,
                    plotBands: [{
                        from: -1,
                        to: 4.5,
                        color: 'rgba(108 ,210, 255, .2)',
                        zIndex: 20,
                        label: {
                            useHTML : true,
                            text: '<span style="color : #999; padding:5px;background:rgba(21,21,21,0.3);">' + __('Macrotask_support') + '</span>',
                            y: 20
                        }
                    },
                    {
                        from: 4.5,
                        to: 9.5,
                        color: 'rgba(68, 170, 213, .2)',
                        zIndex: 20,
                        label: {
                            useHTML : true,
                            text: '<span style="color : #999; padding:5px;background:rgba(21,21,21,0.3);">' + __('Macrotask_objects') + '</span>',
                            y: 20
                        }
                    },
                    {
                        from: 9.5,
                        to: 15,
                        zIndex: 20,
                        color: 'rgba(28, 130, 173, .2)',
                        label: {
                            useHTML : true,
                            text: '<span style="color : #999; padding:5px;background:rgba(21,21,21,0.3);">' + __('Macrotask_fight') + '</span>',
                            y: 20
                        }
                    }]
                },
                yAxis: {
                    title: {
                        text: null
                    },
                    labels: {
                        style : {  "fontSize": "10px" },
                        formatter: function () {
                            var t = Math.floor( this.value / 3 );
                            return __('Macrotask_description_' + t);
                        }
                    },
                    tickAmount : 5,

                    lineWidth:1,
                    lineColor: '#555',
                    gridLineWidth: 0,
                    gridLineColor: '#555',
                    min: 0,
                    max: 20,
                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    column: {
                        borderColor: '#aaa',
                        color: '#2b908f',
                        minPointLength: 2
                    }
                },
                tooltip: {
                    useHTML: true,
                    headerFormat: null,
                    pointFormatter: function () {
                        var t = Math.floor( this.y / 3 );
                        return  '<span style="text-align:center;font-size: 12px;">' + macrotasks.data[this.category].text + '</span> : ' +
                            '<b style="font-size: 12px;">' + __('Macrotask_description_' + t) + '</b><div style="white-space:normal; width:200px;font-size:12px;color:#888;margin-top:5px;">' + macrotasks.data[this.category].description + '</div>';
                    },
                    crosshairs: false,
                    shared: true
                },
                credits: {
                    enabled: false
                },
                series: [{
                    data : data,
                }]
            });

        },
        create_Highchar : function( id, color, symbol, data  ){
            return Highcharts.chart( id  , {
                chart: {
                    backgroundColor : $('#' + id).css('background-color'),
                    type : 'spline',
                    borderWidth:0,
                    borderColor : '#555',
                    spacing:[10,40,15,10],
                },
                title: {
                    text: null,
                    margin : 10,
                },
                xAxis: {
                    lineWidth:1,
                    labels: {
                        useHTML : true,
                    },
                    lineColor: '#555',
                    categories: ['<a target="_blank" href="learn/glossarij/laning_stage">' + __('Laning_stage') + '</a></br> (0-10 ' + __('min') + ')',
                        '<a target="_blank" href="learn/glossarij/early_game">' + __('Early_game') + '</a></br> (10-20 ' + __('min') + ')',
                        '<a target="_blank" href="learn/glossarij/mid_game">' + __('Mid_game') + '</a></br> (20-45 ' + __('min') + ')',
                        '<a target="_blank" href="learn/glossarij/late_game">' + __('Late_game') + '</a></br> (45+ ' + __('min') + ')']
                },
                yAxis: {
                    title: {
                        text: null
                    },
                    labels: {
                        style : {  "fontSize": "10px" },
                        formatter: function () {
                            var t = Math.floor( this.value / 3 );
                            return __('Macrotask_description_' + t);
                        }
                    },
                    tickAmount : 3,

                    lineWidth:1,
                    lineColor: '#555',
                    gridLineWidth: 0,
                    gridLineColor: '#555',
                    min: 0,
                    max: 20,
                    plotLines: [{
                        color: '#aaa',
                        width: 1,
                        value: 10,
                        dashStyle: 'LongDashDotDot',
                    }]
                },
                tooltip: {
                    useHTML: true,
                    headerFormat: '<div style="text-align:center;font-size: 12px">{point.key}</div>',
                    pointFormatter: function () {
                        var t = Math.floor( this.y / 3 );
                        return  '<div style="text-align: center"><b>' + __('Macrotask_description_' + t) + '</b></div>';
                    },
                    crosshairs: false,
                    shared: true
                },
                credits: {
                    enabled: false
                },
                legend:{
                    enabled: false
                },
                series: [{
                    pointPlacement : 'on',
                    type: 'spline',
                    animation: {
                        duration: 1000
                    },
                    color: color,
                    marker: {
                        radius: 3,
                        lineWidth: 2,
                        lineColor: null,
                        symbol: symbol
                    },
                    data : data
                }]
            });
        },
        refresh : function( f = false ) {
            content.$list.find('.active').removeClass('active');
            content.$data.children('div[class^="role"]').not('.none').addClass('none');
            content.$branching.addClass('active');
            content.$branching_second.addClass('active');
            content.$branching_third.addClass('active');
            content.$waiting.remove();

            if ( !f ){
                content.Highcharts_tempo = content.create_Highchar( content.chart_tempo_id, style[role.role].color, style[role.role].type , roles_data[ role.id ]  );
                content.Highcharts_macrotask = content.create_Highchar_macrotask( content.chart_macrotask_id,  macrotasks.values[ role.id ]  );
            }
            else {
                content.Highcharts_tempo.destroy();
                content.Highcharts_macrotask.destroy();
            }
        }

    };

    var $blocks = content.$list.children(),
        $top_lines = $blocks.find('div[class^="line_top"]'),
        $bot_lines = $blocks.find('div[class^="line_bot"]'),
        blocks_length = $blocks.length;

    var role = {
        id : null,
        role : null
    };



    $('.hero_roles a[role_id]').click(function( event, change_history = true ) {
        var $div_block = $(this).closest('div.block');
        if ( $div_block.hasClass('active') )
            return false;

        role.id = $(this).attr('role_id');
        role.role = $(this).attr('role');

        var index = $div_block.index();
        var mid = Math.floor( blocks_length / 2 );

        content.refresh();

        if ( blocks_length % 2 == 1 && index == mid )
        {
            //center
        }
        else
        {
            var eq_start, eq_end;

            if ( index < mid )
            {
                eq_start = ( ( index + 1 ) * 2 ) - 1;
                eq_end = blocks_length;
            }
            else
            {
                eq_start = blocks_length;
                eq_end = index * 2 + 1;
            }

            $top_lines.slice(eq_start, eq_end).addClass('active');
            $bot_lines.slice(eq_start, eq_end).addClass('active');
        }


        content.$data.children('.role_' + role.id).removeClass('none');

        $div_block.addClass('active');
        content.$branching.addClass('active');
        content.$branching_second.addClass('active');
        content.$branching_third.addClass('active');

        if ( change_history )
            history.pushState({'role' : role.id }, 'Role ' + role.id, window.location.pathname + '?role=' + role.id);
        return false;
    });

    function change_role_from_url( page_load )
    {
        const urlParams = new URLSearchParams( window.location.search );
        var role = urlParams.get('role');
        if ( role !== null )
        {
            role = parseInt( role );

            $('.hero_roles a[role_id="' + role + '"]').trigger('click', [false] );
        }
        else if ( !page_load )
        {
            content.refresh( true );
        }
    }

    change_role_from_url( true );

    window.onpopstate = function (event) {
        if (event.state) {
            change_role_from_url( false );
        } else {
            // history changed because of a page load
            change_role_from_url( false );
        }
    }

})