<?php
$this->args('letter');

$this->access = Auth::rule(Auth::WIKI);
$this->data = DB\Learn\Glossary::get_letter_data( $this->letter, $this->access );

if ( empty ( $this->data ) )
{
    _Error::render( _Error::NOT_FOUND );
}

$this->alphabet = DB\Learn\Glossary::get_alphabet();


