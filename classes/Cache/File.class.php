<?php
namespace Cache;


class File
{
    protected static $path;
    protected static $expire;
    protected static $file_type;


    protected static function filename( $file_name )
    {
        return static::$path . $file_name . '.' . static::$file_type;
    }

    protected static function save( $key, $data, $lang = false )
    {
        return file_put_contents(
            self::filename( $lang ? ( \Localka::$lang . '/' . $key ) : $key ),
            $data
        );
    }

    protected static function expire( $key )
    {
        $file = self::filename( $key );
        if ( !file_exists( $file ) )
        {
            return true;
        }

        return ( time() > filemtime( $file ) + static::$expire ) ? true : false ;
    }


    /**
     * @param $key
     * @return string
     */
    public static function get( $key )
    {
    }
}