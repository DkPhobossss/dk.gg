<?php

class Session implements SessionHandlerInterface
{
    static $connected = false;
    const LIFETIME = 64000;

    public function __construct(  )
    {
        //http://www.php.net/manual/ru/session.configuration.php#ini.session.use-cookies
        @ini_set( 'session.use_cookies', true );
        @ini_set( 'session.use_only_cookies', true );
        @ini_set( 'session.auto_start', false );
        @ini_set( 'session.cookie_domain', '.' . Config::SITE_NAME );

        ini_set('session.gc_maxlifetime', self::LIFETIME); // max
        ini_set('session.gc_probability', 1);
        ini_set('session.gc_divisor', 100);
        //session.cookie_lifetime = 0
    }

    public function start()
    {
        register_shutdown_function('session_write_close');
        if (session_start() === false ) {
            throw new \Exception\Fatal('session_is_broken');
        }

        // Set the randomly generated code. - Вместо token = value , session_var = session_value
        if ( is_null( self::get( 'session_var' ) ) )
        {
            self::set( 'session_value' , md5( session_id() . mt_rand() ));
            self::set( 'session_var',  substr( preg_replace( '~^\d+~', '', sha1( mt_rand() . session_id() . mt_rand() ) ), 0, rand( 7, 12 ) ) );

            // For session check verfication.... don't switch browsers...
            self::set('USER_AGENT' , Input::server('HTTP_USER_AGENT', 'none') );
            self::set('ip' , Auth::ip());
        }
    }


    public function open ( $save_path , $session_id )
    {
        return self::$connected;
    }

    public function close ( )
    {
        return self::$connected;
    }

    public function destroy ( $session_id )
    {
        DB\Session::delete( array( 'session_id' => $session_id ) );
        return true;
    }

    public function gc (  $maxlifetime )
    {
        DB\Session::delete( array( 'last_update' => array( time() - self::LIFETIME , '<' ) ) );
        return true;
    }


    public function read ( $session_id )
    {
        $data = DB\Session::select( array( 'data' ), array( 'session_id' => $session_id ) )->row(); //need select row = неудобно!!!
        return isset( $data['data'] ) ? $data['data'] : '';
    }

    public function write ( $session_id , $data )
    {
        DB\Session::if_not_insert_update( array( 'session_id' => $session_id, 'data' => $data, 'last_update' => time() ), array( 'session_id' => $session_id, 'data' => $data, 'last_update' => time() ) );
        return true;
    }


    public static function check( $type = 'post' )
    {
        if ( self::get('session_value') != call_user_func( array( 'Input', $type ), self::get('session_var') ) )
        {
            throw new Exception\User( __( 'error_session_invalid_token' ) . '. Request : ' . $type . '<br/>' . __('Most probably you are trying to access a direct link OR you need to clear cookies') );
        }

        // Verify that they aren't changing user agents on us - that could be bad.


        if ( (is_null( self::get('USER_AGENT') ) || self::get('USER_AGENT')!= $_SERVER['HTTP_USER_AGENT'] ) )
        {
            self::del();
            Cookie::clear( Cookie::AUTH );
            throw new Exception\User( __( 'error_session_verify_fail' ) );
        }

        // Make sure a page with session check requirement is not being prefetched.
        //http://yapro.ru/web-master/xhtml/ispolizovanie-predvaritelinoy-zagruzki.html
        if ( Input::server( 'HTTP_X_MOZ' ) == 'prefetch' )
        {
            ob_end_clean();
            header( 'HTTP/1.1 403 Forbidden' );
            die;
        }

        return true;
    }


    public static function _get()
    {
        $count = func_num_args();
        $t = $_SESSION;
        
        for ( $i = 0; $i < $count; $i++ )
        {
            $key = func_get_arg( $i );
            if ( !is_array( $t ) || !array_key_exists( $key, $t ) )
            {
                return NULL;
            }
            
            $t = $t[$key];
        }
        return $t;
    }
    
    public static function get( $key )
    {
        return isset( $_SESSION[ $key ] ) ? $_SESSION[ $key ] : null;
    }

    public static function _print()
    {
        echo '<pre style="color:#000;background:#fff;position:relative;z-index:5;">';
        print_r( $_SESSION );
    }

    public static function set( $key, $value )
    {
        $_SESSION[$key] = $value;
    }

    public static function id( $id = null )
    {
        return session_id( $id );
    }

    public static function del( $key = null )
    {
        if ( is_null( $key ) )
        {
            setcookie(session_name(),'',0,'/');
            session_regenerate_id(true);
            session_unset();
            session_destroy();
        }
        else
        {
            unset( $_SESSION[$key]);
        }
    }
}

$Session_handler = new Session();
Session::$connected = session_set_save_handler( $Session_handler , true );
session_register_shutdown();
$Session_handler->start();
