<? Auth::check_access(  ) ?>
<?= $this->module( 'page', $this->module( 'main', Config::adminKA . '/db/delete/',
    '' , 
    DB\Read\Askpro_cat::$table_name , 'id' , Input::get('id'), 
    DB\Read\Askpro_cat_data::$table_name , 'cat_id' , 'id' ) 
);?>