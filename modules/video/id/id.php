<?php
$this->args('url');


$this->access = Auth::rule();

if ( $this->access )
{
    $this->data = DB::exec('SELECT
    `video`.`id` , `video`.`url`, `video`.`image`,
        `video_data`.`title`, `video_data`.`views`, `video_data`.`content`, `video_data`.`date_ins`,
        `video_data`.`seo_title`, `video_data`.`seo_description`, `video_data`.`seo_keywords`
    FROM `video`
    LEFT JOIN `video_data`
        ON
        `video`.`id` = `video_data`.`video_id` AND
        `video_data`.`lang` = %s
    WHERE
        `video`.`url` = %s' , Localka::$lang , $this->url )->row();
}
else
{
    $this->data = DB::exec('SELECT
    `video`.`id` , `video`.`url`, `video`.`image`,
        `video_data`.`title`, `video_data`.`views`, `video_data`.`content`, `video_data`.`date_ins`,
        `video_data`.`seo_title`, `video_data`.`seo_description`, `video_data`.`seo_keywords`
    FROM `video`
    INNER JOIN `video_data`
        ON
        `video`.`id` = `video_data`.`video_id` AND
        `video_data`.`lang` = %s
    WHERE
        `video`.`url` = %s' , Localka::$lang , $this->url )->row();
}

if ( empty( $this->data ) )
{
    _Error::render( _Error::NOT_FOUND );
}

DB\Video_data::update( array('views' => array('`views` + 1') ) , array('video_id' => $this->data['id'] , 'lang' => Localka::$lang ) );


$this->count = 3;
$this->extra = DB::exec('SELECT
    `video`.`id` , `video`.`url`, `video`.`time`, `video`.`image`,
        `video_data`.`title`, `video_data`.`views`
    FROM `video`
    INNER JOIN `video_data`
        ON
        `video`.`id` = `video_data`.`video_id` AND
        `video_data`.`lang` = %s
    WHERE `video`.`id` <> %s
    ORDER BY RAND()
    LIMIT 0,%d', Localka::$lang, $this->data['id'], $this->count )->rows();