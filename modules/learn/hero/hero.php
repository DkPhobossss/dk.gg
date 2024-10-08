<?php
$this->args('hero_url');

$this->data = DB\DOTA_2\Heroes::get_hero_data( $this->hero_url );

if ( empty( $this->data ) )
{
    _Error::render( _Error::NOT_FOUND );
}

$this->talents = DB\DOTA_2\Heroes_talent::get_by_hero_id( $this->data['id'] );

$this->access = Auth::rule( );

$this->roles = DB\DOTA_2\Heroes_role::get_by_hero_id( intval( $this->data['id'] ) , $this->access );
if ( isset( $_GET['role' ] ) )
{
    $this->role = intval( $_GET['role'] );
    if ( !isset( $this->roles[ $this->role ] ) || ( $this->roles[ $this->role ]['visible'] != 1 && !Auth::rule( Auth::EDITOR )   )  )
    {
        _Error::render( _Error::NOT_FOUND );
    }
}


$this->roles_description = \DOTA_2\Hero::roles();

$this->macrotasks = DB\DOTA_2\Heroes_macrotask::DATA( true );

$this->abilities = DB\DOTA_2\Heroes_abilities::get_by_hero_id( intval( $this->data['id'] ) );

$this->aghanim = DB\DOTA_2\Heroes_aghanim::select( array('ability_id' , 'effect') , array('lang' => Localka::$lang, 'hero_id' => $this->data['id'] ) )->rows();
