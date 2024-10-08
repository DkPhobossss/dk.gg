<?php
$this->args( 'gallery_id' , 'gallery_url', 'data' , 'width' , 'access' );

if ( !isset( $this->width) )
{
    $this->width = 824;
}
