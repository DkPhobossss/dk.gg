<?php

namespace DB;

class Pages_static extends Table
{
    static $table_name = 'pages_static';
    static $cache_fields = 'name:lang';
    static $fields = array(
        'content' => array( 
            'type' =>'html' ,
            'length_min' => 10, 
            'decorators' => 'trim' ,
        ), 
        'title' => array( 
            'type' => 'varchar' , 
            'length' => 64 ,
            'decorators' => 'trim_no_html'
        ), 
        'lang' => array( 
            'type' => 'varchar' ,
            'length' => 2 ,
            'default' => \Localka::RU
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
        ),
        'date_up' => array( 
            'type' => 'timestamp' ,
            'default' => 'CURRENT_TIMESTAMP'
        ),
    );
}