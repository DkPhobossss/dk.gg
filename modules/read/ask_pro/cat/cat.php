<?php
$this->args( 'cats' , 'cat_id' );
$this->access = Auth::rule( 60 );


$this->page = Input::page( Input::get('page') );
$this->news_per_page = 10;

if ( isset( $this->cats[ $this->cat_id ] ) ) 
{
    $where = 'AND `cat_id` = ' . intval( $this->cat_id );
}
else
{
    $where = 'AND `cat_id` = ' . intval( key ( $this->cats ) );
}

if ( $this->access )
{	 	 	 	 	 	 	
    $this->data = DB::exec( 'SELECT SQL_CALC_FOUND_ROWS
        `askpro`.* 
    FROM `askpro`
    WHERE 
        `lang` = %s' .
        $where . '
    ORDER BY 
        `id` DESC
    LIMIT ' .  ( ( $this->page - 1 ) * $this->news_per_page ) . "," . $this->news_per_page , Localka::$lang )->rows();
}
else
{
    $this->data = DB::exec( 'SELECT SQL_CALC_FOUND_ROWS
        `askpro`.* 
    FROM `askpro`
    WHERE 
        `lang` = %s AND
        `visible` = 1 ' .
        $where . '
    ORDER BY 
        `id` DESC
    LIMIT ' .  ( ( $this->page - 1 ) * $this->news_per_page ) . "," . $this->news_per_page , Localka::$lang )->rows();
}

if ( empty( $this->data ) && $this->page != 1 )
{
    _Error::render( _Error::NOT_FOUND );
}

$this->total = DB::get_found_rows();
$this->pagination_html = $this->module( '/blocks/pagination' , null  , ceil( $this->total / $this->news_per_page ) , $this->page ,'ask_pro/' . $this->cat_id . '/?page=' , false , null );


$this->seo = array( 'seo_title' => ('seo_title_askpro') . ' ' . $this->cats[ $this->cat_id ]['name'] ,
    'seo_description' => ('seo_title_askpro') ,
    'seo_keywords' => ('seo_keywords_askpro') );