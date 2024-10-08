<?php
if ( Input::post('words' ) && is_array( Input::post('words' )) )
{
    Session::check('post');
    
    foreach ( Input::post('words' ) as $key => $value )
    {
        $this->result += DB\Word::update( array('value' => $value ), array('id' => $key , 'lang' => Localka::$lang ) );
    }
}

$this->words = DB\Word::select( array( 'id' , 'value' ) , array( 'lang' => Localka::$lang ) , array('id' , 'ASC') )->rows();