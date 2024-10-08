<?php

class Config 
{
    const SITE_NAME                 = 'dkphobos.gg';
    const SITE_ROOT                 = 'D://work/www/dkphobos/';
    const Public_HTML_PATH          = 'D://work/www/dkphobos/public_html/';
    
    static $SITE_URL                = 'http://' . self::SITE_NAME;
    static $static_url              = 'http://s.' . self::SITE_NAME . '/';
    static $uploadsbase             = '';
    static $ckfinderbase            = '';


    const DEBUG                     = true;
    
    static $root_url                = 'http://dkphobos.gg';

    static public $DB               = array('host' => 'localhost', 
                                            'user' => 'root',
                                            'password' => 'vertrigo',
                                            'db' => 'dkphobos',
                                            'encoding' => 'utf8', 
                                            'prefix' => '');
    
    const encoding                  = 'UTF-8';
    const default_time_zone         = 'Europe/Kiev';
    const error_reporting           = 2147483647;//ALL ERRORS
    
    
    const adminKA                   = 'hidden_leaf';


    /**
    * Set's error handler
    *
    * @param string(enum) $mode = [file,browser,default]
    * @return true
    */
    static function set_error_handler($mode = '')
    {
        switch ($mode)
        {
            case 'file':
            {
                ini_set('display_errors' , 'on');
                error_reporting( self::error_reporting );

                set_error_handler(function ($errno, $errstr, $errfile, $errline) 
                {
                    $date = date("Y-m-d H:i:s");

                    $s = "Site: " . Config::$root_url . "\n";
                    $s .= "Time: " . $date . "\n";
                    $s .= "Error #: " . $errno . "\n";
                    $s .= "Message: " . $errstr . "\n";
                    $s .= "File: " . $errfile . "\n";
                    $s .= "Line: " . $errline . "\n";
                    $s .= "User IP: " . Auth::ip() . "\n";
                    $s .= "User ID: " . Auth::id() . "\n";
                    $s .= "\nDebug backtrace:\n";
                    $backtrace_array = debug_backtrace();
                    $backtrace = "";
                    foreach ($backtrace_array as $key => $record) 
                    {
                        if ($key == 0) 
                        {
                            continue;
                        }
                        $backtrace .= "#" . $key . ": " . $record['function'] . "(";
                        
                        if (isset($record['args']) && is_array($record['args'])) 
                        {
                            $args = array();
                            foreach ($record['args'] as &$arg) 
                            {
                                if (is_object( $arg ) && !method_exists( $arg, '__toString' )) 
                                {
                                        $args[] = 'Object';
                                }
                                elseif (is_array( $arg )) 
                                {
                                        $args[] = 'Array';
                                }
                                else 
                                {
                                        $args[] = $arg;
                                }
                            }
                            unset($arg);
                            $backtrace .= implode(",", $args);
                        }
                        $backtrace .= ") called at [" . Input::custom($record, 'file') . ":" . Input::custom($record, 'line') . "]\n";
                    }

                    $s .= $backtrace;
                    
                    $filename = Config::SITE_ROOT . 'errors/' . date('Y-m-d');




                    $log = @fopen( $filename , 'a');
                    if ( !is_writable ( $filename ) )
                    {
                        $log = @fopen( $filename .'?1' , 'a');
                    }

                    fwrite($log, $date . ' ' . Page::full_url(). ' ' . Input::server('REQUEST_URI' , 'unknown_uri') . ":\n" . $s ."\n\n");
                    fclose($log);
                    return false;
                }, self::error_reporting);
                break;	
            }

            case 'browser':
            {
                ini_set('display_errors' , 'on');
                error_reporting(self::error_reporting);
                break;
            }

            default:
            {
                ini_set('display_errors' , 'off');
                error_reporting(0);	
            }
        }
        return true;
    }
}

Config::$uploadsbase             = Config::$static_url . 'uploads/';
Config::$ckfinderbase            = Config::$uploadsbase  .'userfiles/';

