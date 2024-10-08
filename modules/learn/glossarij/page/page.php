<?php
$this->args('page_name');

$this->access = Auth::rule( Auth::WIKI );

$this->data = DB\Learn\Glossary::get_word_data( $this->page_name , $this->access);

if ( empty( $this->data ) )
{
    _Error::render( _Error::NOT_FOUND );
}

DB\Learn\Glossary_data::update( array('views' => array('`views` + 1') ) , array('glossary_id' => $this->data['id'] , 'lang' => Localka::$lang ) );