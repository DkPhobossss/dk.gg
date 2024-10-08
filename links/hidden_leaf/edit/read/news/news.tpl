<?php 
Auth::check_access( 'DB\Rules::$READ_NEWS[Localka::$lang]' );

if ( Input::get('data') )
{
    echo $this->module( 'page', $this->module( 'main', Config::adminKA . '/db/edit_data',  'DB\Read\news', 'DB\Read\news_data', Input::get( 'id' ) , 'title' , 'edit/read/news?' , 'Images:/news/' ) );
}
else
{
    if ( isset( $_POST['field'] ) )
    {
        $_POST['field']['creator_id'] = Auth::id();
    }
    echo $this->module( 'page', $this->module( 'main', Config::adminKA . '/db/edit_global',  true , 'DB\Read\news',  Input::get( 'id' ) , 'url' , 'edit/read/news?' , 'edit/read/news?data=true&' ) );
}