<?php

class Protector
{
    public const ACTION_REGISTER = 'register';
    public const ACTION_ACTIVATE = 'activate';
    public const ACTION_LOGIN = 'login';
    public const ACTION_FORGOT_PASSWORD = 'forgot_password';
    public const ACTION_REFRESH_RANDOM_HERO_ROLES = 'refresh_random_hero_roles';

    private const ACTIONS = array(
        self::ACTION_REGISTER => 5,
        self::ACTION_LOGIN => 5,
        self::ACTION_FORGOT_PASSWORD => 120,
        self::ACTION_REFRESH_RANDOM_HERO_ROLES => 5
    );

    public static function check( $action )
    {
        $key = __CLASS__ . '_' . $action;
        $current_time = time();


        if ( ( $time = Session::get( $key ) ) && ( ( $time + self::ACTIONS[ $action ] ) > $current_time ) )
        {
            return false;
        }

        Session::set( $key , $current_time );
        return true;
    }
}