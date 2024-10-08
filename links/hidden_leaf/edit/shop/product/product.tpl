<? 
Auth::check_access( ); 
if ( Input::get( 'data' ) )
{
    echo $this->module( 'page', $this->module( 'main', Config::adminKA . '/db/edit_data',  'DB\Shop\product', 'DB\Shop\product_data', Input::get( 'id' ) , 'name' , 'edit/shop/product?' ) );
}
else
{
    //global edit
    DB\Shop\product::$fields['cat_id']['length'] = DB\Shop\cat::select( array('id' , 'url') , false , array('priority' , 'DESC') )->rows( 'url' , 'id');
    echo $this->module( 'page', $this->module( 'main', Config::adminKA . '/db/edit_global', true , 'DB\Shop\product',  Input::get( 'id' ) , 'url' , 'edit/shop/product?' , 'edit/shop/product?data=true&' ) );
}

