<?php

$this->args('name');
$this->result = null;

if ( isset ($_POST['field']) )
{
    $this->result = DB\Pages_static::update_row( $_POST['field'] , array( 'name' => $this->name , 'lang' => Localka::$lang ) );
}

$this->page = DB\Pages_static::select( array(
    'title' , 
    'seo_title' , 
    'seo_description' , 
    'seo_keywords' , 
    'content' ,
    ) , array( 'name' => $this->name , 'lang' => Localka::$lang ) )->row();