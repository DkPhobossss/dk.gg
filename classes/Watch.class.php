<?php

class Watch
{
    CONST STREAMS = 'streams';
    CONST VIDEOS = 'videos';
    CONST GALLERY = 'gallery';
    CONST MATCHES = 'matches';
    

    /**
     * 
     * @return array() - system array for frontend index page
     */
    public static function sections_index( $key = null, $key2 = null )
    {
        static $data = null;
        
        if ( !isset( $data ) )
        $data = array(
            self::STREAMS      => array(
                'url' => 'http://watch.navi-gaming.com/' . Localka::$lang_url . self::STREAMS ,
                'name' => __('Streams') ,
            ) , 
            self::VIDEOS      => array(
                'url' => 'http://watch.navi-gaming.com/' . Localka::$lang_url  . self::VIDEOS ,
                'name' => __('Videos') ,
            ) , 
            self::GALLERY => array(
                'url' => 'http://watch.navi-gaming.com/' . Localka::$lang_url  . self::GALLERY ,
                'name' => __('Gallery') ,
            ) , 
            self::MATCHES => array(
                'url' => 'http://watch.navi-gaming.com/' . Localka::$lang_url  . self::MATCHES ,
                'name' => __('Matches') ,
            ) , 
        );
        
        return isset( $key ) ? ( isset( $key2 ) ? $data[ $key ][ $key2 ] 
                                                : $data[ $key ] ) 
                            : $data ;
    }
    
    
   
}