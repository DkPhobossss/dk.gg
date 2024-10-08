<?php 
Auth::check_access( 60 );

DB\Read\Askpro::init_check();
DB\Read\Askpro::$fields['cat_id']['length'] = DB\Read\Askpro_cat::select( array('id' , 'email') , null , array('id' , 'ASC') )->rows('email', 'id');


DB\Read\Askpro::$fields['answer'] = array( 
    'type' => 'html' , 
    'decorators' => 'trim' ,
    'length_min' => 10
);

DB\Read\Askpro::$fields['visible'] = array( 
    'type' => 'bool',
    'default' => 0,
);


echo $this->module( 'page', $this->module( 'main', Config::adminKA . '/db/edit_global',  true , 'DB\Read\Askpro',  Input::get( 'id' ) , 'id' , 'edit/read/askpro?' , null ) );
