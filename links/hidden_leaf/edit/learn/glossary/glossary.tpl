<?php
Auth::check_access( Auth::WIKI );

if ( Input::get('data') )
{
    echo $this->module( 'page', $this->module( 'main/' . Config::adminKA,  Config::adminKA . '/db/edit_data',  'DB\Learn\Glossary', 'DB\Learn\Glossary_data', Input::get( 'id' ) , 'id' , 'edit/learn/glossary?' ) );
}
else
{
    if ( isset( $_POST['field'] ) )
    {
        $_POST['field']['creator_id'] = Auth::id();
    }
    echo $this->module( 'page', $this->module( 'main/' . Config::adminKA ,  Config::adminKA . '/db/edit_global',  true , 'DB\Learn\Glossary',  Input::get( 'id' ) , 'text_block_id' , 'edit/learn/glossary?' , 'edit/learn/glossary?data=true&' ) );
}