<?php

namespace DB\Shop;
use DB;

class Order extends DB\Table
{
    static $table_name = 'order';
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
        'price' => array(
            'type' => 'int' ,
            'disable_update' => true,
            'null' => true,
            'default' => null
        ),
        'name' => array( 
            'type' => 'varchar' , 
            'length' => 127 ,
            'length_min' => 2,
            'decorators' => 'trim_no_html'
        ), 
        'city' => array( 
            'type' => 'varchar' , 
            'length' => 64 ,
            'length_min' => 2,
            'decorators' => 'trim_no_html' ,
        ),
        'adress' => array( 
            'type' => 'varchar' , 
            'length' => 255 ,
            'length_min' => 8,
            
        ),
        'telephone' => array( 
            'type' => 'varchar' , 
            'length' => 32 ,
            'length_min' => 7,
            'decorators' => 'trim_no_html' ,
        ),
        'email' => array( 
            'type' => 'varchar' , 
            'decorators' => 'trim_no_html' ,
        ),
        'info' => array( 
            'type' => 'text' , 
            'decorators' => 'trim_nl2br' ,
            'default'   => ''
        ),
    );
    
    public static function init_check()
    {
        self::$fields['email']['check'] = function( $value ) {
            return filter_var( $value, FILTER_VALIDATE_EMAIL );
        };

        foreach( array('email' , 'name' , 'city' , 'adress' , 'telephone' ) as $value )
        {
            self::$fields[ $value ]['error'] = ('Неправильно заполнено' );
        }
        
        self::$fields['name']['comment'] = ('Имя');
        self::$fields['city']['comment'] = ('Город');
        self::$fields['adress']['comment'] = ('Адрес');
        self::$fields['telephone']['comment'] = ('Телефон');
        self::$fields['info']['comment'] = ('Комментарий');
    }
}
