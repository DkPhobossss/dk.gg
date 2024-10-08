<?php

$this->args('id');

$data = array('url', 'image', 'priority' , 'new' );
$this->result = null; 


if ( !empty( $_POST ) )
{
    Session::check( 'post' );
    
    $_POST['field']['new'] = isset( $_POST['field']['new'] );
    $this->result = DB\Shop\cat::update_row( Input::post( 'field' ), array( 'id' => $this->id ) );
}

$this->cat = DB\Shop\cat::select( $data , array( 'id' => $this->id ) )->row();

if ( empty( $this->cat ) )
{
    _Error::render( _Error::NOT_FOUND );
}