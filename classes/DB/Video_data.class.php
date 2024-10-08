<?php

namespace DB;
use DB;

class Video_data extends DB\Table
{

    static $table_name = 'video_data';
    static $fields = array(
        'video_id' => array(
            'type' => 'int',
            'disable_update' => true
        ),
        'lang' => array(
            'type' => 'varchar' ,
            'length' => 2 ,
            'disable_update' => true
        ),
        'title' => array(
            'type' => 'varchar' ,
            'length' => 127 ,
            'length_min' => 2,
            'decorators' => 'trim_no_html'
        ),
        'description' => array(
            'type' =>'html' ,
            'length_min' => 10,
            'decorators' => 'trim' ,
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