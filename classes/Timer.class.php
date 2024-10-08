<?php
	class Timer
	{
		static $microtime = array();
		
		static function start($key = 'site')
		{
			return self::$microtime[$key] = microtime(true);
		}
		
		static function finish($key = 'site' , $precision = 5)
		{
			return empty(self::$microtime[$key]) ? false : round(microtime(true) - self::$microtime[$key] , $precision) . ' sec';
		}
	}