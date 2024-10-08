<?php
namespace Abstr;

abstract class Cache
{
    abstract public function connect($host , $port , $timeout); 
    abstract public function pconnect($host , $port , $timeout); 
    
    abstract public function add($host , $port , $expire = 0); //stores variable var with key only if such key doesn't exist at the server yet
    abstract public function set($key , $value , $expire); 
    abstract public function get($key); 
    abstract public function clear($key); 
    abstract public function replace($key , $value , $expire);//should be used to replace value of existing item with key. In case if item with such key doesn't exists, returns FALSE
   
    abstract public function inc($key , $value);//returns new value
    abstract public function dec($key , $value); //returns new value
    abstract public function flush($check = false); 
    
    abstract public function stats(); 
}