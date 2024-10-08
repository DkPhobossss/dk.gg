<?php
$this->args( 'cat_url' );

if ( Input::get('view') )
{
    if ( $_GET['view'] == 'list' )
    {
        Cookie::set( 'cat_view' , 'list' , 2592000 );
    }
    else
    {
        Cookie::set( 'cat_view' , 'plitka', 2592000 );
    }
    Page::go_back();
}

$this->view = Cookie::get( 'cat_view' );


$this->current_page = Input::page( Input::get('page') );

$this->cat = DB\Shop\cat::url( $this->cat_url );

if ( empty( $this->cat ) )
{
    _Error::render( _Error::NOT_FOUND );
}
  
$this->show = 10;

$this->data = DB::exec('SELECT SQL_CALC_FOUND_ROWS
                `shop_product`.`id` , `shop_product`.`image_text`, `shop_product`.`image_preview` , `shop_product`.`image_preview_plitka` , CONCAT( "shop/" , "' . $this->cat_url . '/", `shop_product`.`url`) as `url` , 
                `shop_product_data`.`name`
        FROM `shop_product`
        LEFT JOIN `shop_product_data` ON 
            `shop_product_data`.`product_id` = `shop_product`.`id` AND 
            `shop_product_data`.`lang` = %s
        WHERE  `cat_id` = %s
        ORDER BY `priority` DESC , `shop_product`.`id` DESC
        LIMIT %d, %d' , Localka::$lang , $this->cat['id'], ( $this->current_page - 1 ) * $this->show, $this->show
    )->rows();                        

if ( empty( $this->data ) && $this->current_page != 1 )
{
    _Error::render( _Error::NOT_FOUND );
}

$this->total = DB::get_found_rows();

$this->pagination = $this->module( '/blocks/pagination', '',  ceil( $this->total / $this->show ), $this->current_page, 'shop/' . $this->cat_url . '?page=' , false, null , null );