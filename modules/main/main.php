<?php

$this->args( 'submodule' );


/*
 * $this->submodules = 'string'; || 
 * $this->submodules = array('module' , array() , 'module' ); array - arg
 */


if ( !isset( $this->submodule ) )
{
    $this->banners = array();
    
    $this->submodule = 'static_page/root';


    $this->short_news = array();
}
else
{

}

