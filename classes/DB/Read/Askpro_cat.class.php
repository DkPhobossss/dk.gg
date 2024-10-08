<?php

namespace DB\Read;
use DB;

class Askpro_cat extends DB\Table
{
    static $table_name = 'askpro_cat';
    static $fields = array(
        'email' => array( 
            'type' => 'varchar' , 
            'decorators' => 'trim_no_html' ,
        ),
        'priority' => array( 
            'type' => 'int' ,
            'default' => 10 , 
            'length' => 2
        ),
        'photo' => array(
            'type'  => 'browse',
            'length' => 255,
            'length_min' => 10 , 
            'file_type' => 'Images', 
            'folder' => 'askpro/cat/' , 
            'decorators' => 'trim_nohtml_noquotes',
            'comment' => '220x240',
            'width'  => 220,
            'height' => 240,
        ),
        'disabled' => array(
            'type'  => 'bool',
            'default' => 0,
        ),
    );
}

Askpro_cat::$fields['email']['check'] = function( $value ) {
    return filter_var( $value, FILTER_VALIDATE_EMAIL );
};