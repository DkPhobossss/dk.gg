<?php

namespace DB\Shop;
use DB;

class product extends DB\Table
{
    static $table_name = 'shop_product';

    static $fields = array(
        'cat_id' => array(
            'type' => 'enum' , 
            ) ,
        'url' => array( 
            'type' =>'varchar' ,
            'length_min' => 2, 
            'length' => 32 , 
            'decorators' => 'trim_no_tags' ,
            'regexp' => '^[0-9a-zA-Z\-\_]+$',
            'error' => 'No russian symbols and spaces(use _ )' ,
        ), 
        'image_text' => array(
            'type'  => 'browse',
            'length' => 255,
            'length_min' => 10 , 
            'file_type' => 'Images', 
            'folder' => 'shop/product/preview_text/' , 
            'decorators' => 'trim_nohtml_noquotes',
            'comment' => 'height 40',
            'height'  => '40'
        ),
        'image_preview' => array(
            'type'  => 'browse',
            'length' => 255,
            'length_min' => 10 , 
            'file_type' => 'Images', 
            'folder' => 'shop/product/preview/' , 
            'decorators' => 'trim_nohtml_noquotes',
            'comment' => '965x265',
            'width' => 965,
            'height'=> 265
        ),
        'image_preview_plitka' => array(
            'type'  => 'browse',
            'length' => 255,
            'length_min' => 10 , 
            'file_type' => 'Images', 
            'folder' => 'shop/product/preview/' , 
            'decorators' => 'trim_nohtml_noquotes',
            'comment' => '296x175',
            'width' => 296,
            'height'=> 175,
            'comment' => 'Catalogue image preview 296x175'
        ),
        'image_preview_product' => array(
            'type'  => 'browse',
            'length' => 255,
            'file_type' => 'Images', 
            'folder' => 'shop/product/' , 
            'decorators' => 'trim_nohtml_noquotes',
            'comment' => 'width 965 - это фото в странице продукта. preview',
        ),
        'image_source' => array(
            'type'  => 'browse',
            'length' => 255,
            'file_type' => 'Images', 
            'folder' => 'shop/product/' , 
            'decorators' => 'trim_nohtml_noquotes',
            'comment' => 'Фотография, что открывается в большом размере при клике на preview',
        ),
        'image_cart' => array(
            'type'  => 'browse',
            'length' => 255,
            'file_type' => 'Images', 
            'folder' => 'shop/product/' , 
            'decorators' => 'trim_nohtml_noquotes',
            'comment' => '250x80 - Фотография, что отображается при просмотре своего заказа(в корзине)',
            'width' => 250,
            'height'=> 80
        ),
        'priority' => array( 
            'type' => 'int' ,
            'default' => 10 , 
            'length' => 2,
        ),
        'image_large_1' => array(
            'type'  => 'browse',
            'length' => 255,
            'file_type' => 'Images', 
            'folder' => 'shop/product/' , 
            'decorators' => 'trim_nohtml_noquotes',
            'comment' => '965x450',
        ),
        'image_large_2' => array(
            'type'  => 'browse',
            'length' => 255,
            'file_type' => 'Images', 
            'folder' => 'shop/product/' , 
            'decorators' => 'trim_nohtml_noquotes',
            'comment' => '965x450',
        ),
        'image_large_3' => array(
            'type'  => 'browse',
            'length' => 255,
            'file_type' => 'Images', 
            'folder' => 'shop/product/' , 
            'decorators' => 'trim_nohtml_noquotes',
            'comment' => '965x450',
        ),
        'image_large_4' => array(
            'type'  => 'browse',
            'length' => 255,
            'file_type' => 'Images', 
            'folder' => 'shop/product/' , 
            'decorators' => 'trim_nohtml_noquotes',
            'comment' => '965x450',
        ),
        'image_large_5' => array(
            'type'  => 'browse',
            'length' => 255,
            'file_type' => 'Images', 
            'folder' => 'shop/product/' , 
            'decorators' => 'trim_nohtml_noquotes',
            'comment' => '965x450',
        ),
        'image_large_6' => array(
            'type'  => 'browse',
            'length' => 255,
            'file_type' => 'Images', 
            'folder' => 'shop/product/' , 
            'decorators' => 'trim_nohtml_noquotes',
            'comment' => '965x450',
        ),
        'image_large_7' => array(
            'type'  => 'browse',
            'length' => 255,
            'file_type' => 'Images', 
            'folder' => 'shop/product/' , 
            'decorators' => 'trim_nohtml_noquotes',
            'comment' => '965x450',
        ),
        'image_large_8' => array(
            'type'  => 'browse',
            'length' => 255,
            'file_type' => 'Images', 
            'folder' => 'shop/product/' , 
            'decorators' => 'trim_nohtml_noquotes',
            'comment' => '965x450',
        ),
        'image_large_9' => array(
            'type'  => 'browse',
            'length' => 255,
            'file_type' => 'Images', 
            'folder' => 'shop/product/' , 
            'decorators' => 'trim_nohtml_noquotes',
            'comment' => '965x450',
        ),
        'image_large_10' => array(
            'type'  => 'browse',
            'length' => 255,
            'file_type' => 'Images', 
            'folder' => 'shop/product/' , 
            'decorators' => 'trim_nohtml_noquotes',
            'comment' => '965x450',
        ),
    );
    
    
    public static function get_order( $ids )
    {
        return DB::exec('SELECT
                `shop_product`.`id`, CONCAT( "shop/" ,`shop_cat`.`url` ,  "/", `shop_product`.`url` ) as `url`,
                `shop_product`.`image_cart` as `image`
            FROM `shop_product`
            LEFT JOIN `shop_cat` ON 
                `shop_cat`.`id` = `shop_product`.`cat_id`
            WHERE 
                `shop_product`.`id` IN (' . implode( ',', $ids ) . ')' )->rows('id');
    }
}