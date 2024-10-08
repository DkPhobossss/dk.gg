<? Auth::check_access(  ) ?>
<?= $this->module( 'page', $this->module( 'main', Config::adminKA . '/db/delete/',
    '' , 
    DB\Video::$table_name , 'id' , Input::get('id'),
    DB\Video_data::$table_name , 'video_id' , 'id' )
);?>