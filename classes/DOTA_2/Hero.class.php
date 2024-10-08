<?php

namespace DOTA_2;


class Hero
{
    private static $parser = array(
         array(
            'lang' => \Localka::EN,
            'url' => 'https://dota2.gamepedia.com/',
        ),
        array(
            'lang' => \Localka::RU,
            'url' => 'https://dota2-ru.gamepedia.com/',
        ),
    );

    private static $talents_parse_url = 'https://dota2.gamepedia.com/Talents';
    private static $aghanims_parse_url = 'https://liquipedia.net/dota2/Aghanim%27s_Scepter';

    CONST HP_PER_STR = 20;
    CONST HP_REG_PER_STR = 0.1;
    CONST MP_PER_INT = 12;
    CONST MP_REG_PER_INT = 0.05;
    CONST AS_PER_AGI = 1;
    CONST ARMOR_PER_AGI = 0.166666;
    CONST DMG_PER_PRIMARY_ATTRIBUTE = 1;
    CONST BASE_HP = 200;
    CONST BASE_MP = 75;
    CONST LVL_MAX = 30;

    CONST STR = 'str';
    CONST AGI = 'agi';
    CONST INT = 'int';

    CONST ROLE_HARD_SUPPORT = 5;
    CONST ROLE_SOFT_SUPPORT = 4;
    CONST ROLE_OFFLANE = 3;
    CONST ROLE_MID  = 2;
    CONST ROLE_CARRY = 1;

    public static function attributes_array()
    {
        return array(
            self::STR => array( 'text' =>  __('Strength'), 'url' => 'strength' ) ,
            self::AGI => array( 'text' =>  __('Agility'), 'url' => 'agility' ) ,
            self::INT => array( 'text' =>  __('Intelligence'), 'url' => 'intelligence' )
        );
    }


    public static function roles()
    {
        return array(
            self::ROLE_CARRY => array(
                'name' => __('Role_Carry'),
                'alt_name' => __('Role_Carry_2'),
                'url' => __('role_carry')
            ),
            self::ROLE_MID => array(
                'name' => __('Role_Mid'),
                'alt_name' => __('Role_Mid_2'),
                'url' => __('role_mid')
            ),
            self::ROLE_OFFLANE => array(
                'name' => __('Role_Offlane'),
                'alt_name' => __('Role_Offlane_2'),
                'url' => __('role_offlane')
            ),
            self::ROLE_SOFT_SUPPORT => array(
                'name' => __('Role_Soft_support'),
                'alt_name' => __('Role_Soft_support_2'),
                'url' => __('role_soft_support')
            ),
            self::ROLE_HARD_SUPPORT => array(
                'name' => __('Role_Hard_support'),
                'alt_name' => __('Role_Hard_support_2'),
                'url' => __('role_hard_support')
            ),
        );
    }


    public static function attribute_growth_json()
    {
        //ini_set( 'serialize_precision', -1 );
        return json_encode(
            array(
                'HP_PER_STR' => self::HP_PER_STR,
                'HP_REG_PER_STR' => self::HP_REG_PER_STR,
                'MP_PER_INT' => self::MP_PER_INT,
                'MP_REG_PER_INT' => self::MP_REG_PER_INT,
                'AS_PER_AGI' => self::AS_PER_AGI,
                'ARMOR_PER_AGI' => self::ARMOR_PER_AGI,
                'DMG_PER_PRIMARY_ATTRIBUTE' => self::DMG_PER_PRIMARY_ATTRIBUTE,
            )
        );
    }

    public static function attack_per_second( $base_attack_speed, $base_attack_time, $agility )
    {
        return number_format( ( $base_attack_speed + $agility ) * 0.01 / $base_attack_time , 2 );
    }

    public static function attack_interval( $base_attack_speed, $base_attack_time, $agility )
    {
        return number_format($base_attack_time * 100 / ( $base_attack_speed + $agility ) , 2);
    }

    public static function hp( $strength )
    {
        return ( self::BASE_HP + $strength * self::HP_PER_STR );
    }

    public static function hp_reg( $strength, $base_hp_regen = 0 )
    {
        return ( $base_hp_regen + $strength * self::HP_REG_PER_STR );
    }

    public static function mp( $intelligence )
    {
        return ( self::BASE_MP + $intelligence * self::MP_PER_INT );
    }

    public static function mp_reg( $intelligence, $base_mp_regen = 0 )
    {
        return ( $base_mp_regen + $intelligence * self::MP_REG_PER_INT );
    }

    public static function armor( $base_armor, $agility )
    {
        return floor( $base_armor + $agility * self::ARMOR_PER_AGI );
    }

    /**
     * @param $hero_name
     * @param $system_image_name
     * @return string(html)
     * 59x33
     */
    public static function avatar_small_html( $hero_name, $system_image_name )
    {
        return "<img src='https://cdn.cloudflare.steamstatic.com/apps/dota2/images/heroes/" . $system_image_name . "_sb.png' alt='$hero_name' title='$hero_name' class='hero_avatar_small' />";
    }

    /**
     * @param $hero_name
     * @param $system_image_name
     * @return string(html)
     * 256x144
     */
    public static function avatar_horizontal_html( $hero_name, $system_image_name )
    {
        return "<img src='https://cdn.cloudflare.steamstatic.com/apps/dota2/images/heroes/" . $system_image_name . "_full.png' alt='$hero_name' title='$hero_name' class='hero_avatar_horizontal' />";
    }

    /**
     * @param $hero_name
     * @param $system_image_name
     * @return string(html)
     * 235x272
     */
    public static function avatar_vertical_html( $hero_name, $system_image_name )
    {
        return "<img src='https://cdn.cloudflare.steamstatic.com/apps/dota2/images/heroes/" . $system_image_name . "_vert.jpg' alt='$hero_name' title='$hero_name' class='hero_avatar_vertical' />";
    }

    /**
     * @param $hero_name
     * @param $system_image_name
     * @return string(html)
     * 49x85 + 147x196
     */
    public static function avatar_animated_html( $hero_name, $system_image_name, $type = null )
    {
        return "<span class='hero_avatar_animated'>
                    <img src='https://cdn.cloudflare.steamstatic.com/apps/dota2/images/heroes/" . $system_image_name . "_vert.jpg' alt='$hero_name' class=' hero_avatar_animated' />
                    <video class='none' src='" .\Config::$static_url . "/images/dota_2/heroes_animated/" . $system_image_name . ".mp4' loop='true' poster='https://cdn.cloudflare.steamstatic.com/apps/dota2/images/heroes/" . $system_image_name . "_vert.jpg' muted='muted'></video>
                    <span class='hero_name'>$hero_name" . ( is_null( $type ) ? '' : ( ' ' . $type ) ) . "</span>
                </span>";
    }

    /**
     * @param $hero_name
     * @param $url
     * @return string(html)
     * 32x32
     */
    public static function icon_html( $hero_name, $url )
    {
        return '<img src="' . self::icon( $url ) . '" alt="' .$hero_name . '" title="' . $hero_name . '" class="hero_icon" />';
    }

    /**
     * @param $url
     * @return string
     */
    public static function icon( $url )
    {
        return \Config::$static_url . 'images/dota_2/heroes/' . $url . '_minimap_icon.png';
    }


    public static function update_stats( $id, $name, $add_description = false )
    {
        $data = array();
        $options = reset( self::$parser );

        //how many spaces in hero name? its ruin parser and query
        $name_spaces_count = mb_substr_count( $name , ' ' );
        if ( $name_spaces_count > 0 )
            $name = str_replace(' ' , '_', $name);


        $url = $options['url'] . $name;
        $html = \CURL::url_get_contents( $url );
        if ( empty ( $html ) )
        {
            throw new \Exception\Fatal( "no html from $url" );
        }

        $dom = new \domDocument;
        @$dom->loadHTML( $html );
        try
        {
            $finder = new \DomXPath( $dom );

            //parse base stats
            $table_element = $finder->query("//table[@class='infobox']" );
            $parse_content = $table_element->item(0)->textContent;

            if ( empty( $parse_content ) )
            {
                throw new \Exception\Fatal( "error parsing content $name" );
            }
            //Abaddon 23 + 3 23 + 1.5 18 + 2 Level 0 1 15 25 30 Health 200 660 1500 2100 2400 Health regen 0 2.3 6.5 9.5 11 Mana 75 291 627 867 987
            // Mana regen 0 0.9 2.3 3.3 3.8 Armor -1 2.83 6.33 8.83 10.08 Att/sec 0.71 0.84 0.96 1.05 1.1 Damage 28‒38 51‒61 93‒103 123‒133 138‒148
            // Magic resistance 25% Link▶️ Movement speed 325 Link▶️ Attack speed 120 Turn rate 0.5 Vision range 1800/800 Attack range 150
            // Projectile speed Instant Attack animation 0.56+0.41 Base attack time 1.7 Damage block 8 Collision size 24 Legs 2  Gib type Ethereal

            $parse_content = preg_replace( '/\s+/', ' ', $parse_content);
            //[ Info Needed ] remove from search string
            $parse_content = str_replace( '[ Info Needed ]' , '' , $parse_content );
            $temp = explode(' ' , $parse_content );

            for ( $i=0; $i < $name_spaces_count; $i++ )
            {
                array_shift( $temp );
            }

            $data = array(
                'str' => floatval( $temp[ 2 ] ),
                'str_inc' => floatval( $temp[ 4 ]),
                'agi' => floatval( $temp[ 5 ]),
                'agi_inc' => floatval($temp[ 7 ]),
                'int' => floatval($temp[ 8 ]),
                'int_inc' => floatval($temp[ 10 ]),
                'base_hp' => $temp[ 18 ],
                'start_hp' => $temp[ 19 ],
                'base_hpreg' => $temp[ 25 ],
                'start_hpreg' => $temp[ 26 ],
                'base_mp' => $temp[ 31 ],
                'start_mp' => $temp[ 32 ],
                'base_mpreg' => floatval($temp[ 38 ]),
                'start_mpreg' => floatval($temp[ 39 ]),
                'base_armor' => floatval($temp[ 44 ]),
                'start_armor' => floatval($temp[ 45 ]),
                'base_as' => $temp[ 71 ],
                'base_dmg_min' => mb_substr( $temp[ 56 ] , 0, strpos( $temp[56], '‒') ),
                'base_dmg_max' => mb_substr( $temp[ 56 ] ,  strpos( $temp[56], '‒') + 1 ),
                'start_dmg_min' => mb_substr( $temp[ 57 ] , 0, strpos( $temp[57], '‒') ),
                'start_dmg_max' => mb_substr( $temp[ 57 ] ,  strpos( $temp[57], '‒') + 1 ),
                'magic_resist' => intval( $temp[ 63 ] ),
                'ms' => $temp[ 67 ],
                'bas' => $temp[ 90 ],
                'turn_rate' => floatval($temp[ 74 ]),
                'vision_day' => substr( $temp[ 77 ] , 0, strpos( $temp[77], '/') ),
                'vision_night' => substr( $temp[ 77 ] ,  strpos( $temp[77], '/') + 1 ),
                'attack_range' => $temp[ 80 ],
                'projectile_speed' => intval( $temp[ 83 ] ),
                'attack_point' => floatval( substr( $temp[ 86 ] , 0, strpos( $temp[86], '+') ) ),
                'attack_backswing' => floatval( substr( $temp[ 86 ] ,  strpos( $temp[86], '+') + 1 ) ),
                'damage_block' => $temp[ 93 ],
                'collision_size' => $temp[ 96 ],
                'legs' => intval( $temp[ 98 ] ),
            );


            if ( $add_description )
            {
                //parse language data
                $content_element = $finder->query("//p[preceding-sibling::table[@class='infobox']]" );
                $parse_content = $content_element->item(0)->textContent;

                //get primary attribute from text
                preg_match('/(strength|intelligence|agility)/i' , $parse_content , $matches );
                if ( empty($matches[1] ) )
                {
                    $data['primary_attr'] = 'str';
                }
                elseif ( $matches[1] == 'strength' )
                {
                    $data['primary_attr'] = 'str';
                }
                elseif ( $matches[1] == 'intelligence' )
                {
                    $data['primary_attr'] = 'int';
                }
                elseif ( $matches[1] == 'agility' )
                {
                    $data['primary_attr'] = 'agi';
                }

                \DB\DOTA_2\Heroes_data::if_not_insert_update( array(
                    'hero_id' => $id,
                    'lang' => $options['lang'],
                    'description' => $parse_content
                    ),
                    array(
                        'description' => $parse_content
                    )
                );

                //other languages
                while ( $options = next( self::$parser ) )
                {
                    $url = $options['url'] . $name;
                    $html = \CURL::url_get_contents( $url );
                    if ( empty ( $html ) )
                    {
                        throw new \Exception\Fatal( "no html from $url" );
                    }

                    $dom = new \domDocument;
                    @$dom->loadHTML( $html );

                    $finder = new \DomXPath( $dom );

                    $content_element = $finder->query("//p[preceding-sibling::table[@class='infobox']]" );
                    $parse_content = $content_element->item(0)->textContent;

                    \DB\DOTA_2\Heroes_data::if_not_insert_update( array(
                        'hero_id' => $id,
                        'lang' => $options['lang'],
                        'description' => $parse_content
                    ),
                        array(
                            'description' => $parse_content
                        )
                    );
                }
            }

            \DB\DOTA_2\Heroes::update( $data , array('id' => $id ) );
        }
        catch ( \Exception $e )
        {
            \DB::rollback();
            throw new \Exception\Fatal( $e->getMessage() );
        }
    }

    public static function update_all_stats()
    {
        @set_time_limit ( 300 );

        $data = \DB\DOTA_2\Heroes::select( array('id', 'name') )->rows();
        foreach ( $data as $row )
        {
            self::update_stats( $row['id'] , $row['name'] , false );
        }
    }

    private static function DOMinnerHTML(\DOMNode $element)
    {
        $innerHTML = "";
        $children  = $element->childNodes;

        foreach ($children as $child)
        {
            $innerHTML .= $element->ownerDocument->saveHTML($child);
        }

        return $innerHTML;
    }


    private static function get_value_text_from_talent( $string )
    {
        preg_match( '/^([^<>]+)\s(.+)$/U', $string, $matches );
        if ( empty ( $matches) )
        {
            return array( 'value' => null , 'text' => $string );
        }

        return array('value' => $matches[1], 'text' => $matches[2]);
    }

    public static function update_talents()
    {
        $html = \CURL::url_get_contents( self::$talents_parse_url );
        if (empty ($html)) {
            throw new \Exception\Fatal("no html from " . self::$talents_parse_url );
        }

        $data = \DB\DOTA_2\Heroes::select(array('id', 'name'))->rows('name');

        $dom = new \domDocument;
        @$dom->loadHTML($html);
        try
        {
            $finder = new \DomXPath($dom);

            //parse base stats
            $table_element = $finder->query("//table[@class='wikitable']")->item(0);
            if ( empty( $table_element ) )
            {
                throw new \Exception\Fatal( "error parsing table" );
            }

            $nodes = $table_element->getElementsByTagName("tr");

            $i = 0;
            foreach ( $nodes as $tr )
            {
                //remove fistr tr(table headers)
                if ( $i++ == 0)
                {
                    continue;
                }

                if ( $i % 2 == 0 )
                {
                    //6 elements(image name, 4 left talents) + 4 elements(4 right talents)
                    $temp = array();
                }

                foreach ( $tr->getElementsByTagName("td") as $td )
                {
                    //$td->removeAttribute('');
                    $temp[] = preg_replace( '/(srcset=".*")/' , '', strip_tags( self::DOMinnerHTML( $td ), '<img>' ) );
                }



                if ( $i % 2 == 1 )
                {
                    //	hero_id	lvl	left_talent	right_talent
                    $temp[1] = trim( preg_replace( '/\s+/', ' ', $temp[1]) );


                    //remove attributes

                    for ( $j = 2 ; $j <= 9; $j++ )
                    {
                        $temp[$j] = preg_replace('/<img(.*) src="([^?"]+).*"(.*)>/im' , '<img src="${2}"/>' , $temp[$j]);
                    }

                    $data[ $temp[1] ]['10']['left_talent'] = $temp[2];
                    $data[ $temp[1] ]['10']['left_talent_values'] = self::get_value_text_from_talent( $data[ $temp[1] ]['10']['left_talent'] );

                    $data[ $temp[1] ]['15']['left_talent'] = $temp[3];
                    $data[ $temp[1] ]['15']['left_talent_values'] = self::get_value_text_from_talent( $data[ $temp[1] ]['15']['left_talent'] );

                    $data[ $temp[1] ]['20']['left_talent'] = $temp[4];
                    $data[ $temp[1] ]['20']['left_talent_values'] = self::get_value_text_from_talent( $data[ $temp[1] ]['20']['left_talent'] );

                    $data[ $temp[1] ]['25']['left_talent'] = $temp[5];
                    $data[ $temp[1] ]['25']['left_talent_values'] = self::get_value_text_from_talent( $data[ $temp[1] ]['25']['left_talent'] );

                    $data[ $temp[1] ]['10']['right_talent'] = $temp[6];
                    $data[ $temp[1] ]['10']['right_talent_values'] = self::get_value_text_from_talent( $data[ $temp[1] ]['10']['right_talent'] );

                    $data[ $temp[1] ]['15']['right_talent'] = $temp[7];
                    $data[ $temp[1] ]['15']['right_talent_values'] = self::get_value_text_from_talent( $data[ $temp[1] ]['15']['right_talent'] );

                    $data[ $temp[1] ]['20']['right_talent'] = $temp[8];
                    $data[ $temp[1] ]['20']['right_talent_values'] = self::get_value_text_from_talent( $data[ $temp[1] ]['20']['right_talent'] );

                    $data[ $temp[1] ]['25']['right_talent'] = $temp[9];
                    $data[ $temp[1] ]['25']['right_talent_values'] = self::get_value_text_from_talent( $data[ $temp[1] ]['25']['right_talent'] );


                }
            }


            foreach ( $data as $row )
            {
                for ( $i = 10; $i <= 25; $i+=5 )
                {
                    \DB\DOTA_2\Heroes_talent::if_not_insert_update(
                        array(
                            'hero_id' => $row['id'],
                            'lvl' => $i,
                            'left_talent' => $row[ $i ]['left_talent'],
                            'left_talent_value' => $row[ $i ]['left_talent_values']['value'],
                            'left_talent_text' => $row[ $i ]['left_talent_values']['text'],
                            'right_talent' => $row[ $i ]['right_talent'],
                            'right_talent_value' => $row[ $i ]['right_talent_values']['value'],
                            'right_talent_text' => $row[ $i ]['right_talent_values']['text'],
                        ),
                        array(
                            'left_talent' => $row[ $i ]['left_talent'],
                            'left_talent_value' => $row[ $i ]['left_talent_values']['value'],
                            'left_talent_text' => $row[ $i ]['left_talent_values']['text'],
                            'right_talent' => $row[ $i ]['right_talent'],
                            'right_talent_value' => $row[ $i ]['right_talent_values']['value'],
                            'right_talent_text' => $row[ $i ]['right_talent_values']['text'],
                        )
                    );
                }
            }
        }
        catch ( \Exception $e )
        {
            \DB::rollback();
            throw new \Exception\Fatal( $e->getMessage() );
        }
    }


    public static function update_aghanims()
    {
        @set_time_limit ( 300 );
        $html = \CURL::url_get_contents( self::$aghanims_parse_url );
        if (empty ($html)) {
            throw new \Exception\Fatal("no html from " . self::$talents_parse_url );
        }

        $data = \DB\DOTA_2\Heroes::select(array('id', 'name', 'system_image_name'))->rows('name');

        $dom = new \domDocument;
        @$dom->loadHTML($html);
        try
        {
            //parse base stats
            $nodes = $dom->getElementsByTagName("h3");
            echo '<pre>';
            foreach ( $nodes as $h3 )
            {
                $hero_name = trim( preg_replace( '/\s+/', ' ', str_replace( '[edit]' , '' , $h3->textContent ) ) );
                if ( isset( $data[ $hero_name ]) )
                {
                    //get UL with info
                    $ul = $h3->nextSibling;
                    if ( $ul->nodeType === 3 )
                    {
                        $ul = $ul->nextSibling;
                    }
                    $html = self::DOMinnerHTML( $ul );
                    //remove <li></li>
                    $html = substr( $html , 4, -5 );

                    $html = trim( strip_tags( $html ,'<ul><li><b>') );

                    $html = preg_replace( '/\s+/', ' ', $html );

                    $data[ $hero_name ]['effect'] = $html;
                }
            }

            //Void Spirit none
            //Snapfire none
            $data['Void Spirit']['effect'] = '<b>Resonant Pulse</b>. 
            <ul><li>Causes Resonant Pulse silence(2 sec).</li><li>Gain two charges.</li></ul>';

            $data['Snapfire']['effect'] = '<b>Gobble Up</b>. 
            <ul><li>Mortimer gobbles up a creep or an allied hero, which he can then spit towards enemies. The unit stays in his belly up to 3 seconds.</li><li>Stun Duration: 1.5 sec, debuff(ms slow 25%, 100 dmg/second) duration 1 sec</li></ul>';


            foreach ( $data as $hero => &$row )
            {
                preg_match_all('/<b>(.*)<\/b>/iUm' , $row['effect'] , $matches );

                if ( !empty( $matches[1]) )
                {
                    $replace = array();

                    foreach ( $matches[1] as $skill_name )
                    {
                        ///apps/dota2/images/abilities/drow_ranger_wave_of_silence_md.png
                        $url = 'https://cdn.cloudflare.steamstatic.com/apps/dota2/images/abilities/' . $row['system_image_name'] . '_' . mb_strtolower( str_replace( array(" ", "'") , array('_' , "") , $skill_name ) ) .'_hp1.png';
                        if ( \CURL::remote_file_exists( $url ) )
                        {
                            $replace[] = '<img src="' . $url .'" alt="' . $skill_name . '" title="' . $skill_name . '" /><b>' . $skill_name .'</b>';
                        }
                        else
                        {
                            $replace[] = '<b>' . $skill_name .'</b>';
                            /*
                             *  Juggernaut Omnislash https://cdn.cloudflare.steamstatic.com/apps/dota2/images/abilities/juggernaut_omnislash_hp1.png
                                Mirana Starstorm https://cdn.cloudflare.steamstatic.com/apps/dota2/images/abilities/mirana_starstorm_hp1.png
                                Morphling Morph https://cdn.cloudflare.steamstatic.com/apps/dota2/images/abilities/morphling_morph_hp1.png
                                Phantom Lancer Phantom Rush https://cdn.cloudflare.steamstatic.com/apps/dota2/images/abilities/phantom_lancer_phantom_rush_hp1.png
                                Sand King Burrowstrike https://cdn.cloudflare.steamstatic.com/apps/dota2/images/abilities/sand_king_burrowstrike_hp1.png
                                Sand King Caustic Finale https://cdn.cloudflare.steamstatic.com/apps/dota2/images/abilities/sand_king_caustic_finale_hp1.png
                                Sven Storm Hammer https://cdn.cloudflare.steamstatic.com/apps/dota2/images/abilities/sven_storm_hammer_hp1.png
                                Tiny Tree Volley https://cdn.cloudflare.steamstatic.com/apps/dota2/images/abilities/tiny_tree_volley_hp1.png
                                Zeus Nimbus https://cdn.cloudflare.steamstatic.com/apps/dota2/images/abilities/zuus_nimbus_hp1.png
                                Kunkka Torrent Storm https://cdn.cloudflare.steamstatic.com/apps/dota2/images/abilities/kunkka_torrent_storm_hp1.png
                                Necrophos Ghost Shroud https://cdn.cloudflare.steamstatic.com/apps/dota2/images/abilities/necrolyte_ghost_shroud_hp1.png
                                Warlock Chaotic Offering https://cdn.cloudflare.steamstatic.com/apps/dota2/images/abilities/warlock_chaotic_offering_hp1.png
                                Templar Assassin Psionic Projection https://cdn.cloudflare.steamstatic.com/apps/dota2/images/abilities/templar_assassin_psionic_projection_hp1.png
                                Clockwerk Overclocking https://cdn.cloudflare.steamstatic.com/apps/dota2/images/abilities/rattletrap_overclocking_hp1.png
                                Nature's Prophet Nature's Call https://cdn.cloudflare.steamstatic.com/apps/dota2/images/abilities/furion_natures_call_hp1.png
                                Clinkz Skeleton Walk https://cdn.cloudflare.steamstatic.com/apps/dota2/images/abilities/clinkz_skeleton_walk_hp1.png
                                Enchantress Sproink https://cdn.cloudflare.steamstatic.com/apps/dota2/images/abilities/enchantress_sproink_hp1.png
                                Spectre Shadow Step https://cdn.cloudflare.steamstatic.com/apps/dota2/images/abilities/spectre_shadow_step_hp1.png
                                Gyrocopter Side Gunner https://cdn.cloudflare.steamstatic.com/apps/dota2/images/abilities/gyrocopter_side_gunner_hp1.png
                                Alchemist Aghanim's Scepter Synth https://cdn.cloudflare.steamstatic.com/apps/dota2/images/abilities/alchemist_aghanims_scepter_synth_hp1.png
                                Lycan Wolf Bite https://cdn.cloudflare.steamstatic.com/apps/dota2/images/abilities/lycan_wolf_bite_hp1.png
                                Timbersaw Chakram (Scepter) https://cdn.cloudflare.steamstatic.com/apps/dota2/images/abilities/shredder_chakram_(scepter)_hp1.png
                                Abaddon Mist Coil https://cdn.cloudflare.steamstatic.com/apps/dota2/images/abilities/abaddon_mist_coil_hp1.png
                                Elder Titan Astral Spirit https://cdn.cloudflare.steamstatic.com/apps/dota2/images/abilities/elder_titan_astral_spirit_hp1.png
                                Techies Proximity Mines https://cdn.cloudflare.steamstatic.com/apps/dota2/images/abilities/techies_proximity_mines_hp1.png
                                Earth Spirit Enchant Remnant https://cdn.cloudflare.steamstatic.com/apps/dota2/images/abilities/earth_spirit_enchant_remnant_hp1.png
                                Earth Spirit Stone Remnant https://cdn.cloudflare.steamstatic.com/apps/dota2/images/abilities/earth_spirit_stone_remnant_hp1.png
                                Arc Warden Rune Forge https://cdn.cloudflare.steamstatic.com/apps/dota2/images/abilities/arc_warden_rune_forge_hp1.png
                                Grimstroke Dark Portrait https://cdn.cloudflare.steamstatic.com/apps/dota2/images/abilities/grimstroke_dark_portrait_hp1.png
                                Snapfire Gobble Up https://cdn.cloudflare.steamstatic.com/apps/dota2/images/abilities/snapfire_gobble_up_hp1.png

                                <img src="https://gamepedia.cursecdn.com/dota2_gamepedia/4/4e/Gobble_Up_icon.png" alt="Gobble Up" title="Gobble Up" />
                                <img src="https://gamepedia.cursecdn.com/dota2_gamepedia/6/60/Aghanim%27s_Scepter_ability_icon.png" alt="Aghanim's Scepter Synth" title="Aghanim's Scepter Synth" />
                                <img src="https://cdn.cloudflare.steamstatic.com/apps/dota2/images/abilities/elder_titan_ancestral_spirit_hp1.png" alt="Astral Spirit" title="Astral Spirit" />
                                <img src="https://cdn.cloudflare.steamstatic.com/apps/dota2/images/abilities/sandking_burrowstrike_hp1.png" alt="Burrowstrike" title="Burrowstrike" />
                                <img src="https://cdn.cloudflare.steamstatic.com/apps/dota2/images/abilities/shredder_chakram_2_hp2.png" alt="Chakram" title="Chakram" />
                                <img src="https://cdn.cloudflare.steamstatic.com/apps/dota2/images/abilities/warlock_rain_of_chaos_hp2.png" alt="Chaotic Offering" title="Chaotic Offering" />
                                <img src="https://gamepedia.cursecdn.com/dota2_gamepedia/4/4d/Dark_Portrait_icon.png" alt="Dark Portrait" title="Dark Portrait" />
                                <img src="https://gamepedia.cursecdn.com/dota2_gamepedia/7/74/Enchant_Remnant_icon.png" alt="Enchant Remnant" title="Enchant Remnant" />
                                <img src="https://gamepedia.cursecdn.com/dota2_gamepedia/7/7d/Stone_Remnant_icon.png" alt="Stone Remnant" title="Stone Remnant" />
                                <img src="https://cdn.cloudflare.steamstatic.com/apps/dota2/images/abilities/necrolyte_sadist_hp1.png" alt="Ghost Shroud" title="Ghost Shroud" />
                                <img src="https://cdn.cloudflare.steamstatic.com/apps/dota2/images/abilities/mars_gods_rebuke_hp1.png" alt="God's Rebuke" title="God's Rebuke" />
                                <img src="https://cdn.cloudflare.steamstatic.com/apps/dota2/images/abilities/mars_arena_of_blood_hp1.png" alt="Arena of Blood" title="Arena of Blood" />
                                <img src="https://cdn.cloudflare.steamstatic.com/apps/dota2/images/abilities/morphling_replicate_hp1.png" alt="Morph" title="Morph" />
                                <img src="https://gamepedia.cursecdn.com/dota2_gamepedia/5/50/Nimbus_icon.png" alt="Nimbus" title="Nimbus" />
                                <img src="https://gamepedia.cursecdn.com/dota2_gamepedia/3/3f/Overclocking_icon.png" alt="Overclocking" title="Overclocking" />
                                <img src="https://cdn.cloudflare.steamstatic.com/apps/dota2/images/abilities/phantom_lancer_phantom_edge_hp1.png" alt="Phantom Rush" title="Phantom Rush" />
                                <img src="https://gamepedia.cursecdn.com/dota2_gamepedia/8/8d/Minefield_Sign_icon.png" alt="Minefield Sign" title="Minefield Sign" />
                                <img src="https://gamepedia.cursecdn.com/dota2_gamepedia/d/d1/Psionic_Projection_icon.png" alt="Psionic Projection" title="Psionic Projection" />
                                <img src="https://gamepedia.cursecdn.com/dota2_gamepedia/b/b9/Rune_Forge_icon.png" alt="Rune Forge" title="Rune Forge" />
                                <img src="https://gamepedia.cursecdn.com/dota2_gamepedia/e/ee/Shadow_Step_icon.png" alt="Shadow Step" title="Shadow Step" />
                                <img src="https://gamepedia.cursecdn.com/dota2_gamepedia/2/2b/Flak_Cannon_icon.png" alt="Side Gunner" title="Side Gunner" />
                                <img src="https://cdn.cloudflare.steamstatic.com/apps/dota2/images/abilities/clinkz_wind_walk_hp1.png" alt="Skeleton Walk" title="Skeleton Walk" />
                                <img src="https://gamepedia.cursecdn.com/dota2_gamepedia/4/42/Sproink_icon.png" alt="Sproink" title="Sproink" />
                                <img src="https://cdn.cloudflare.steamstatic.com/apps/dota2/images/abilities/mirana_starfall_hp1.png" alt="Starstorm" title="Starstorm" />
                                <img src="https://cdn.cloudflare.steamstatic.com/apps/dota2/images/abilities/sven_storm_bolt_hp1.png" alt="Storm Hammer" title="Storm Hammer" />
                                <img src="https://gamepedia.cursecdn.com/dota2_gamepedia/a/ad/Torrent_Storm_icon.png" alt="Torrent Storm" title="Torrent Storm" />
                                <img src="https://gamepedia.cursecdn.com/dota2_gamepedia/1/10/Tree_Volley_icon.png" alt="Tree Volley" title="Tree Volley" />
                                <img src="https://gamepedia.cursecdn.com/dota2_gamepedia/8/8b/Wolf_Bite_icon.png" alt="Wolf Bite" title="Wolf Bite" />
                                <img src="https://gamepedia.cursecdn.com/dota2_gamepedia/8/83/Sun_Strike_icon.png" alt="Sun Strike" title="Sun Strike" />
                                invoker description
                             */
                            //echo $hero . ' ' . $skill_name . ' ' . $url . '</br>';
                        }
                    }

                    if ( !empty( $replace ) )
                    {
                        $row['effect'] = preg_replace_callback( '/(<b>.*<\/b>)/iUm' , function($matches) use (&$replace) {
                            return array_shift($replace);
                        }, $row['effect']);
                    }
                }
            }

            foreach ( $data as $row )
            {
                \DB\DOTA_2\Heroes_aghanim::if_not_insert_update( array(
                        'hero_id' => $row['id'],
                        'effect' => $row['effect']
                    ),
                    array('effect' => $row['effect'])
                );
            }
        }
        catch ( \Exception $e )
        {
            \DB::rollback();
            throw new \Exception\Fatal( $e->getMessage() );
        }
    }

}