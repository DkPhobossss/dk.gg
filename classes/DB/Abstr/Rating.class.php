<?php

namespace DB\Abstr;
use DB;

abstract class Rating extends DB\Table
{
    static $table_name;
    
    public static $max_score = 5;
    public static $min_score = 0;
    public static $step = 0.2;
    public static $path = 'ajax/json/some_folder/';
    
    public static $can_revote = false;
    
    public static $fields = array(
        'object_id' => 'publication_id' , 
        'user_id' => 'user_id' , 
        'score' => 'score'
    );
    
    public static $main_table = array(
        'use_denormalization' => false,
        'class' => null , 
        'rating_field' => null , 
        'system_rating_field' => null,
        'count' => null
    );
    
    protected static $insert = false;
    
    protected static $no_lang = false;
    
    
    public static function vote( $publication_id , $user_id , $score , $type = 'post' , $condition_array = array() )
    {
        if ( !$user_id )
        {
            return false;
        }
        
        \Session::check( $type );
        
        if ( static::$main_table['use_denormalization'] )
        {
            try
            {
                DB::transaction();
                
                if ( !class_exists( $class = static::$main_table['class'] ) )
                {
                    throw new \Exception\Fatal('Rating class is invalid');
                }
                
                if ( !$class::exists( $condition_array ) )
                {
                    throw new \Exception\Fatal('Not found');
                }
                
                $score = min( max( intval( $score ), static::$min_score ) , static::$max_score );
                $score = ceil( $score / static::$step  ) * static::$step;
                
                if ( static::$can_revote )
                {
                    //
                }
                else
                {
                    if ( empty( static::$insert ) )
                    {

                        DB::exec('Update ' . static::$table_name 
                            . ' SET  `' . static::$fields['score'] .'` = %d  
                            WHERE 
                                `' . static::$fields['object_id'] .'` = %s AND'
                                . ( empty( static::$no_lang ) ? '`lang` = %s AND ' : '' ) .
                                '`' . static::$fields['user_id'] .'` = %s AND
                                `score` IS NULL ' , $score , $publication_id , \Localka::$lang , $user_id  );

                        $result = DB::affected_rows();
                    }
                    else
                    {
                        if ( empty( static::$no_lang ) )
                        {
                            DB::exec('INSERT INTO ' . static::$table_name 
                                . ' (`publication_id` , `lang` , `user_id` , `score`)'
                                .  'VALUES ( %s, %s, %s , %s )' ,  $publication_id , \Localka::$lang , $user_id , $score );
                        }
                        else
                        {
                            DB::exec('INSERT INTO ' . static::$table_name 
                                . ' (`publication_id` , `user_id` , `score`)'
                                .  'VALUES ( %s, %s , %s )' ,  $publication_id  , $user_id , $score );
                        }
                        
                        $result = DB::insert_id();
                    }

                    if ( $result )
                    {
                        if ( !isset( static::$main_table['system_rating_field'] ) )
                        {
                            $result = $class::update( array( 
                                static::$main_table['rating_field'] => array( "`" . static::$main_table['rating_field'] . "` + $score" ) , 
                                static::$main_table['count'] => array( '`' . static::$main_table['count'] . '` + 1' ) 
                            ) ,  $condition_array );
                        }
                        else
                        {
                            //system_rating
                            $result = $class::update( array( 
                                static::$main_table['rating_field'] => array( "`" . static::$main_table['rating_field'] . "` + $score" ),
                                static::$main_table['system_rating_field'] => array( "`" . static::$main_table['system_rating_field'] . "` + " . ( $score * $score / 100 ) ),
                                static::$main_table['count'] => array( '`' . static::$main_table['count'] . '` + 1' ) 
                            ) ,  $condition_array );
                        }
                    }
                }
                
                DB::commit();
            }
            catch ( \Exception $e )
            {
                DB::rollback();
                throw new \Exception\Fatal( $e->getMessage() );
            }
            return $result;
        }

        $score = min( max( intval( $score ), static::$min_score ) , static::$max_score );
        $score = ceil( $score / static::$step  ) * static::$step;
        
        if ( static::$can_revote )
        {
            if ( empty( static::$no_lang ) )
            {
                return static::if_not_insert_update( 
                    array(  
                        static::$fields['object_id'] => $publication_id , 
                        static::$fields['lang'] => \Localka::$lang , 
                        static::$fields['user_id'] => $user_id, 
                        static::$fields['score'] => $score
                    ), 
                    array('score' => $score ) 
                );
            }
            
            return static::if_not_insert_update( 
                    array(  
                        static::$fields['object_id'] => $publication_id , 
                        static::$fields['user_id'] => $user_id, 
                        static::$fields['score'] => $score
                    ), 
                    array('score' => $score ) 
                );
        }
        else
        {
            if ( empty( static::$no_lang ) )
            {
                return static::insert( array(  
                    static::$fields['object_id'] => $publication_id , 
                    static::$fields['lang'] => \Localka::$lang , 
                    static::$fields['user_id'] => $user_id, 
                    static::$fields['score'] => $score
                ) );
            }
            
            return static::insert( array(  
                static::$fields['object_id'] => $publication_id , 
                static::$fields['user_id'] => $user_id, 
                static::$fields['score'] => $score
            ) );
        }
    }
}
