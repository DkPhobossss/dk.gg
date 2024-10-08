<?

Auth::check_access( );
echo $this->module( 'page', $this->module( 'main', Config::adminKA . '/db/edit_global', true, 'DB\Shop\Banners',  Input::get( 'id' ) , 'name' , 'edit/shop/banner?' , null ) );