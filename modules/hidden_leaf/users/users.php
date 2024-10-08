<?php

$this->show = 40;
$this->current_page = intval( Input::get( 'page', 1 ) );

if ( $this->current_page < 1 )
{
    _Error::render( _Error::NOT_FOUND );
}

$this->fields = array(
    'id_member' => array(
        'text' => 'ID',
        'width' => 55,
        'order' => 'ASC',
    ),
    'member_name' => array(
        'text' => __( 'User name' ),
        'width' => 250,
        'order' => 'DESC'
    ),
    'group_id' => array(
        'text' => __( 'Group' ),
        'width' => 110,
        'order' => 'ASC'
    ),
    'gold' => array(
        'text' => 'GOLD',
        'width' => 80,
        'order' => 'DESC'
    ),
    'registered_source' => array(
        'text' => __( 'Source' ),
        'width' => 80,
        'order' => 'DESC'
    ),
    'soc_network' => array(
        'text' => __( 'Social Network' ),
        'width' => 140,
        'order' => 'DESC'
    ),
    'date_registered' => array(
        'text' => __( 'Registered' ),
        'width' => 110,
    ),
);

if ( !array_key_exists( $field = ( Input::get( 'field', 'id_member' ) ), $this->fields ) )
{
    $field = 'id_member';
}


$this->fields[ $field ][ 'selected' ] = true;
$this->fields[ $field ][ 'order' ] = ( $order = Input::get('order') == 'ASC' ? 'ASC' : ( Input::get('order') == 'DESC' ? 'DESC' : $this->fields[ $field ]['order'] )  );


$this->group_id = intval ( Input::get('group') );
$this->users = DB::exec( "SELECT SQL_CALC_FOUND_ROWS
                            `id_member` , `member_name` , `gold` , `date_registered` , `soc_network` , `registered_source` , 
                            `groups`.`name`  as `group` , `groups`.`id` as `group_id`
                        FROM `smf_members`
                        INNER JOIN `groups`
                        ON 
                            `groups`.`id` = `smf_members`.`group_id`"
                        . ( $this->group_id ? "WHERE group_id = $this->group_id"  : '')
                        . " ORDER BY `$field` $order 
                        LIMIT %d, %d", ( $this->current_page - 1 ) * $this->show, $this->show )->rows();

if ( empty( $this->users ) )
{
    _Error::render( _Error::NOT_FOUND );
}

$this->total = DB::get_found_rows();
$this->url = Page::admin( 'users?field=' . $field . ( $this->group_id ? "&group=$this->group_id" : '' ) . '&order=' . $order . '&page=' );

$this->pagination = $this->module( '/blocks/pagination', '', ceil( $this->total / $this->show ), $this->current_page, $this->url , false, 'list' );

$this->groups = DB\Group::select( array('id' , 'name') , array('id' => array( DB\Group::GUEST , '<>' ) ) )->rows();