<?php
//var_dump($this);die;
$this->current_page = Input::page( Input::get('page') );

$this->news_per_page = 25;

$this->status = array(
    'new'       => 'Новый',
    'view'      => 'Принято',
    'done'      => 'Заказ выполнен',
    'accept'    => 'Выполняется',
    'decline'   => 'Отказано',
);

$where = null;
$this->_status = Input::get('status');
if ( $this->_status )
{
    $where = array('status' => $this->_status );
}

$this->_lang = Input::post('lang', Session::get('filter_lang'));
if ( $this->_lang )
{
    $where = is_array( $where ) ? array_merge( $where , array('lang' => $this->_lang ) ) : array('lang' => $this->_lang );
    $where2 = ' WHERE `lang` = "' . $this->_lang . '" '; 
    $where3 = ' AND `lang` = "' . $this->_lang . '" '; 
}
else
{
    $where2 = ''; 
    $where3 = ''; 
}


if ( isset( $_POST['lang'] ) )
{
    if ( empty( $this->_lang ) )
    {
        Session::del('filter_lang' );
    }
    else
    {
        Session::set('filter_lang' , $this->_lang );
    }
    Page::go_back();
}

$this->data = DB\Shop\Order::select_calc( 
    array('id' , 'lang' , 'status' , 'price' , 'city' , 'adress' , 'email', 'telephone', 'ip' , 'date_ins', 'name') , 
    $where , 
    array('id' , 'DESC') , array( ( $this->current_page - 1 ) * $this->news_per_page  , $this->news_per_page ) 
)->rows();




if ( empty( $this->data ) && $this->current_page != 1 )
{
    _Error::render( _Error::NOT_FOUND );
}

$this->total = DB::get_found_rows();
$this->pagination_html = $this->module( '/blocks/pagination' , null  , ceil( $this->total / $this->news_per_page ) , $this->current_page , 
    Page::admin( '?' . ( $this->_status ? ( 'status=' . $this->_status . '&' )  : '' ) .'page=' )  , false , null );

$this->order_count = DB::exec('SELECT
    COUNT(`id`) as `count` , `status`
    FROM `order`' 
    . $where2 . '
    GROUP BY `status`
')->rows('status');

$this->income = DB::exec('SELECT
    SUM(`price`) as `sum` , `lang`
    FROM `order`
    WHERE `status` = "done"'
     . $where3 . '
    GROUP BY `lang`
')->rows('lang');