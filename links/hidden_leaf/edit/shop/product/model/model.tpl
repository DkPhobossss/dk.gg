<? 
Auth::check_access( ); 

DB\Shop\model::$fields['product_id']['length'] = DB\Shop\product::select( array('id' , 'url') , false , array('priority' , 'DESC') )->rows( 'url' , 'id');
echo $this->module( 'page', $this->module( 'main', Config::adminKA . '/db/edit_global', true , 'DB\Shop\model',  Input::get( 'id' ) , 'url' , 'edit/shop/product/model?' , null ) );


