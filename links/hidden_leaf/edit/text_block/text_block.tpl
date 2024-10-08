<?php
Auth::check_access(  );

if ( Input::get('data') )
{
    echo $this->module( 'page', $this->module( 'main', Config::adminKA . '/db/edit_data',  'DB\Text_blocks', 'DB\Text_blocks_data', Input::get( 'id' ) , 'id' , 'edit/text_block?' ) );
}
else
{
    echo $this->module( 'page', $this->module( 'main', Config::adminKA . '/db/edit_global',  true , 'DB\Text_blocks',  Input::get( 'id' ) , 'text_block_id' , 'edit/text_block?' , 'edit/text_block?data=true&' ) );
}