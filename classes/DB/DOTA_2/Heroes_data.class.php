<?php

namespace DB\DOTA_2;
use DB;

class Heroes_data extends DB\Table
{
    static $table_name = 'dota_2_heroes_data';

    static $fields = array(
        'hero_id' => array(
            'type' => 'int',
            'disable_update' => true
        ),
        'lang' => array(
            'type' => 'varchar' ,
            'length' => 2 ,
            'disable_update' => true
        ),
        'description' => array(
            'type' =>'html' ,
            'length_min' => 10,
            'decorators' => 'trim' ,
        ),
        'content' => array(
            'type' =>'html' ,
            'decorators' => 'trim' ,
            'default' => null
        ),
        'seo_title' => array(
            'type' => 'varchar' ,
            'length' => 127 ,
            'length_min' => 2,
            'decorators' => 'trim_no_html' ,
        ),
        'seo_description' => array(
            'type' => 'varchar' ,
            'length' => 255 ,
            'length_min' => 2,
            'decorators' => 'trim_no_html' ,
        ),
        'seo_keywords' => array(
            'type' => 'varchar' ,
            'length' => 255 ,
            'length_min' => 2,
            'decorators' => 'trim_no_html' ,
        ),
    );

}