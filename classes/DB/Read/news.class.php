<?php

namespace DB\Read;
use DB;

class news extends DB\Table
{
    static $table_name = 'read_news';
    static $fields = array(
        'cat_id' => array( 
            'type' =>'enum' ,
            'length' => array( 
                'Новости' => '1' , 
                'Статьи' => '2' 
            ),
        ), 
        'url' => array( 
            'type' =>'varchar' ,
            'length_min' => 2, 
            'length' => 64 , 
            'decorators' => 'trim_no_tags' ,
            'regexp' => '^[0-9a-zA-Z\-\_]+$',
            'error' => 'No russian symbols and spaces(use _ )' ,
        ), 
        'creator_id' => array(
            'type' => 'int',
            'disable_update' => true
        ),
        'image' => array(
            'type'  => 'browse',
            'length' => 255,
            'file_type' => 'Images',
            'folder' => 'preview' ,
            'decorators' => 'trim_nohtml_noquotes',
            'comment' => '181x80',
            'width' => 181,
            'height'=> 80
        ),
    );
    
    static $cats = array(
        1 => 'news',
        2 => 'articles'
    );



    public static function get_last_news( $count = 8 )
    {
        $data = \DB::exec('SELECT * FROM ( ( SELECT
                `url` , `cat_id`, `image`, `date_ins`,
                `title`, `preview`
                FROM
                  `read_news`
                INNER JOIN
                  `read_news_data` ON
                      `read_news_data`.`news_id` = `read_news`.`id` AND
                      `read_news_data`.`lang` = %s
              ORDER BY
                `date_ins` DESC
              LIMIT 0,%d )
              UNION
              ( SELECT
                `url` , NULL as `cat_id`, `image_preview` as `image` , `date_ins`,
                `title`, `description` as `preview`
                FROM
                  `video`
                INNER JOIN
                  `video_data` ON
                      `video_data`.`video_id` = `video`.`id` AND
                      `video_data`.`lang` = %s
              ORDER BY
                `date_ins` DESC
              LIMIT 0,%d ) ) as `t`
              ORDER BY `date_ins` DESC
              LIMIT 0,%d', \Localka::$lang, $count, \Localka::$lang, $count, $count )->rows();

        foreach ( $data as &$row )
        {
            $row['url'] =  ( empty( $row['cat_id'] ) ? 'video' : self::$cats[ $row['cat_id'] ] ) . '/' . $row['url'];
            $row['preview'] = mb_substr( trim( str_replace( '&nbsp;' , '' , strip_tags( $row['preview']  ) ) ) , 0 , 250 );
        }

        return $data;
    }
}