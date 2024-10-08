<?php

namespace DB\Shop;
use DB;

class product_link extends DB\Table
{

    static $table_name = 'shop_product_link';
    static $fields = array(
        'lang' => array(
            'type'  => 'enum',
            'length' => array('RU' => 'ru' , 'EN' => 'en')
        ),
        'product_id' => array(
            'type' => 'enum',
        ),
         'url' => array( 
            'type' =>'varchar' ,
            'length_min' => 2, 
            'length' => 255 , 
            'decorators' => 'trim_no_tags' ,
        ), 
        'image' => array(
            'type'  => 'browse',
            'length' => 255,
            'length_min' => 10 , 
            'file_type' => 'Images', 
            'folder' => 'shop/product/links/' , 
            'decorators' => 'trim_nohtml_noquotes',
            'comment' => '436x150',
            'width'  => '436',
            'height'  => '150'
        ),
    );
}