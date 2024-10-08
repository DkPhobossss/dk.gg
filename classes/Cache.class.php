<?php

class Cache
{
    
    private static $instance;
    public static $count = 0;
    public static $debug = false;
    
    public static function connect( Abstr\Cache &$Cache )
    {
        self::$instance = $Cache;
        return self::$instance->connect();
    }

    public static function debug( $value = false )
    {
        self::$debug = $value;
    }
    
    public static function clear_language( $key )
    {
        if ( self::$debug )
        {
            Output::$debug['CACHE'][] = "clear_language => $key";
        }
        
        foreach ( array_keys( Localka::$settings ) as $lang )
        {
            self::$count++;
            self::$instance->clear( "$key:lang:$lang");
        }
    }

    public static function __callStatic( $method, $args )
    {
        self::$count++;
        
        if ( self::$debug )
        {
            Output::$debug['CACHE'][] = "$method => " . Input::custom( $args , 0 );
        }
        return call_user_func_array( array( self::$instance, $method ), $args );
    }

}



if ( Cache::connect( new Cache\Memcache() ) === FALSE )
{
    trigger_error( 'Cache connect failed'  , E_USER_ERROR );
    throw new Exception\Fatal( 'Cache connect failed' );
}