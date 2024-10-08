<?php

class Module
{
    const ROOT = 'modules';

    protected static $root;
    private $path;
    protected $filename;
    private $args;

    public static function root()
    {
        if ( !isset( static::$root ) )
        {
            static::$root = realpath( Config::SITE_ROOT . static::ROOT );
        }

        return static::$root;
    }

    public static function relative( $path )
    {
        static $root_length;
        if ( !isset( $root_length ) )
        {
            $root_length = mb_strlen( realpath( '.' ) . '/' );
        }

        
        return mb_substr( $path, $root_length );         
    }

    public function __construct( $name, $args = array( ), $path = null )
    {
        $this->args = $args;

        if ( empty( $path ) )
        {
            $path = self::root();
        }
        
        if ( mb_substr( $name, 0, 1 ) === '/' )
        {
            $filename = self::root() . $name;
        }
        elseif ( !empty( $name ) )
        {
            $filename = $path . '/' . $name;
        }
        else
        {
            $filename = $path;
        }

        $this->path = realpath( $filename );

        if ( $this->path === false )
        {	
            return $this->error( 'Incorrect module path: ' . $filename );
        }


/*
        if ( !empty( $name ) && mb_strpos( $this->path, self::root() . '/' ) !== 0 )
        {
            return $this->error( 'Incorrect module path: ' . $this->path );
        }
*/
        $this->path = $this->relative( $this->path );
        $this->filename = $this->path . '/' . basename( $this->path );
    }

    protected function error( $message )
    {
        die( $message );
    }

    public function execute()
    {        
        ob_start( );
        if ( is_readable( $this->filename . '.php' ) )
        {	
            include($this->filename . '.php');
        }

        if ( is_readable( $this->filename . '.tpl' ) )
        {
            include($this->filename . '.tpl');
        }

        $buffer = preg_replace('/\s+/', ' ', ob_get_contents() );
        ob_end_clean();

        return $buffer;
    }

    public function execute_ajax()
    {
        ob_start( );
        if ( is_readable( $this->filename . '.php' ) )
        {
            include($this->filename . '.php');
        }

        if ( is_readable( $this->filename . '_ajax.tpl' ) )
        {
            include($this->filename . '_ajax.tpl');
        }

        $buffer = preg_replace('/\s+/', ' ', ob_get_contents() );
        ob_end_clean();

        return $buffer;
    }

    public function module( $name )
    {
        $args = func_get_args();
        array_shift( $args );
        
        if ( self::ROOT == static::ROOT )
        {
            $module = new self( $name, $args, $this->path );
        }
        else
        {
            $module = new self( $name, $args );
        }

        return $module->execute();
    }

    public function module_ajax( $name )
    {
        $args = func_get_args();
        array_shift( $args );

        if ( self::ROOT == static::ROOT )
        {
            $module = new self( $name, $args, $this->path );
        }
        else
        {
            $module = new self( $name, $args );
        }

        return $module->execute_ajax();
    }

    public function shift( $key )
    {
        $this->args[$key]= null;
    }

    public function args()
    {
        foreach ( func_get_args() as $index => $name )
        {
            $this->$name = isset( $this->args[$index] ) ? $this->args[$index] : null;
        }
    }

    public function js( $filename = '' )
    {
        if ( empty( $filename ) )
        {
            Output::js( $this->filename );
        }
        else
        {
            Output::js( $this->path . '/' . $filename );
        }
    }

    public function css( $filename = '' )
    {
        if ( empty( $filename ) )
        {
            Output::css( $this->filename );
        }
        else
        {
            Output::css( $this->path . '/' . $filename );
        }
    }
}

