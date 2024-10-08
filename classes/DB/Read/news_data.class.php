<?php

namespace DB\Read;
use DB;

class news_data extends DB\Table
{

    static $table_name = 'read_news_data';
    static $fields = array(
        'news_id' => array(
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
            'length' => 255 , 
            'length_min' => 2,
            'decorators' => 'trim_no_html' 
        ), 
        'preview' => array( 
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
            'length_min' => 2,
            'decorators' => 'trim_no_html' ,
        ),
        'seo_description' => array( 
            'type' => 'varchar' , 
            'length' => 255 ,
            'length_min' => 2,
            'decorators' => 'trim_no_html' ,
        ),
        'seo_keywords' => array( 
            'type' => 'varchar' , 
            'length' => 255 ,
            'length_min' => 2,
            'decorators' => 'trim_no_html' ,
        ),
    );
}