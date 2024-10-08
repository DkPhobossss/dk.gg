<?php

class Page
{ 
    public static function go_back()
    {
        header('Location: ' . self::back_referer() );
        die();
    }
    
    public static function back_referer()
    {
        if ( !isset($_SERVER['HTTP_REFERER']) || ( $_SERVER['HTTP_REFERER'] == self::full_url() && empty( $_REQUEST )  )   )
        {
            return Config::$root_url;
        }
        else
        {
            return $_SERVER['HTTP_REFERER'];
        }
    }
    
    public static function go( $url = null, $lang = true )
    {
        header('Location: ' . Config::$SITE_URL . ( $lang ? Localka::$lang_url . $url : $url ) );
        die();
    }
    
    public static function back_base64_url()
    {
        return base64_encode( self::full_url() );
    }
    
    public static function full_url()
    {
        return 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    }
    
    public static function admin( $url )
    {
        return Config::$root_url . '/' . Config::adminKA . '/' . $url;
    }
    
    public static function _301( $url, $lang = true )
    {
        header ('HTTP/1.1 301 Moved Permanently');
        header('Location: ' . Config::$SITE_URL . ( $lang ? Localka::$lang_url . $url : $url ) );
        die();
    }
   
}