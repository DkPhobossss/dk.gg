<?php

$this->args('mode' , 'role_id');


$this->role = DB\DOTA_2\Heroes_role::get_by_role_id( intval( $this->role_id ) );
if ( empty( $this->role ) )
{
    _Error::render( _Error::NOT_FOUND );
}


if ( $this->mode == 'ally' )
{

}
else
{

}