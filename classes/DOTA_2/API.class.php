<?php

namespace DOTA_2;


class API
{
    private const GET_HEROES_URL = 'http://api.steampowered.com/IEconDOTA2_570/GetHeroes/v0001/';
    private const GET_ITEMS_URL = 'http://api.steampowered.com/IEconDOTA2_570/GetGameItems/v1';
    private const STEAM_KEY = 'F66CD66C06806DBB3BF18043AEDC6764';

    private const ABILITIES_URL = 'https://api.opendota.com/api/constants/abilities';
    private const ABILITIES_IDS_URL = 'https://api.opendota.com/api/constants/ability_ids';
    private const ABILITIES_HERO_URL = 'https://api.opendota.com/api/constants/hero_abilities';



    private static $container_id = 'heroPickerInner';
    private static $img_small_class = 'heroHoverSmall';
    private static $img_large_class = 'heroHoverLarge';

    private static $tiny_icon_url = 'http://prodota.ru/lib/editors/tiny_mce/plugins/heroes2/img/';

    private static $container_items_id = 'itemPickerInner';

    private static $heroes = array();
    public static $items = array();


    public static function get_heroes( $lang = 'en_US')
    {
        //http://api.steampowered.com/IEconDOTA2_570/GetHeroes/v0001/?key=F66CD66C06806DBB3BF18043AEDC6764&language=en_us
        $data = \CURL::url_get_contents( self::GET_HEROES_URL. '?key=' . self::STEAM_KEY . '&language=' . $lang );
        if ( empty( $data ) )
        {
            throw new \Exception\User( 'Cant get hero list from steam server' );
        }

        $data = json_decode( $data , true );
        if ( empty( $data['result']['heroes'] ) )
        {
            throw new \Exception\User( 'Heroes are empty' );
        }

        return $data['result']['heroes'];
    }

    //https://wiki.teamfortress.com/wiki/WebAPI/GetGameItems
    public static function get_items( $lang = 'en_US' )
    {
        //GET http://api.steampowered.com/IEconDOTA2_<ID>/GetGameItems/v1
        $data = \CURL::url_get_contents( self::GET_ITEMS_URL. '?key=' . self::STEAM_KEY . '&language=' . $lang );
        if ( empty( $data ) )
        {
            throw new \Exception\User( 'Cant get hero list from steam server' );
        }

        $data = json_decode( $data , true );

        if ( empty( $data['result']['items'] ) )
        {
            throw new \Exception\User( 'Heroes are empty' );
        }

        return $data['result']['items'];
    }


    public static function get_skills()
    {
        $data = \CURL::url_get_contents( self::ABILITIES_IDS_URL );

        if ( empty( $data ) )
        {
            throw new \Exception\User( 'Cant get hero list from server' );
        }
        //Array (id => ability_name)
        $data = json_decode( $data , true );

        $ability_data = \CURL::url_get_contents( self::ABILITIES_URL);
        if ( empty( $ability_data ) )
        {
            throw new \Exception\User( 'Cant get hero list from server' );
        }

        $ability_data = json_decode( $ability_data , true );


        $heroes_abilities = \CURL::url_get_contents( self::ABILITIES_HERO_URL );
        if ( empty( $heroes_abilities ) )
        {
            throw new \Exception\User( 'Cant get hero list from server' );
        }
        $heroes_abilities = json_decode( $heroes_abilities , true );

        $heroes_abilities[ 'npc_dota_hero_invoker' ]['abilities'] = array(
            'invoker_quas',
            'invoker_wex',
            'invoker_exort',
            'invoker_invoke',
            'invoker_cold_snap',
            'invoker_ghost_walk',
            'invoker_tornado',
            'invoker_deafening_blast',
            'invoker_ice_wall',
            'invoker_chaos_meteor',
            'invoker_forge_spirit',
            'invoker_alacrity',
            'invoker_emp',
            'invoker_sun_strike'
        );


        //get active abilities
        $heroes_data = \DB\DOTA_2\Heroes::select( array('system_name', 'id') )->rows('system_name','id');
        foreach ( $heroes_abilities as $hero_system_name => $row )
        {
            foreach ( $row['abilities'] as $ability_name )
            {
                if ( isset( $ability_data[ $ability_name ] ) && mb_strpos( $ability_name, 'empty' ) === FALSE )
                {
                    $ability_data[ $ability_name ]['hero_id'] = $heroes_data[ $hero_system_name ];
                }
            }
        }



        //get ids
        $data = array_flip( $data );
        foreach ( $ability_data as $ability => $row )
        {
            if ( !isset( $data[ $ability ] ) )
            {
                unset( $ability_data[ $ability ] );
            }
            else
            {
                $ability_data[ $ability ]['id'] = $data[ $ability ];
            }
        }

        return $ability_data;
    }



    public static function get_heroes_images( $sort = true )
    {
        if ( !empty( self::$heroes ) )
        {
            return self::$heroes;
        }

        $html = file_get_contents( self::$dota2_url . self::$heroes_url );
        if ( empty( $html ) )
        {
            die('Error gettting content from ' . self::$dota2_url . self::$heroes_url );
        }

        $dom = new domDocument;

        $dom->loadHTML( $html ) || die('error loading html');

        $container = $dom->getElementById( self::$container_id );
        if ( is_null( $container ) )
        {
            die('container not found');
        }

        for ( $i = 0 ; $i < 2 ; $i++ )
        {
            $finder = new DomXPath( $dom );
            $class = $i ? 'small' : 'large';
            $classname = $i ? self::$img_small_class : self::$img_large_class;

            $elements = $finder->query("//*[contains(@class, '$classname')]" , $container);

            if ( is_null( $elements ) )
            {
                die('Nodes null');
            }

            foreach ( $elements as $element )
            {
                $src = $element->getAttribute('src');
                self::$heroes[substr( $src , ( $offset = ( strrpos( $src , '/' ) + 1 ) ) , strrpos( $src ,  '_' , $offset ) - $offset ) ][ $class ] = $src;
            }
        }

        foreach ( self::$heroes as $key => &$row )
        {
            $row['tiny'] = self::$tiny_icon_url . "$key.png";
        }

        if ( $sort )
        {
            ksort( self::$heroes );
        }
    }



    public static function create_hero_images()
    {
        if ( empty( self::$heroes ) )
        {
            self::get_heroes();
        }

        foreach ( self::$heroes as $hero => $images )
        {
            foreach ( $images as $size => $src )
            {
                $file_name = self::$path . $size . "/$hero.png";
                if ( !file_exists( $file_name ) )
                {
                    $remote_file = file_get_contents( $src );
                    if ( $remote_file === FALSE )
                    {
                        echo 'FAILED ' . $src . '</br>';
                    }
                    else
                    {
                        if ( !file_put_contents( $file_name , $remote_file ))
                        {
                            die('error putting content ' . $file_name);
                        }
                    }
                }
            }
        }
    }

}