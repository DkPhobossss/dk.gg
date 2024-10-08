<?php
class Input
{
    static function custom(&$array, $key, $default = null)
    {
        return isset($array[$key]) ? $array[$key] : $default;
    }

    static function server($key, $default = null)
    {
        return isset($_SERVER[$key]) ? $_SERVER[$key] : $default;
    }

    static function post($key, $default = false) 
    {
        return isset($_POST[$key]) ? $_POST[$key] : $default;
    }

    static function get($key, $default = false) 
    {
        return isset($_GET[$key]) ? $_GET[$key] : $default;
    }
    
    static function request($key, $default = false) 
    {
        return isset($_REQUEST[$key]) ? $_REQUEST[$key] : $default;
    }
    
    static function page( $page = false , $url_301 = null )
    {
        if ( $page === false )
        {
            return 1;
        }
        
        $page = intval( $page );
        if ( $page == 1 && isset( $url_301 ) )
        {
            Page::_301( $url_301 );
        }
        
        elseif ( $page < 1 )
        {
            _Error::render( _Error::NOT_FOUND );
        }
        
        return $page;
    }
}
