<?php

$this->args( 'class' , 'total' , 'current' , 'href' , 'reverse' , 'anchor' , 'param_string' );
$this->show = 2;
$this->separator = '...';

if ( isset( $this->anchor ) )
{
    $this->anchor = '#' . $this->anchor;
}

if ( isset( $this->param_string ) )
{
    $this->param_string = '?' . $this->param_string;
}

//security purposes
$this->href = htmlspecialchars( $this->href );
$this->current = intval( $this->current );
$this->param_string = htmlspecialchars( $this->param_string );