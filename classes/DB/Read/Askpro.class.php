<?php

namespace DB\Read;
use DB;

class Askpro extends DB\Table
{
    static $table_name = 'askpro';
    static $fields = array(
        'lang' => array( 
            'type' => 'varchar' ,
            'length' => 2 ,
            'disable_update' => true
        ),
        'ip' => array( 
            'type' => 'varchar' ,
            'length' => 16 ,
            'disable_update' => true
        ),
        'cat_id' => array(
            'type' => 'enum' ,
            'null'  => true,
            'default' => null,
        ),
        'name' => array( 
            'type' => 'varchar' , 
            'length' => 64 ,
            'length_min' => 2,
            'decorators' => 'trim_no_html'
        ), 
        'email' => array( 
            'type' => 'varchar' , 
            'decorators' => 'trim_no_html' ,
        ),
        'question' => array( 
            'type' => 'text' , 
            'decorators' => 'trim_nl2br' ,
            'length_min' => 10,
            'length' => 65536,
        ),
    );
    
    public static function init_check()
    {
        self::$fields['email']['check'] = function( $value ) {
            return filter_var( $value, FILTER_VALIDATE_EMAIL );
        };

        foreach( array('email' , 'name' , 'question', 'cat_id' ) as $value )
        {
            self::$fields[ $value ]['error'] = ('Неправильно заполнено' );
        }
        
        self::$fields['name']['comment'] = ('Имя');
        self::$fields['question']['comment'] = ('Вопрос');
        self::$fields['cat_id']['comment'] = ('Кому');
    }
}