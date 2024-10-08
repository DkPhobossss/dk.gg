<?php

$this->args( 'id' );
$this->data = array(
    'cat_id' => '', 
    'image' => '', 
    'price' => '',
    'new' => '',
    'url' => '', 
    'navi_edition' => '' ,
    'priority' => '',
    'link_ua' => '', 
    'link_ru' => '', 
    'link_en' => '',
    'image_medium' => '' ,
    'image_medium_full_size' => '' ,
    'image_large_1' => '',
    'image_large_2' => '',
    'image_large_3' => '',
    'image_large_4' => '',
);
$this->result = null; 

DB\Shop\product::$fields['cat_id']['length'] = DB\Shop\cat::select( array('id' , 'url') , false , array('id' , 'ASC') )->rows( 'url' , 'id');

if ( empty( $this->id ) )
{
    //add
    if ( !empty( $_POST ) )
    {
        Session::check( 'post' );
        if ( ( $id = DB\Shop\product::insert_row( Input::post( 'field' ) ) ) )
        {
            Page::go( Page::admin( "edit/shop/product?id=$id" ) );
        }
    }
    $this->data['cat_id'] = Input::get('cat');
}
else
{
    $this->data = DB\Shop\product::select( array_keys( $this->data ) , array( 'id' => $this->id ) )->row();
    if ( empty( $this->data ) )
    {
        _Error::render( _Error::NOT_FOUND );
    }
    
    if ( !empty( $_POST ) )
    {
        Session::check( 'post' );
        $_POST['field']['navi_edition'] = isset( $_POST['field']['navi_edition'] );
        $_POST['field']['new'] = isset( $_POST['field']['new'] );
        $this->result = DB\Shop\product::update_row( Input::post( 'field' ), array( 'id' => $this->id ) );
    }

    $this->data = Helper::redeclare_array($this->data , Input::post('field') );
}
