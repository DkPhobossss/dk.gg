<? Auth::check_access() ?>

<?= $this->module( 'page', $this->module( 'main', Config::adminKA . '/db/delete/', 
    null , 
    DB\Shop\product::$table_name , 'id' , Input::get('id') ,
    DB\Shop\product_data::$table_name, 'product_id' , 'id', 
    DB\Shop\model::$table_name , 'product_id' , 'id',
    DB\Shop\product_link::$table_name , 'product_id' , 'id') );?>