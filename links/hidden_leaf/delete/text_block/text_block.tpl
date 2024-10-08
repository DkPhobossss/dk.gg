<? Auth::check_access(  ) ?>
<?= $this->module( 'page', $this->module( 'main', Config::adminKA . '/db/delete/',
    '' ,
    DB\Text_blocks::$table_name , 'id' , Input::get('id'),
    DB\Text_blocks_data::$table_name , 'text_block_id' , 'block_id' )
);?>