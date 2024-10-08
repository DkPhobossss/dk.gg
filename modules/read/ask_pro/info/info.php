<?php
$this->args( 'cats' , 'cat_id' );

$this->seo = array( 'seo_title' =>  $this->cats[ $this->cat_id ]['name'] , 
    'seo_description' => strip_tags( $this->cats[ $this->cat_id ]['info'] ) , 
    'seo_keywords' => null );