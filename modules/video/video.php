<?php
$this->page = Input::page( Input::get('page') );

$this->news_per_page = 9;

$this->access = Auth::rule();
if ( $this->access )
{
    $this->data = DB::exec( 'SELECT SQL_CALC_FOUND_ROWS
    `video`.`id` , `video`.`url`, `video`.`time`, `video`.`image`,
        `video_data`.`title`, `video_data`.`views`
    FROM `video`
    LEFT JOIN `video_data`
        ON
        `video`.`id` = `video_data`.`video_id` AND
        `video_data`.`lang` = %s
    ORDER BY `date_ins` DESC
    LIMIT ' .  ( ( $this->page - 1 ) * $this->news_per_page ) . "," . $this->news_per_page , Localka::$lang)->rows();
}
else
{
    $this->data = DB::exec( 'SELECT SQL_CALC_FOUND_ROWS
    `video`.`id` , `video`.`url`, `video`.`time`, `video`.`image`,
        `video_data`.`title`, `video_data`.`views`
    FROM `video`
    INNER JOIN `video_data`
        ON
        `video`.`id` = `video_data`.`video_id` AND
        `video_data`.`lang` = %s
    ORDER BY `date_ins` DESC
    LIMIT ' .  ( ( $this->page - 1 ) * $this->news_per_page ) . "," . $this->news_per_page , Localka::$lang  )->rows();
}

if ( empty( $this->data ) && $this->page != 1 )
{
    _Error::render( _Error::NOT_FOUND );
}

$this->total = DB::get_found_rows();
$this->pagination_html = $this->module( '/blocks/pagination' , null  , ceil( $this->total / $this->news_per_page ) , $this->page ,  'video?page=' , false , null );


$this->seo = array( 'seo_title' => ('Seo title videos') ,
                    'seo_description' => ('Seo description videos') ,
                    'seo_keywords' => null );
