<?php

class Auth
{

    private static $id = 0;
    private static $user;
    private static $access;
    
    private static  $ip;
    private static $ip_numeric;

    public CONST FULL_ACCESS = 127;
    public CONST EDITOR = 63;
    public CONST WIKI = 31;


    /**
     * Renders 403 page if user don't have any of pathed rule
     */
    public static function check_access( $value = self::FULL_ACCESS )
    {
        $admin = Session::_get( 'user' , 'access' );

        if ( empty( $value ) )
        {
            $value = self::FULL_ACCESS;
        }
        
        if ( !$admin ||  $admin < $value  )
        {
            _Error::render( _Error::FORBIDDEN );
        }
        return true;
    }

    public static function rule( $value = self::FULL_ACCESS )
    {
        $admin = Session::_get( 'user' , 'access' );

        if ( empty( $admin ) || $admin < $value  )
        {
            return false;
        }
        
        return $admin;
    }

    public static function user( $field = null , $value = null )
    {
        if ( !isset( self::$user ) )
        {
            self::get();
        }
        
        if ( isset( $value ) )
        {
            self::$user[ $field ] = $value;
            return $value;
        }

        return isset( $field ) ? self::$user[$field] : self::$user;
    }

    public static function id()
    {
        if ( !isset( self::$user ) )
        {
            self::get();
        }
        return self::$id;
    }

    private static function get()
    {
        if ( !Session::get('user') )
        {
            //mb auth?
            $auth = Cookie::get( Cookie::AUTH );
            if ( !empty( $auth ) )
            {
                $data = DB\User::select( array( 'id' , 'login' , 'access') , array( 'login_hash' => self::login_hash( $auth ) )  )->row();
                
                if ( empty( $data ) )
                {
                    Cookie::clear( Cookie::AUTH );
                    return false;
                }
                
                return Session::set('user' , $data );
            }
            
            return false;
        }

        self::$user = Session::get('user');
        self::$id = Session::_get('user' , 'id');

        if ( !empty( self::$id ) )
        {
            DB\User::update( array( 'last_ip' => self::ip() , 'last_update' => date('Y-m-d H:i:s') )  , array( 'id' => self::$id ) );
        }

        return true;
    }

    // Log the user out.
    public static function logout( $type = 'get' )
    {
        if ( isset( $type ) )
            Session::check( $type );
        
        if ( !self::$id )
        {
            return false;
        }
        
        Session::del( 'user' );
        Cookie::clear( Cookie::AUTH );
        
        self::$id = 0;
        self::$user = null;
        
        
        return true;
    }

    public static function login( $login , $password )
    {
        if ( self::$id )
        {
            return null;
        }
        
        $data = DB\User::select( array( 'id' , 'login', 'password' , 'email' , 'access' , 'activated' ) , array( 'login' => $login )  )->row();
        
        if ( empty( $data ) )
        {
            return false;
        }
        
        if ( empty( $password ) ||  $data['password'] !== DB\User::hash( $login , $password )   )
        {
            return false;
        }

        if ( !$data['activated'] )
        {
            return null;
        }
        
        unset( $data['password'] );
        unset( $data['activated'] );
        unset( $data['email'] );
        
        $hash = self::login_hash_from_login( $login );

        Cookie::set( Cookie::AUTH , $hash,  2592000 );
        DB\User::update( array('login_hash' => self::login_hash( $hash ) ) , array('id' => $data['id'] ) );
        
        Session::set('user' , $data );
        return true;
    }

    public static function login_hash_from_login( $login )
    {
        return md5( $login . Output::href_session()  );
    }

    public static function login_hash( $hash = null, $login = null )
    {
        if ( is_null( $hash ) && !is_null( $login ) )
            $hash = self::login_hash_from_login( $login );

        return  md5( $hash . Auth::ip() );
    }

    public static function ip( $string = true , $secure = false )
    {
        if ( !isset( self::$ip ) )
        {
            # Получаем IP
            if ( !$secure )
            {
                if ( self::$ip_numeric = self::ip_numeric( Input::server( 'HTTP_CLIENT_IP' ) ) )
                {
                    self::$ip = Input::server( 'HTTP_CLIENT_IP' );
                }
                elseif ( self::$ip_numeric = self::ip_numeric( Input::server( 'HTTP_X_FORWARDED_FOR' ) ) )
                {
                    self::$ip = Input::server( 'HTTP_X_FORWARDED_FOR' );
                }
                else
                {
                    self::$ip_numeric = self::ip_numeric( Input::server( 'REMOTE_ADDR' ) );
                    self::$ip = Input::server( 'REMOTE_ADDR' );
                }
                
            }
            else
            {
                self::$ip_numeric = self::ip_numeric( Input::server( 'REMOTE_ADDR' ) );
                self::$ip = Input::server( 'REMOTE_ADDR' );
            }
        }

        if ( $string )
        {
            return self::$ip;
        }
        else
        {
            return self::$ip_numeric;
        }
    }

    static private function ip_numeric( $ip )
    {
        if ( empty( $ip ) )
        {
            return false;
        }

        $ip_numeric = intval( sprintf( "%u", ip2long( $ip ) ) );
        if ( ($ip_numeric < 167772160) || ($ip_numeric > 184549375 && $ip_numeric < 2130706432) || ($ip_numeric > 2130706687 && $ip_numeric < 2886729728) || ($ip_numeric > 2887778303 && $ip_numeric < 3232235520) || ($ip_numeric > 3232301055) )
        {
            return $ip_numeric;
        }
        else
        {
            return false;
        }
    }
}