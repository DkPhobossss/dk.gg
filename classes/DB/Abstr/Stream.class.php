<?php
namespace DB\Abstr;
//use DB, Cache;

abstract class Stream
{
    protected $source;
    
    /**
     * @param array $ids - list of channel id's
     * @return array - return data
     */
    abstract public function get_from_server( $ids );
    
    /**
     * @param int $id - channel_id
     * @return string - return HTML
     */
    abstract public function html( $id );
    
    /**
     * @param int $id - channel_id
     * @return bool - check if u are owner of remote channel
     */
    abstract public function check( $id );
    
    
    /**
     * @param int $id - channel_id
     * @param string $width - width value
     * @param string $height - height value
     * @param class $class - html class string
     * @return string - return HTML
     */
    abstract public function chat( $id , $width = '100%', $height = '100%' , $class = null );
}