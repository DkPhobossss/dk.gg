<?php

namespace DB\Learn;
use DB;

class Glossary_data extends DB\Table
{

    static $table_name = 'learn_glossary_data';
    static $fields = array(
        'glossary_id' => array(
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
            'decorators' => 'trim_no_iframe' ,
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