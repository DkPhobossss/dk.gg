<? Auth::check_access() ?>
<?= $this->module( 'page', $this->module( 'main', Config::adminKA . '/db/delete/', 
    null , DB\Shop\Banners::$table_name , 'id' , Input::get('id')  ) );?>