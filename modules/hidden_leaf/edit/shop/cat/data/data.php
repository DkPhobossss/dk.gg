<?php

$this->args('id');
$this->data = array(
    'name' => '',
    'seo_title' => '',
    'seo_description' => '',
    'seo_keywords' => '',
    'content' => '',
);


$this->cat = DB::exec(
    'SELECT `url` , `id` , cat_id ,
    ' . implode( ',' , array_keys( $this->data ) ) . '    
    FROM `shop_cat` 
    LEFT JOIN `shop_cat_data` ON
        `shop_cat_data`.`cat_id` = `shop_cat`.`id` AND `shop_cat_data`.`lang` = %s
    WHERE `id` = %d' , Localka::$lang , $this->id )->row();

if ( empty( $this->cat ) )
{
    _Error::render( _Error::NOT_FOUND );
}


$this->result = null;
if ( isset($this->cat['cat_id']) )
{
    $this->action = 'update';
}
else
{
    $this->action = 'insert';
}



if ( $this->action == 'update' )
{
    if ( !empty( $_POST ) )
    {
        Session::check( 'post' );
        $this->result = DB\Shop\cat_data::update_row( Input::post( 'field' ), array( 'cat_id' => $this->id, 'lang' => Localka::$lang ) );
    }

    $this->data = Helper::redeclare_array( $this->data , $this->cat , Input::post('field' , array() ) );
}
else
{
    if ( !empty( $_POST ) )
    {
        Session::check( 'post' );
        
        $_POST['field']['cat_id'] = $this->cat['id'];
        $_POST['field']['lang'] = Localka::$lang;

        if ( DB\Shop\cat_data::insert_row( Input::post( 'field' ) ) )
        {
            Page::go_back();
        }
    }
}
