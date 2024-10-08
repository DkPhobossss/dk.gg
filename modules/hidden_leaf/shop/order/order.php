<?php

$this->args('id');

$this->status = array(
    'new'       => 'Новый',
    'view'      => 'Принято',
    'accept'    => 'Выполняется',
    'decline'   => 'Отказано',
    'done'      => 'Заказ выполнен'
);

$this->data = DB\Shop\Order::select( '*' , array( 'id' => $this->id ) )->row();

if ( empty( $this->data ) )
{
    _Error::render( _Error::NOT_FOUND );
}

$this->order = DB::exec('SELECT
            `order_info`.*,
            `shop_product`.`image_cart` as `image` , 
            CONCAT( `shop_cat`.`url` , "/" , `shop_product`.`url`) as `url`
        FROM 
            `order_info` 
        LEFT JOIN
            `shop_product` ON
                `shop_product`.`id` = `order_info`.`product_id`
        INNER JOIN 
            `shop_cat` ON 
                `shop_cat`.`id` = `shop_product`.`cat_id`
        WHERE 
            `order_info`.`order_id` = %s' , $this->data['id'] )->rows();

if ( Input::post('status') )
{
    DB\Shop\Order::update( array('status' => Input::post('status') ) , array( 'id' => $this->id ) );
    $this->data['status'] = Input::post('status');
}
elseif ( $this->data['status'] == 'new' )
{
    DB\Shop\Order::update( array('status' => 'view' ) , array( 'id' => $this->id ) );
    $this->data['status'] = 'view';
}

