<?php
$this->args('page' , 'cat_id');

if ( empty( $this->page ) )
{
    $this->page = 1;
}
elseif ( $this->page < 1 )
{
    _Error::render( _Error::NOT_FOUND );
}

$this->news_per_page = 5;

$this->access = Auth::rule();
if ( $this->access )
{	 	 	 	 	 	 	
    $this->data = DB::exec( 'SELECT SQL_CALC_FOUND_ROWS
    `read_news`.`id` , `read_news`.`url`, 
        `read_news_data`.`title` , `read_news_data`.`preview`, `read_news_data`.`date_ins`
    FROM `read_news`
    LEFT JOIN `read_news_data` 
        ON 
        `read_news`.`id` = `read_news_data`.`news_id` AND 
        `read_news_data`.`lang` = %s
    WHERE 
        `read_news`.`cat_id` = %s
    ORDER BY `id` DESC
    LIMIT ' .  ( ( $this->page - 1 ) * $this->news_per_page ) . "," . $this->news_per_page , Localka::$lang, $this->cat_id )->rows();
}
else
{
    $this->data = DB::exec( 'SELECT SQL_CALC_FOUND_ROWS
    `read_news`.`id` , `read_news`.`url`, 
        `read_news_data`.`title` , `read_news_data`.`preview`, `read_news_data`.`date_ins`
    FROM `read_news`
    INNER JOIN `read_news_data` 
        ON 
        `read_news`.`id` = `read_news_data`.`news_id` AND 
        `read_news_data`.`lang` = %s
    WHERE 
        `read_news`.`cat_id` = %s
    ORDER BY `id` DESC
    LIMIT ' .  ( ( $this->page - 1 ) * $this->news_per_page ) . "," . $this->news_per_page , Localka::$lang, $this->cat_id   )->rows();
}

if ( empty( $this->data ) && $this->page != 1 ) 
{
    _Error::render( _Error::NOT_FOUND );
}

$this->total = DB::get_found_rows();
$this->pagination_html = $this->module( '/blocks/pagination' , null  , ceil( $this->total / $this->news_per_page ) , $this->page ,  DB\Read\news::$cats[ $this->cat_id ] . '/?page=' , false , null );


if ( $this->cat_id == 1 )
{
    $this->seo = array( 'seo_title' => ('Seo title news') ,
        'seo_description' => ('Seo description news') ,
        'seo_keywords' => null );
}
else
{
        $this->seo = array( 'seo_title' => ('seo_title_article') ,
        'seo_description' => ('seo_description_article') ,
        'seo_keywords' => null );
}

