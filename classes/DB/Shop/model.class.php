<?php

namespace DB\Shop;
use DB;

class model extends DB\Table
{
    static $table_name = 'shop_product_models';



    public static $price = array(
        
        'UAH' => array(
            'country'   => 'Украина',
            'symbol'    => 'грн.',
            'lang'      => \Localka::RU,
            'site'      => \Localka::RU,
        ) , 
         
    );

/*    
    public static $price = array(
        'RUR' => array(
            'country'   => 'Россия',
            'symbol'    => 'руб.',
            'lang'      => \Localka::RU,
            'site'      => \Localka::RU,
        ) , 
        'UAH' => array(
            'country'   => 'Украина',
            'symbol'    => 'грн.',
            'lang'      => \Localka::UA,
            'site'      => \Localka::RU,
        ) , 
        'USD' => array(
            'country'   => 'USA',
            'symbol'    => '$',
            'lang'      => \Localka::EN,
            'site'      => \Localka::EN,
        ) , 
    );
*/


    
    public static $lang_currency = array(
        \Localka::EN => 'USD' ,
        \Localka::RU => 'RUR' ,
    );
    
    static $fields = array(
        'product_id' => array(
            'type' => 'enum' , 
            ) ,
        'article' => array( 
            'type' => 'varchar' , 
            'length' => 32 ,
            'length_min' => 2,
            'decorators' => 'trim_no_html'
        ), 
        'model' => array( 
            'type' => 'varchar' , 
            'length' => 127 ,
            'length_min' => 2,
            'decorators' => 'trim_no_html'
        ), 
        'action' => array( 
            'type' => 'varchar' , 
            'length' => 32 , 
            'decorators' => 'trim_no_html'
        ), 
        'length' => array( 
            'type' => 'varchar' , 
            'comment'=> 'в метрах',
        ), 
        'section' => array( 
            'type' => 'varchar' , 
            'length' => 16 ,
            'comment'=> 'Количество секций',
        ),
        'rings' => array( 
            'type' => 'varchar' , 
            'length' => 32 ,
            'length_min' => 2,
            'decorators' => 'trim_no_html',
            'comment'=> 'Кольца',
        ),
        'test' => array( 
            'type' => 'varchar' , 
            'length' => 32 ,
            'length_min' => 2,
            'decorators' => 'trim_no_html',
            'comment'=> 'Тест',
        ),
        'weight' => array( 
            'type' => 'varchar' , 
            'comment'=> 'граммы',
        ),
        'transport_length' => array( 
            'type' => 'varchar' , 
            'comment'=> 'сантиметры',
        ),
        'price_RUR' => array(
            'type' => 'int' , 
            ) ,
        'price_UAH' => array(
            'type' => 'int' , 
            ) ,
        'price_USD' => array(
            'type' => 'int' , 
            ) ,
        'out_of_stock' => array(
            'type'  => 'bool',
            'default' => 0,
            'comment' => 'Нет в наличии'
        )
    );
}