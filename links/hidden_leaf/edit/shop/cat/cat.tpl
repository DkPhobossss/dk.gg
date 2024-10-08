<? Auth::check_access( '' ); 

if ( Input::get( 'data' ) )
{
    echo $this->module( 'page', $this->module( 'main', Config::adminKA . '/db/edit_data', 'DB\Shop\cat', 'DB\Shop\cat_data', Input::get( 'id' ) , 'name' , 'edit/shop/cat?' ) );
}
else
{
    //global edit
    echo $this->module( 'page', $this->module( 'main', Config::adminKA . '/db/edit_global', null , 'DB\Shop\cat',  Input::get( 'id' ) , 'url' , 'edit/shop/cat?' , 'edit/shop/cat?data=true&' ) );
}

