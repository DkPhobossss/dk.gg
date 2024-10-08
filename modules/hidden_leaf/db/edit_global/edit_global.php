<?php
//edits lang classes 
$this->result = null;
$this->args( 'can_insert' , 'base_class' , 'id' , 'uniq_field' , 'admin_global_url' , 'admin_lang_url' ,   'wysywyg_path', 'uniq_field_is_id', 'extra_where' );

$base_class = $this->base_class;

if ( empty( $this->id ) ) // INSERT
{

    if ( empty( $this->can_insert ) )
    {
        _Error::render( _Error::USER, 'Can\'t insert' );
    }
    
    if ( !empty( $_POST ) )
    {
        Session::check( 'post' );
        
        if ( ($id = $base_class::insert_row( Input::post( 'field' ) ) ) )
        {
            Page::go( Page::admin( $this->admin_global_url . "id=$id" ) );
        }
    }

    $this->data = array_fill_keys( array_keys (
        array_filter ( $base_class::$fields , function ( $value ) {
            return ( !isset( $value['disable_update'] ) || !empty( $value['pseudo_primary'] ) );
        } )
    )   , '' );
    
    foreach ( $_GET as $key => $value )
    {
        if ( isset( $this->data[ $key ] ) )
        {
            $this->data[ $key ] = $value;
        }
    }
}
else
{
    $id = empty( $this->uniq_field_is_id ) ? 'id' : $this->uniq_field;
    $where_condition_array = empty( $this->extra_where ) ? array( $id => $this->id ) : array_merge( array( $id => $this->id ), $this->extra_where );

    
    if ( !empty( $_POST ) )
    {
        Session::check( 'post' );

        $this->result = $base_class::update_row( Input::post( 'field' ), $where_condition_array );
    }

    $this->data = $base_class::select( array_keys ( 
        array_filter ( $base_class::$fields , function ( $value ) {
            return !isset( $value['disable_update'] );
        } )
    ) , $where_condition_array )->row();

    if ( empty( $this->data ) )
    {
        _Error::render( _Error::NOT_FOUND );
    }
}
