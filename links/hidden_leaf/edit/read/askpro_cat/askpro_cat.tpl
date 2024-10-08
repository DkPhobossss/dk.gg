<?php 
Auth::check_access( 60 );

if ( Input::get('data') )
{
    echo $this->module( 'page', $this->module( 'main', Config::adminKA . '/db/edit_data',  'DB\Read\Askpro_cat', 'DB\Read\Askpro_cat_data', Input::get( 'id' ) , 'name' , 'edit/read/askpro_cat?' , 'Images:/askpro_cat/' ) );
}
else
{
    echo $this->module( 'page', $this->module( 'main', Config::adminKA . '/db/edit_global',  true , 'DB\Read\Askpro_cat',  Input::get( 'id' ) , 'email' , 'edit/read/askpro_cat?' , 'edit/read/askpro_cat?data=true&' ) );
}