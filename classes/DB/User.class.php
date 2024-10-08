<?php
namespace DB;

class User extends Table
{
    static $table_name = 'users';

    public CONST Forgot_password_hash_time = 3600;

    static $fields = array(
      /*  'login' => array(
            'type' =>'varchar' ,
            'length_min' => 3,
            'length_max' => 16,
            'decorators' => 'trim_no_html' ,
        ),
        'email' => array(
            'type' => 'varchar' ,
            'length' => 64 ,
            'decorators' => 'trim_no_html'
        ),
        'name' => array(
            'type' => 'varchar' ,
            'length_min' => 3,
            'length_max' => 64,
            'decorators' => 'trim_no_html'
        ),
        'password' => array(
            'type' => 'varchar' ,
            'length_min' => 3,
            'length_max' => 32,
            'decorators' => 'trim' ,
        ),*/
    );

    /*
        echo DB\User::hash( 'ZooM', '110577' );
        echo DB\User::hash( 'Zemex', 'x73hdUDx' );
        echo DB\User::hash( 'askpro', 'askpro1177' ); 
        echo DB\User::hash( 'admin', 'admin1177' ); 
        echo DB\User::hash( 'admin2','admin1177' ); 
        echo DB\User::hash( 'admin3','admin1177' ); 
     */

    public static function hash ( $login , $password )
    {
        return md5(  $login . 'xx' . md5( $password ) );
    }

    public static function activated_hash()
    {
        return md5( uniqid());
    }

    public static function register( $login, $password, $email, $register_ip, $name, $activated_hash )
    {
        return self::insert(array(
                                    'login' => $login,
                                    'password' => self::hash( $login, $password),
                                    'email' => $email,
                                    'register_ip' => $register_ip,
                                    'name' => $name,
                                    'activated_hash' => $activated_hash,
                                    'login_hash' => \Auth::login_hash( null , $login)
                                )
        );
    }

    public static function create( $login, $password, $email, $register_ip, $name )
    {
        return self::insert( array(
                    'login' => $login,
                    'password' => self::hash( $login, $password),
                    'email' => $email,
                    'register_ip' => $register_ip,
                    'name' => $name,
                    'activated' => 1,
                    'login_hash' => \Auth::login_hash( null , $login)
                )
        );
    }
}