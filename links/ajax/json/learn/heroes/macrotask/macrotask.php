<?php

Auth::check_access();

Session::check('get');

if ( empty( $_POST['role']) && !is_array( $_POST['role']) )
{
    _Error::render( _Error::NOT_FOUND );
}

$data = reset( $_POST['role']);
$role_id = key( $_POST['role'] );
if ( empty( $data ) && !is_array( $data) )
{
    _Error::render( _Error::NOT_FOUND );
}

$value = reset($data );
$macrotask = key( $data );

if ( !array_key_exists( $macrotask , DB\DOTA_2\Heroes_macrotask::DATA() ) )
{
    _Error::render( _Error::NOT_FOUND );
}

\DB\DOTA_2\Heroes_role::update( array( $macrotask => $value ) , array('id' => $role_id ) );

$this->response()->output();