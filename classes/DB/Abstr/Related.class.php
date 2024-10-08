<?php

namespace DB\Abstr;
use DB;


abstract class Related extends DB\Table
{
    static $table_name;
    static $news_id_field = null;
    
    public static function insert_words( $news_id , $lang , $text )
    {
        static::delete_words( $news_id , $lang );
        
        foreach( \Word::create_encoding_words( $text, $lang ) as $value )
        {
            DB::if_not_insert_update( static::$table_name , array( static::$news_id_field => $news_id , 
                'lang' => $lang  , 
                'word' => $value , 
                'soundex' => soundex( $value ) 
                ), array('count' => array('`count` + 1') ) );
        }
        return true;
    }
    
    public static function delete_words( $news_id , $lang = null )
    {
        return isset( $lang )   ? DB::delete( static::$table_name, array( static::$news_id_field => $news_id , 'lang' => $lang ) )
                                : DB::delete( static::$table_name, array( static::$news_id_field => $news_id ) );
    }
    
    
    public static function get_related_news( $id , $lang , $count , $cat_global_id )//abstract
    {
        /*
        * 
        * SELECT `twop_news`.`id`, SUM( GREATEST(`r2`.`count`, `r1`.`count`) *  ( LENGTH( `r1`.`word` ) + LENGTH( `r2`.`word` ) ) / ( LEVENSHTEIN(`r1`.`word`, `r2`.`word`) + 1 ) )
   FROM  `twop_news`
   STRAIGHT_JOIN `twop_news_related` AS `r1` ON `twop_news`.`id` = `r1`.`news_id`
   STRAIGHT_JOIN `twop_news_related` AS `r2` ON `r2`.`soundex` = `r1`.`soundex` AND `r2`.`news_id` = 10300
   WHERE `twop_news`.`cat_global_id` = 1
   GROUP BY `twop_news`.`id`
   HAVING `twop_news`.`id` <> 10300
   ORDER BY 2 DESC
   LIMIT 10
        * 
        * 
        */
        return true;
    }
    

    
}
