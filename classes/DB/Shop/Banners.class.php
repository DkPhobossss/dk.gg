<?php

namespace DB\Shop;
use DB;

class Banners extends DB\Table
{
    static $table_name = 'shop_banners';
    static $fields = array(
        'lang' => array( 
            'type' =>'enum' ,
            'length' => array('ru' => 'ru' , 'en' => 'en'),
        ), 
        'name' => array(
            'type' => 'varchar' , 
            'length_min' => 2,
            'length' => 64,
            'decorators' => 'trim_no_html' ,
        ),
        'image' => array(
            'type'  => 'browse',
            'length' => 255,
            'length_min' => 10 , 
            'file_type' => 'Images', 
            'folder' => 'bg' , 
            'decorators' => 'trim_nohtml_noquotes',
            'comment' => '1540x654',
        ),
        'url' => array(
            'type' => 'varchar' , 
            'length_min' => 2,
            'length' => 255,
            'decorators' => 'trim_no_html' ,
        ),
        'priority' => array( 
            'type' => 'int' ,
            'default' => 10 , 
            'length' => 2
        ),
    );
}