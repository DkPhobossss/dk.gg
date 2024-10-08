<?php

namespace DB\DOTA_2;
use DB;


class Heroes_aghanim extends DB\Table
{
    static $table_name = 'dota_2_heroes_aghanim';

    static $fields = array(
        'hero_id' => array(
            'type' => 'int',
            'disable_update' => true
        ),
        'effect' => array(
            'type' =>'html' ,
            'length_min' => 10,
            'decorators' => 'trim' ,
        ),
    );

}