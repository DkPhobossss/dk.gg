<?php

if ( Input::get('lang') )
{
    Auth::set_order_lang( Input::get('lang') );
}

$this->order = Auth::order();
if ( isset( $_POST['recalculate'] ) && !empty( $this->order ) )
{
    foreach ( $this->order as $model_id => &$row )
    {
        if ( isset( $_POST['remove'][$model_id] ) )
        {
            unset( $this->order[ $model_id ] );
        }
        else
        {
            $count = empty( $_POST['model'][ $model_id ] ) ? 0 : intval( $_POST['model'][ $model_id ] );
            if ( $count <= 0  )
            {
                unset( $this->order[ $model_id ] );
            }
            else
            {
                $row['count'] = $count;
            }
        }
    }
    unset( $row );
    
    Session::set( 'order' , $this->order );
    
}

if ( !empty( $this->order ) )
{
    $ids = array();
    foreach ( $this->order as $row )
    {
        $ids[ $row['product_id'] ] = true;
    }
    $this->product_data = DB\Shop\product::get_order( array_keys( $ids ) );
}

$this->order_lang = Auth::get_order_lang();