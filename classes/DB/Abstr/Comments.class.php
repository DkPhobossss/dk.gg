<?php
/**
 * 1 - read_news
 * 2 - read_blog
 * 3 - shop_product 
 * 4 - learn_news
 * 5 - watch_channel
 * 6 - watch_videos
 * 7 - watch_gallery
 */


namespace DB\Abstr;
use DB;

abstract class Comments extends DB\Table
{
    const READ_NEWS     = 1;
    const READ_BLOGS    = 2;
    const SHOP_PRODUCT  = 3;
    const LEARN_NEWS    = 4;
    const WATCH_CHANNEL = 5;
    const WATCH_VIDEOS  = 6;
    const WATCH_GALLERY = 7;
    
    
    static $table_name = 'global_comments';

    public static $path = 'ajax/json/comments/';
    
    protected static $type = null;
    
    protected static $parent_table = null;
    protected static $parent_field_id = null;
    protected static $parent_fields_system_rating = null;
    
    protected static $rating_table = 'global_comments_rating';
    protected static $gold_table = 'global_comments_gold';
    
    public static $comments_per_page = 20;
    
    protected static $no_lang = null;



    public static function get_comments( $news_id , $page , $count , $field, $order , $last = false )
    {
        if ( $last )
        {
            $page = DB::exec('SELECT COUNT(`id`) 
                    FROM `' . self::$table_name . '`
                    WHERE 
                    `news_id` = %s AND 
                    `lang` = %s AND
                    `type` = %s' , $news_id , \Localka::$lang, static::$type )->row();
            $page = ceil( reset( $page ) / $count );
        }
        
        return DB::exec('SELECT SQL_CALC_FOUND_ROWS 
                    `comments`.`id` , `comments`.`news_id` , `comments`.`lang`  , `comments`.`deleted` , `comments`.`user_id` ,
                    `comments`.`like` , `comments`.`dislike`, `comments`.`gold` AS `comment_gold` , UNIX_TIMESTAMP(`comments`.`date_ins`) as `comment_date_ins` , 
                    ' . ( \Auth::rule( \DB\Rules::COMMENTS_DELETE ) ? '`content` , `ip`' : 'IF (`deleted` = 0 , `content` , NULL ) AS `content`' ) .' , 
                `user`.`member_name` , `user`.`gold` , `user`.`karma_bad` , `user`.`karma_good`, `user`.`country_flag` , `user`.`group_id`,
                `user`.`game` , IF ( UNIX_TIMESTAMP() - `user`.`last_login` > 900 , "off" , "on" ) as `online_val` , 
                    IF(`attachment`.`filename` IS NOT NULL , CONCAT("' . \Config::avatar_src . '" , `attachment`.`filename`) , "' . \Config::default_avatar . '") as `avatar`,  
                `groups`.`color` , `groups`.`background-color`, `groups`.`background-header-color`, `groups`.`name` as `group_name`,
                    SUBSTRING_INDEX( GROUP_CONCAT( `awards`.`id_award` ORDER BY `awards`.`favorite` DESC  ) , "," , 5 ) AS  `awards`  
            FROM `' . self::$table_name . '` AS `comments`
            LEFT JOIN `smf_members` AS `user` ON 
                `user`.`id_member` = `comments`.`user_id`
            LEFT JOIN `smf_attachments` AS `attachment` ON 
                `attachment`.`id_member` = `user`.`id_member`
            LEFT JOIN `groups` ON 
                `groups`.`id` = `user`.`group_id`
            LEFT JOIN  `smf_awards_members` AS  `awards` ON  
                `awards`.`id_member` =  `comments`.`user_id` 
            WHERE 
                `news_id` = %s AND 
                `lang` = %s AND
                `type` = %s
            GROUP BY `comments`.`id` 
            ORDER BY ' . ( $field != 'like' ? ( '`comments`.`' . $field . '`' ) : ( ' (`comments`.`rating`) ' )  ) . ' ' . $order . '
            LIMIT %d , %d' , $news_id , \Localka::$lang , static::$type, ($page - 1) * $count , $count )->rows();
    }
    
    
    public static function get_short_comments( $news_id , $page , $count , $field, $order , $last = false )
    {
        if ( $last )
        {
            $page = DB::exec('SELECT COUNT(`id`) 
                    FROM `' . self::$table_name . '`
                    WHERE 
                    `news_id` = %s AND 
                    `lang` = %s AND
                    `type` = %s' , $news_id , \Localka::$lang, static::$type )->row();
            $page = ceil( reset( $page ) / $count );
        }
        
        return DB::exec('SELECT SQL_CALC_FOUND_ROWS 
                    `comments`.`id` , `comments`.`news_id` , `comments`.`lang`  , `comments`.`deleted` , `comments`.`user_id` ,
                    `comments`.`like` , `comments`.`dislike`, `comments`.`gold` AS `comment_gold` , UNIX_TIMESTAMP(`comments`.`date_ins`) as `comment_date_ins` , 
                    ' . ( \Auth::rule( \DB\Rules::COMMENTS_DELETE ) ? '`content` , `ip`' : 'IF (`deleted` = 0 , `content` , NULL ) AS `content`' ) .' , 
                `user`.`member_name` , `user`.`country_flag` , `user`.`group_id`,
                IF ( UNIX_TIMESTAMP() - `user`.`last_login` > 900 , "off" , "on" ) as `online_val` , 
                    IF(`attachment`.`filename` IS NOT NULL , CONCAT("' . \Config::avatar_src . '" , `attachment`.`filename`) , "' . \Config::default_avatar . '") as `avatar`,  
                `groups`.`color` , `groups`.`background-color`, `groups`.`background-header-color`, `groups`.`name` as `group_name`
            FROM `' . self::$table_name . '` AS `comments`
            LEFT JOIN `smf_members` AS `user` ON 
                `user`.`id_member` = `comments`.`user_id`
            LEFT JOIN `smf_attachments` AS `attachment` ON 
                `attachment`.`id_member` = `user`.`id_member`
            LEFT JOIN `groups` ON 
                `groups`.`id` = `user`.`group_id`
            WHERE 
                `news_id` = %s AND 
                `lang` = %s AND
                `type` = %s
            ORDER BY ' . ( $field != 'like' ? ( '`comments`.`' . $field . '`' ) : ( ' (`comments`.`rating`) ' )  ) . ' ' . $order . '
            LIMIT %d , %d' , $news_id , \Localka::$lang , static::$type, ($page - 1) * $count , $count )->rows();
    }
    
    
    public static function add_comment( $news_id , $user_id , $comment )
    {
        \Session::check();
        
        if ( !$user_id )
        {
            throw new \Exception\User( __( 'error_user_not_found' ) );
        }
        
        $comment = trim( $comment );
        
        if ( ( $len = mb_strlen( $comment ) ) < 5 || $len > 50000 )
        {
            throw new \Exception\User( __('error_comment_length_5-50000') );
        }
        
        DB\Forum\Ban::check_restriction ( 'cannot_post' );

        try
        {
            DB::transaction();

            if ( isset( static::$parent_table ) )
            {
                if ( isset( static::$no_lang ) )
                {
                    $condition = array( static::$parent_field_id => $news_id  );
                }
                else
                {
                    $condition = array( static::$parent_field_id => $news_id , 'lang' => \Localka::$lang );
                }
                
                
                if ( isset( static::$parent_fields_system_rating ) )
                {
                    DB::update( static::$parent_table , array( 
                            'comments' => array( '`comments` + 1' ) , 
                            static::$parent_fields_system_rating => array( '`' . static::$parent_fields_system_rating . '` + 0.5' )  
                        ) , 
                         $condition );
                }
                else
                {
                    DB::update( static::$parent_table , array( 'comments' => array( '`comments` + 1' ) ) , 
                                                         $condition );
                }
                        
                if ( !DB::affected_rows() )
                {
                    throw new \Exception\User( __('Article doesnt exist') );
                }
            }
            
            DB::insert( self::$table_name , array( 
                'news_id' => $news_id , 
                'lang' => \Localka::$lang , 
                'user_id' => $user_id , 
                'content' => htmlspecialchars( $comment )  ,
                'ip' => \Auth::ip() ,
                'type' => static::$type) 
            );

            DB::commit();
        }
        catch ( \Exception $e )
        {
            DB::rollback();
            throw new \Exception\Fatal( $e->getMessage() );
        }
        
        return true;
    }
    
    
    public static function replace_quotes( $comment )
    {
        $comment = nl2br( $comment );
        
        $comment = preg_replace( "/\[quote author='([^']*)' \]/is" ,'<blockquote><div class="quote_head">$1</div>', $comment , -1 , $open);
        $comment = str_replace( '[/quote]' , '</blockquote>', $comment, $closed );


        if ( ( $diff = $open - $closed ) )
        {
            if ( $diff > 0 )
            {
                for ( ; $diff > 0 ; $diff-- )
                {
                    $comment .= '</blockquote>';
                }
            }
            else
            {
                for ( ; $diff < 0 ; $diff++ )
                {
                    $comment = '<blockquote>' . $comment;
                }
            }
        }

        return $comment;
    }
    
    public static function get_comment_quote( $comment_id )
    {
        return DB::select( self::$table_name ,  array( 'content' ) , array( 'id' => $comment_id ) )->value();
    }
    
    
    public static function karma( $comment_id , $user_id , $value )
    {
        \Session::check();
               
        if ( !$user_id )
        {
            throw new \Exception\User( __( 'error_user_not_found' ) );
        }
        
        $data = DB::select( self::$table_name ,  array( 'user_id' ) , array( 'id' => $comment_id ) )->row(); 
        if ( empty( $data ) || $data['user_id'] == $user_id )
        {
            throw new \Exception\User( __( 'error_cant_rating_yourself_or_not_existing_comment' ) );
        }

        if ( $value == 1 )
        {
            if ( !DB::insert( self::$rating_table , array('comment_id' => $comment_id , 'user_id' => $user_id , 'score' => 1 ) ) )
            {
                throw new \Exception\User( __( 'error_allready_use_rating' ) );
            }
            
            DB::update( self::$table_name ,   array( 'like'  => array( "`like` + 1" ) , 'rating' => array("`rating` + 1  ") ) , array( 'id' => $comment_id ) );
        
            return \DB\User::update( array( 'karma_good'  => array( "`karma_good` + 1" ) ) ,  array('id_member' => $data['user_id'] ) );
        }
        else
        {
            if ( !DB::insert( self::$rating_table , array('comment_id' => $comment_id , 'user_id' => $user_id , 'score' => '-1' ) ) )
            {
                throw new \Exception\User( __( 'error_allready_use_rating' ) );
            }
            
            DB::update( self::$table_name ,   array( 'dislike'  => array( "`dislike` + 1" ) , 'rating' => array("`rating` - 1  ") ) , array( 'id' => $comment_id ) );
        
            return \DB\User::update( array( 'karma_bad'  => array( "`karma_bad` + 1" ) ) ,  array('id_member' => $data['user_id'] ) );
        }
    }
    
    
    public static function change_state( $comment_id , $state = 0 )
    {
        \Session::check( );
        if ( !\Auth::rule( DB\Rules::COMMENTS_DELETE ) )
        {
            return false;
        }
        return DB::update( self::$table_name , array( 'deleted' => $state ) , array( 'id' => $comment_id ) );
    }
    
    
    public static function give_gold( $comment_id )
    {
        \Session::check( );
        
        try
        {
            DB::transaction();
            
            DB::exec('UPDATE 
                `' . self::$table_name . '`
                SET `gold` = `gold` + 1,
                    `user_id` = ( @user_id := `user_id` )
                WHERE 
                    `id` = %s' , $comment_id );
                
            if ( !DB::affected_rows() )
            {
                throw new \Exception\User( __('Comment doesnt exist') );
            }
            
            $user_id = DB::get_variable( 'user_id' );
            
            DB::if_not_insert_update( self::$gold_table , array( 'comment_id' => $comment_id , 'user_id' => \Auth::id() ) , array( 'gold' => array('`gold` + 1') ) );
            
            DB\User::update( array('gold' => array('`gold` + 1') , 'karma_good' => array( '`karma_good` + 1' ) ) ,  array('id_member' => $user_id) );
            DB::commit();
        }
        catch ( \Exception $e )
        {
            DB::rollback();
            throw new \Exception\Fatal( $e->getMessage() );
        }

        return true;
    }
}
