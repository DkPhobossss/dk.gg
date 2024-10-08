<? Auth::check_access( 60 ) ?>
<?= $this->module( 'page', $this->module( 'main', Config::adminKA . '/db/delete/',
    '' , 
    DB\Read\Askpro::$table_name , 'id' , Input::get('id') ) 
);?>