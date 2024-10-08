<?php

namespace DB\DOTA_2;
use DB;


class Heroes_role_data extends DB\Table
{
    static $table_name = 'dota_2_heroes_role_data';

    static $fields = array(
        'role_id' => array(
            'type' => 'int',
            'disable_update' => true
        ),
        'lang' => array(
            'type' => 'varchar' ,
            'length' => 2 ,
            'disable_update' => true
        ),
        'content' => array(
            'type' =>'html' ,
            'decorators' => 'trim_no_iframe' ,
            'default' => null
        ),
    );

}