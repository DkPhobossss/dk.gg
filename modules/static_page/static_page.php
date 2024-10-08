<?php
$this->args('name' , 'no_seo');

if ( !isset( $this->no_seo ) )
{
    $this->page = DB\Pages_static::select( array(
        'title' ,
        'seo_title' ,
        'seo_description' ,
        'seo_keywords' ,
        'content' ,
    ) , array( 'name' => $this->name , 'lang' => Localka::$lang ) )->row();
}
else
{
    $this->page = DB\Pages_static::select( array(
        'title' ,
        'content' ,
    ) , array( 'name' => $this->name , 'lang' => Localka::$lang ) )->row();
}


if ( empty( $this->page ) )
{
    _Error::render( _Error::NOT_FOUND );
}