<?php

namespace DB;

class Text_blocks_data extends Table
{
    static $table_name = 'text_blocks_data';


    static $fields = array(
        'text_block_id' => array(
            'type' => 'int' ,
            'disable_update' => true
        ) ,
        'lang' => array(
            'type' => 'varchar' ,
            'length' => 2 ,
            'disable_update' => true
        ),
        'text' => array(
            'type' =>'html' ,
            'length_min' => 10,
            'decorators' => 'trim' ,
        ),
    );
}