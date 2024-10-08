<?php

namespace DB\Read;
use DB;

class Askpro_cat_data extends DB\Table
{

    static $table_name = 'askpro_cat_data';
    static $fields = array(
        'cat_id' => array(
            'type' => 'int',
            'disable_update' => true
        ),
        'lang' => array( 
            'type' => 'varchar' ,
            'length' => 2 ,
            'disable_update' => true
        ),
        'name' => array( 
            'type' => 'varchar' , 
            'length' => 255 ,
            'length_min' => 6,
            'decorators' => 'trim_no_html'
        ), 
        'info' => array( 
            'type' =>'html' ,
            'decorators' => 'trim' ,
        ), 
    );
}