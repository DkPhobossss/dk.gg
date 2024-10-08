<?php 
Auth::check_access( 'DB\Rules::$READ_NEWS[Localka::$lang]' );

if ( Input::get('data') )
{
    echo $this->module( 'page', $this->module( 'main', Config::adminKA . '/db/edit_data',  '\DB\Video', '\DB\Video_data', Input::get( 'id' ) , 'title' , 'edit/video?' , 'Images:/news/' ) );
}
else
{
    echo $this->module( 'page', $this->module( 'main', Config::adminKA . '/db/edit_global',  true , '\DB\Video',  Input::get( 'id' ) , 'url' , 'edit/video?' , 'edit/video?data=true&' ) );
}