<?php

$this->order = Auth::order();

if ( empty( $this->order ) )
{
    Page::_301( '/basket' );
}

DB\Shop\Order::init_check();


if ( !empty( $_POST['field'] ) )
{
    $_POST['field']['ip'] = Auth::ip();
    $_POST['field']['lang'] = Auth::get_order_lang();
    
    try
    {
        DB::transaction();
        
        $this->result = DB\Shop\Order::insert_row( $_POST['field']  );
        
        $sum = 0;
        foreach ( $this->order as $row )
        {
            DB::insert( 'order_info' , array(
                'order_id'      => $this->result,
                'product_id'    => $row['product_id'],
                'product_name'    => $row['article'] . ' => ' . $row['model'],
                'product_price'    => $row['price_' . Auth::currency( $_POST['field']['lang'] ) ],
                'product_count'    => $row['count'],
            ) );
            $sum += $row['price_' . Auth::currency( $_POST['field']['lang'] ) ] * $row['count'];
        }
        
        DB\Shop\Order::update( array('price' => $sum ) , array('id' => $this->result ) );
        
        Email::order( $_POST['field']['email'] , $_POST['field']['name'] , $_POST['field']['ip'],  $this->result , $this->order, Auth::currency( $_POST['field']['lang'] )  );
        
        Auth::delete_order();
 
        DB::commit();
    }
    catch ( \Exception\User $e )
    {
        DB::rollback();
        throw new \Exception\User( $e->getErrors() );
    }
    catch ( \Exception $e )
    {
        DB::rollback();
        throw new \Exception\Fatal( $e->getMessage() );
    }
}

$this->fields = array_fill_keys( array_keys ( 
    array_filter ( DB\Shop\Order::$fields , function ( $value ) {
        return !isset( $value['disable_update'] );
    } )
)   , '' );
