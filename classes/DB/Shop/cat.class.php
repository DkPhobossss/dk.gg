<?php

namespace DB\Shop;
use DB;

class cat extends DB\Table
{
    static $table_name = 'shop_cat';
    static $fields = array(
        'url' => array( 
            'type' =>'varchar' ,
            'length_min' => 2, 
            'length' => 32 , 
            'decorators' => 'trim_no_tags' ,
            'regexp' => '^[0-9a-zA-Z\-\_]+$',
            'error' => 'No russian symbols and spaces(use _ )' ,
        ), 
        'priority' => array( 
            'type' => 'int' ,
            'default' => 0 , 
            'length' => 2
        ),
        'image' => array(
            'type'  => 'browse',
            'length' => 255,
            'length_min' => 10 , 
            'file_type' => 'Images', 
            'folder' => 'shop/cat/' , 
            'decorators' => 'trim_nohtml_noquotes',
            'comment' => '192x79',
            'width'  => 192,
            'height' => 79,
        ),
        'image_catalogue' => array(
            'type'  => 'browse',
            'length' => 255,
            'length_min' => 10 , 
            'file_type' => 'Images', 
            'folder' => 'shop/cat/' , 
            'decorators' => 'trim_nohtml_noquotes',
            'comment' => '296x175',
            'width'  => 296,
            'height' => 175,
        )
    );
    
    public static function get()
    {
        static $data;
        if ( isset( $data ) )
        {
            return $data; 
        }
        
        return $data = DB::exec('SELECT
                `shop_cat`.`url`, `shop_cat`.`id`, `shop_cat`.`image`, `shop_cat`.`image_catalogue`,
                `shop_cat_data`.`name`
                FROM `shop_cat`
                LEFT JOIN `shop_cat_data` ON
                    `shop_cat_data`.`cat_id` = `shop_cat`.`id` AND
                    `shop_cat_data`.`lang` = %s
                ORDER BY `shop_cat`.`priority` DESC' , \Localka::$lang )->rows( 'url' );
    }
    
    
    public static function url( $url )
    {
        return DB::exec('SELECT
            `shop_cat`.`id`,
            `shop_cat_data`.`name`, 
            `shop_cat_data`.`seo_title` , `shop_cat_data`.`seo_description` , `shop_cat_data`.`seo_keywords`
            FROM `shop_cat`
            LEFT JOIN `shop_cat_data` ON
                `shop_cat_data`.`cat_id` = `shop_cat`.`id` AND
                `shop_cat_data`.`lang` = %s
            WHERE `shop_cat`.`url` = %s' , \Localka::$lang, $url )->row();
    }
}