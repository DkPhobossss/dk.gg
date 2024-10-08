<?php

if ( Input::get('update_heroes_stats'))
{
    Auth::check_access(  );
    Session::check('get');

    DOTA_2\Hero::update_all_stats();
    Page::go_back();
}
elseif( Input::get('update_hero_talents') )
{
    Auth::check_access(  );
    Session::check('get');

    DOTA_2\Hero::update_talents( );

    Page::go_back();
}
elseif( Input::get('update_hero_aghanims') )
{
    Auth::check_access(  );
    Session::check('get');

    DOTA_2\Hero::update_aghanims(  );

    Page::go_back();
}
elseif( Input::get('update_hero_stats') )
{
    Auth::check_access(  );
    Session::check('get');

    DOTA_2\Hero::update_stats( Input::get('id') , Input::get('name') , Input::get('description') );

    Page::go_back();
}
elseif ( Input::get('talent') )
{
    Auth::check_access( Auth::EDITOR );

    $lvl = intval( Input::get('lvl') );
    if ( !in_array( $lvl, DB\DOTA_2\Heroes_talent::$lvls ) )
    {
        $lvl = DB\DOTA_2\Heroes_talent::$lvls[0];
    }

    echo $this->module( 'page', $this->module( 'main/' . Config::adminKA ,  Config::adminKA . '/db/edit_global',  false , 'DB\DOTA_2\Heroes_talent',  Input::get( 'id' ) , 'hero_id' , null, null, null, true, array('lvl' => $lvl ) ) );
}
elseif ( Input::get('aghanim') )
{
    Auth::check_access( Auth::EDITOR );
    echo $this->module( 'page', $this->module( 'main/' . Config::adminKA ,  Config::adminKA . '/db/edit_global',  false , 'DB\DOTA_2\Heroes_aghanim',  Input::get( 'id' ) , 'hero_id' , null, null, null, true ) );
}
elseif( Input::get('add_role'))
{
    if ( isset( $_GET['visible'] ) )
    {
        Auth::check_access(  );
        Session::check('get');
        $visible = intval( $_GET['visible'] );
        if ( $visible )
        {
            DB\DOTA_2\Heroes_role::update( array('visible' => 1 ) , array('id' => Input::get('id') ) );
        }
        else
        {
            DB\DOTA_2\Heroes_role::update( array('visible' => 0, 'disabled' =>1  ) , array('id' => Input::get('id') ) );
        }
        Page::go_back();
    }
    elseif ( Input::get('data') )
    {
        Auth::check_access( Auth::EDITOR );
        echo $this->module( 'page', $this->module( 'main/' . Config::adminKA,  Config::adminKA . '/db/edit_data',  'DB\DOTA_2\Heroes_role', 'DB\DOTA_2\Heroes_role_data', Input::get( 'id' ) , 'id' , 'edit/learn/hero?add_role=true&' ) );
    }
    else
    {
        Auth::check_access(  );
        if ( !Input::get('id') )
        {
            DB\DOTA_2\Heroes_role::$fields['hero_id']['length'] = \DB\DOTA_2\Heroes::select( array('id' , 'name'), null, array('name', 'ASC') )->rows('name' , 'id');
        }
        echo $this->module( 'page', $this->module( 'main/' . Config::adminKA ,  Config::adminKA . '/db/edit_global',  true , 'DB\DOTA_2\Heroes_role',  Input::get( 'id' ) , 'id', 'edit/learn/hero?add_role=true&' , 'edit/learn/hero?&add_role=true&data=true&'  ) );
    }


}
elseif( Input::get('edit_allies') )
{
    Auth::check_access(  );
    echo $this->module( 'page', $this->module( 'main/' . Config::adminKA,  Config::adminKA . '/learn/hero_role',  'ally', Input::get('id') ) );
}
elseif( Input::get('edit_enemies') )
{
    Auth::check_access( );
    echo $this->module( 'page', $this->module( 'main/' . Config::adminKA,  Config::adminKA . '/learn/hero_role',  'enemy', Input::get('id') ) );
}
else
{
    Auth::check_access( Auth::EDITOR );
    echo $this->module( 'page', $this->module( 'main/' . Config::adminKA,  Config::adminKA . '/db/edit_data',  'DB\DOTA_2\Heroes', 'DB\DOTA_2\Heroes_data', Input::get( 'id' ) , 'id' , null ) );
}