<?php
if ( !DB\Learn\Glossary::exists( array('id' => Input::get('id'), 'system' => 0 ) ) )
{
    _Error::render( _Error::FORBIDDEN );
}
?>
<?= $this->module( 'page', $this->module( 'main', Config::adminKA . '/db/delete/',
    Auth::WIKI,
    DB\Learn\Glossary::$table_name , 'id' , Input::get('id'),
    DB\Learn\Glossary_data::$table_name , 'glossary_id' , 'id' )
);?>