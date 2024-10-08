<?php

namespace DB\Shop;
use DB;

class product_data extends DB\Table
{

    static $table_name = 'shop_product_data';
    static $fields = array(
        'product_id' => array(
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
            'length' => 64 ,
            'length_min' => 2,
            'decorators' => 'trim_no_html'
        ), 
        'content' => array( 
            'type' =>'html' ,
            'length_min' => 10, 
            'decorators' => 'trim' ,
        ),   
        'seo_title' => array( 
            'type' => 'varchar' , 
            'length' => 127 ,
            'default' => '' , 
            'decorators' => 'trim_no_html' ,
        ),
        'seo_description' => array( 
            'type' => 'varchar' , 
            'length' => 255 ,
            'default' => '' , 
            'decorators' => 'trim_no_html' ,
        ),
        'seo_keywords' => array( 
            'type' => 'varchar' , 
            'length' => 255 ,
            'default' => '' , 
            'decorators' => 'trim_no_html' ,
        )
    );
}