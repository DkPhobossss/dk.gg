<?php
//edits lang classes 
$this->result = null;
$this->args( 'base_class' , 'lang_class' , 'id' , 'uniq_field' , 'admin_global_url' ,   'wysywyg_path' );

$base_class = $this->base_class;
$lang_class = $this->lang_class;


$this->lang_id =key( $lang_class::$fields );//select[0] - id field

$this->data = array_fill_keys( array_keys ( 
        array_filter ( $lang_class::$fields , function ( $value ) {
            return !isset( $value['disable_update'] );
        } )
    )   , '' );

$this->info = DB::exec('SELECT
                                    ' . ( isset( $this->uniq_field ) ? ( '`' . $this->uniq_field . '` AS `uniq_field` , ' ) : '' ) . ' `id` , `' . $this->lang_id . '` AS `lang_id` , ' . implode( ' , ' , array_keys( $this->data )  ) . '
                                FROM `' . $base_class::$table_name . '`
                                LEFT JOIN `' . $lang_class::$table_name .'` ON 
                                    `' . $lang_class::$table_name . '`.`' . $this->lang_id . '` = `' . $base_class::$table_name . '`.`id` 
                                    AND 
                                    `lang` = %s
                                WHERE `id` = %s' , Localka::$lang , $this->id )->row();

if ( empty( $this->info ) )
{
    _Error::render( _Error::NOT_FOUND );
}

$this->uniq_field_value = isset( $this->info['uniq_field'] ) ? $this->info['uniq_field'] : null;

if ( !is_null( $this->info[ 'lang_id'] ) )//UPDATE
{
    if ( !empty( $_POST ) )
    {
        Session::check( 'post' );
        $this->result = $lang_class::update_row( Input::post( 'field' ), array( $this->lang_id => $this->info['id'], 'lang' => Localka::$lang ) );

        /*if ( $this->result )
        {
            Cache::clear_language( DB\Employers::$table_name  );
        }*/
    }

    $this->data = Helper::redeclare_array( $this->data , $this->info , Input::post('field' , array() ) );
}
else
{
    if ( !empty( $_POST ) )
    {
        Session::check( 'post' );

        $_POST['field'][ $this->lang_id ] = $this->info['id'];
        $_POST['field']['lang'] = Localka::$lang;

        if ( ( $id = $lang_class::insert_row( Input::post( 'field' ) ) ) )
        {
            //Cache::clear_language( DB\Employers::$table_name  );
            Page::go_back();
        }
    }
}
