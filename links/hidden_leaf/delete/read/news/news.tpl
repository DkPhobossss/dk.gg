<? Auth::check_access(  ) ?>
<?= $this->module( 'page', $this->module( 'main', Config::adminKA . '/db/delete/',
    '' , 
    DB\Read\news::$table_name , 'id' , Input::get('id'), 
    DB\Read\news_data::$table_name , 'news_id' , 'id' ) 
);?>