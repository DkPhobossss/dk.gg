<?php

namespace DB;
use DB;

class Text_blocks extends Table
{
    static $table_name = 'text_blocks';

    public const PAGE_DIGITIZE = 'digitize';

    static $fields = array(
        'page' => array(
            'type' =>'varchar' ,
            'length_min' => 2,
            'length' => 32 ,
            'decorators' => 'trim_no_tags' ,
            'regexp' => '^[0-9a-zA-Z\-\_]+$',
            'error' => 'No russian symbols and spaces(use _ )' ,
        ),
        'block_id' => array(
            'type' => 'int' ,
            'default' => 0 ,
            'length' => 2
        ),
    );

    public static function get_by_page( $page )
    {
        return DB::exec('SELECT
            `text_blocks`.`block_id` as `block_id`, 
            `text_blocks_data`.`text` as `text`
            FROM `text_blocks`
            LEFT JOIN `text_blocks_data` ON
                `text_blocks_data`.`text_block_id` = `text_blocks`.`block_id` AND
                `text_blocks_data`.`lang` = %s
            WHERE `text_blocks`.`page` = %s' , \Localka::$lang, $page )->rows('block_id' , 'text');
    }
}