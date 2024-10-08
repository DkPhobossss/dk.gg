<?php
//http://github.com/nicolasff/phpredis
namespace Cache;
use Abstr\Cache;

class Redis extends Abstr\Cache
{
	static private $class;

    public function connect($host = '127.0.0.1' , $port ='6379' , $timeout = 0)
    {
    	self::$class = new Redis;
    	return self::$class->connect($host , $port , $timeout);
    }
    
    
    public function pconnect($host = '127.0.0.1' , $port ='6379' , $timeout = 0)
    {
    	self::$class = new Redis;
    	return self::$class->pconnect($host , $port , $timeout);
    }

    
    public function add($key, $data)
    {
        return self::$class->setnx($key , $data);
    }
    
    
    public function set($key, $data, $time = 0)
    {
    	if (empty($time))
    	{
    		return self::$class->set($key , $data);
    	}
    	else
    	{
    		return self::$class->setex($key , $time , $data);
    	}
    }
    
    
    public function get($key)
    {
    	return self::$class->get($key);
    }

    
    public function clear($key)
    {
    	return self::$class->del($key);
    }

    
    public function replace($key , $value , $expire)
    {
    	return false;
    }
    
    
    public function inc($key , $value)
    {
        self::$class->incrBy($key, $value);
    }
    
    
    public function dec($key , $value)
    {
        self::$class->decrBy($key, $value);
    }
    
    
    public function flush($check = false)
    {
        return $check ? self::$class->flushAll() : false;
    }
    
    
    public function stats()
    {
        return self::$class->info();
    }
    

    public function exists($key)
    {
    	return self::$class->exists($key);
    }

    
    public function destroy_by_prefix($prefix)
    {
    	return $this->destroy(self::$class->keys($prefix . "*"));
    }
}