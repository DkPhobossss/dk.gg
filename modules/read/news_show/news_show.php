<?php
$this->args('url' , 'cat_id');
//var_dump($this->args);die;


$this->access = Auth::rule();

if ( $this->access )
{	 	 	 	 	 	 	
    $this->data = DB::exec( 'SELECT 
    `read_news`.`id` , `read_news`.`url`, 
        `read_news_data`.`title` , `read_news_data`.`content`, `read_news_data`.`date_ins`, `read_news_data`.`views`,
        `read_news_data`.`seo_title`,`read_news_data`.`seo_description`, `read_news_data`.`seo_keywords`
    FROM `read_news`
    LEFT JOIN `read_news_data` 
        ON 
        `read_news`.`id` = `read_news_data`.`news_id` AND 
        `read_news_data`.`lang` = %s
    WHERE 
        `read_news`.`url` = %s AND
        `read_news`.`cat_id` = %s' , Localka::$lang , $this->url , $this->cat_id  )->row();
}
else
{
    $this->data = DB::exec( 'SELECT
    `read_news`.`id` , `read_news`.`url`, 
        `read_news_data`.`title` , `read_news_data`.`content`, `read_news_data`.`date_ins`, `read_news_data`.`views`,
        `read_news_data`.`seo_title`,`read_news_data`.`seo_description`, `read_news_data`.`seo_keywords`
    FROM `read_news`
    INNER JOIN `read_news_data` 
        ON 
        `read_news`.`id` = `read_news_data`.`news_id` AND 
        `read_news_data`.`lang` = %s
        WHERE 
            `read_news`.`url` = %s AND
            `read_news`.`cat_id` = %s' , Localka::$lang , $this->url , $this->cat_id    )->row();
}

//var_dump($this->data);die;

if ( empty( $this->data ) )  {

    _Error::render( _Error::NOT_FOUND );
}

DB\Read\news_data::update( array('views' => array('`views` + 1') ) , array('news_id' => $this->data['id'] , 'lang' => Localka::$lang ) );