<?php

namespace DB;
use DB;

class Video extends DB\Table
{
    static $table_name = 'video';

    static $fields = array(
        'url' => array(
            'type' =>'varchar' ,
            'length_min' => 2,
            'length' => 64 ,
            'decorators' => 'trim_no_tags' ,
            'regexp' => '^[0-9a-zA-Z\-\_]+$',
            'error' => 'No russian symbols and spaces(use _ )' ,
        ),
        'time' => array(
            'type' => 'varchar' ,
            'length' => 15 ,
            'decorators' => 'trim_no_html'
        ),
        'image' => array(
            'type'  => 'browse',
            'length' => 255,
            'length_min' => 10 ,
            'file_type' => 'Images',
            'folder' => 'video/' ,
            'decorators' => 'trim_nohtml_noquotes',
            'comment' => '296x167',
            'width'     => 296,
            'height'    => 167
        ),
        'image_preview' => array(
            'type'  => 'browse',
            'length' => 255,
            'length_min' => 10 ,
            'file_type' => 'Images',
            'folder' => 'video/preview/' ,
            'decorators' => 'trim_nohtml_noquotes',
            'comment' => '181x80',
            'width' => 181,
            'height'=> 80
        ),
    );


}