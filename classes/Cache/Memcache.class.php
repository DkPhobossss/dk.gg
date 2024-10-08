<?php
//http://php.net/manual/ru/book.memcache.php
namespace Cache;
use Abstr;

class Memcache extends Abstr\Cache
{
    static private $class;
    static private $compression = 0;//OR 2 = MEMCACHE_COMPRESSED

    public function connect($host = '127.0.0.1' , $port = 11211 , $timeout = null)
    {
        self::$class = new \Memcache();
        
        return isset($timeout) ? self::$class->connect($host , $port , $timeout) : self::$class->connect($host , $port);
    }
    
    
    public function pconnect($host = '127.0.0.1' , $port = 11211 , $timeout = 1)
    {
        self::$class = new \Memcache;
        return self::$class->connect($host , $port , $timeout);
    }
    
    
    public function add($key , $value , $expire = 0)
    {
        return self::$class->add($key, $value , self::$compression, $expire);
    }
    
    
    public function set($key , $value , $expire = 0)
    {
        return self::$class->set($key, $value, self::$compression , $expire);
    }
    
    
    public function get($key)
    {
        return self::$class->get( $key );
    }
    
    
    public function clear($key)
    {
        return self::$class->delete($key , 0);//http://stackoverflow.com/questions/4745345/how-do-i-stop-phpmemcachedelete-from-producing-a-client-error
    }
    
    
    public function replace($key, $value , $expire = 0)
    {
        return self::$class->replace($key, $value, self::$compression, $expire);
    }
   
    
    public function inc($key , $value = 1)
    {
        return self::$class->increment($key , $value);
    }
    
    
    public function dec($key , $value = 1)
    {
        return self::$class->decrement($key , $value);
    }
    
    
    public function flush($check = false)
    {
        return $check ? self::$class->flush() : false;
    }
    
    
    public function stats()
    {
        return self::$class->getStats();
    }
}