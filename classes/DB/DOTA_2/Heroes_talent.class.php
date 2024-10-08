<?php

namespace DB\DOTA_2;
use DB;


class Heroes_talent extends DB\Table
{
    static $table_name = 'dota_2_heroes_talents';
    static $lvls = array(10,15,20,25);

    static $fields = array(
        'hero_id' => array(
            'type' => 'int',
            'disable_update' => true
        ),
        'lvl' => array(
            'type' => 'int',
            'disable_update' => true
        ),
        'left_talent' => array(
            'type' =>'html' ,
            'length_min' => 4,
            'decorators' => 'trim' ,
        ),
        'right_talent' => array(
            'type' =>'html' ,
            'length_min' => 4,
            'decorators' => 'trim' ,
        ),
    );

    public static function get_by_hero_id( $hero_id )
    {
        return self::select( array('lvl' , 'left_talent' , 'right_talent') , array('hero_id' => $hero_id) , array('lvl' , 'DESC') )->rows('lvl');
    }
}