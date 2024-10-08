<?php
class Cookie 
{
    CONST AUTH = 'log';
    private static $encoding_func = array('json_encode' , 'serialize');
    private static $decoding_func = array('json_decode' , 'unserialize');

	public static function set($name, $value, $expire = 0 , $method = 'json_encode' ,  $path = '/' , $domain=null , $secure = false , $httponly = false)
    {	//$domain = Input::server( 'HTTP_HOST' );
        return setcookie($name,
                        ( $_COOKIE[$name] = ( in_array($method, self::$encoding_func , true)  ? @call_user_func($method , $value) : $value ) ),
                        ( empty($expire) ?  0 : strtotime("+$expire seconds") ) , 
                        $path,
                        $domain,
                        $secure,
                        $httponly);
	}
    
    public static function get($name, $method = 'json_decode') 
    {
        return isset($_COOKIE[$name])   ? ( in_array($method, self::$decoding_func , true)  ? ( $method == 'json_decode' ? @call_user_func($method , $_COOKIE[$name] , true )
                                                                                                                        : @call_user_func($method , $_COOKIE[$name]) )
                                                                                            : $_COOKIE[$name] ) 
                                        : false;
	}

    public static function _get($name, $method = 'json_decode')
    {
        return isset($_COOKIE[$name]) ? $_COOKIE[$name] : null;
    }

	public static function clear($name, $domain = null)
    {
        unset($_COOKIE[$name]);
		return setcookie($name, time() - 3600, null, '/' , $domain );
	}	
}