<?php
namespace Cache\File;
use \Config;

class JS extends \Cache\File
{

    const short_path = 'js/cache/';
    protected static $path = Config::Public_HTML_PATH . self::short_path;
    protected static $expire = 1800;
    protected static $file_type = 'js';

    const KEY_ROLE = 'roles';
    const KEY_MACROTASK = 'macrotask';


    protected static function save( $key, $data, $lang = false )
    {
        return file_put_contents(
            self::filename( $lang ? ( \Localka::$lang . '/' . $key ) : $key ),
            "CACHE['" . $key ."'] = " . json_encode( $data, JSON_UNESCAPED_UNICODE )
        );
    }

    public static function get( $key )
    {
        switch ( $key )
        {
            case self::KEY_ROLE :
            {
                $result = self::short_path . $key;
                break;
            }

            case self::KEY_MACROTASK :
            {
                $result = self::short_path . \Localka::$lang . '/' . $key;

                break;
            }
        }

        if ( !self::expire( $key ) )
        {
            return $result;
        }

        switch ( $key )
        {
            case self::KEY_ROLE :
            {
                $data = \DB\DOTA_2\Heroes_role::select(array('id', 'role', 'hero_id', 'disabled', 'type'))->rows('hero_id', true, 'role', true );

                self::save( $key, $data );

                break;
            }

            case self::KEY_MACROTASK :
            {
                $data = \DB\DOTA_2\Heroes_macrotask::DATA( true );

                self::save( $key, $data, true );

                break;
            }
        }

        return $result;
    }
}