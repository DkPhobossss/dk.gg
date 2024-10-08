<?php
$arg = rawurldecode( Link::$url_parts[2] );

if ( empty ( $arg ) )
{
    Page::_301( 'learn/glossarij' );
}

if ( mb_strlen( $arg ) == 1 )
{
    echo $this->module( 'page', $this->module( 'main' ,'learn/glossarij/letter', $arg ) );
}
else
{
    echo $this->module( 'page', $this->module( 'main' , 'learn/glossarij/page', $arg ) );
}
