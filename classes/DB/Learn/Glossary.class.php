<?php

namespace DB\Learn;
use DB;

class Glossary extends DB\Table
{
    static $table_name = 'learn_glossary';

    static $fields = array(
        'url' => array(
            'type' =>'varchar' ,
            'length_min' => 4,
            'length' => 64 ,
            'decorators' => 'trim_no_tags' ,
            'regexp' => '^[0-9a-zA-Z\-\_]+$',
            'error' => 'No russian symbols and spaces(use _ )' ,
        ),
        'creator_id' => array(
            'type' => 'int',
            'disable_update' => true
        ),
    );

    public static function get_popular_terms( $count )
    {
        \DB::set_variable('row_number' , 0);
        \DB::set_variable('t' , 0);
        $data = \DB::exec('SELECT `name`,`url`,`t` as `letter` FROM
            (
            SELECT 
            @row_number:=(CASE
                    WHEN @t = substr(`name`,1,1)
                      THEN 
                          @row_number + 1
                      ELSE 
                           1
                    END) AS `num`,
            @t:=substr(`name`,1,1) as `t`,
            `name`, 
            `url`
            
            FROM `learn_glossary` as `t1` 
            INNER JOIN `learn_glossary_data` as `t2` ON `t2`.`glossary_id` = `t1`.`id` AND `t2`.`lang` = %s 
            ORDER BY substr(`name`,1,1), `views` DESC
            ) as `temp_table`
            WHERE `num` <= %d', \Localka::$lang, $count )->rows('letter', true);

        return $data;
    }

    public static function get_alphabet()
    {
        return \DB::exec('SELECT 
            substr(`name`,1,1) as `letter`
            FROM `learn_glossary` as `t1` 
            INNER JOIN 
                `learn_glossary_data` as `t2` ON 
                    `t2`.`glossary_id` = `t1`.`id` AND 
                    `t2`.`lang` = %s
            GROUP BY `letter`
            ORDER BY `letter`', \Localka::$lang )->rows();
    }

    public static function get_letter_data( $letter, $access )
    {
        $join = $access ? 'LEFT' : 'INNER';
        return \DB::exec("SELECT 
            `name`, `url`, `id`
            FROM `learn_glossary` as `t1` 
            $join JOIN 
                `learn_glossary_data` as `t2` ON 
                    `t2`.`glossary_id` = `t1`.`id` AND 
                    `t2`.`lang` = %s
            WHERE `name` LIKE %s
            ORDER BY `name`", \Localka::$lang, \DB::LIKE_security( $letter ) . '%' )->rows();
    }


    public static function get_word_data( $word, $access )
    {
        $join = $access ? 'LEFT' : 'INNER';
        return \DB::exec("SELECT 
            `name`, `url`, `id`, `views`, `system`, `module`,
            `content`, `seo_title`, `seo_description`, `seo_keywords`
            FROM `learn_glossary` as `t1` 
            $join JOIN 
                `learn_glossary_data` as `t2` ON 
                    `t2`.`glossary_id` = `t1`.`id` AND 
                    `t2`.`lang` = %s
            WHERE `url` = %s", \Localka::$lang,  $word )->row();
    }

}