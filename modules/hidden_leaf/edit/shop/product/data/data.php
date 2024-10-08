<?php

$this->args('id');
$this->data = array(
    'name' => '',
    'seo_title' => '',
    'seo_description' => '',
    'seo_keywords' => '',
    'preview' => '',
    'content' => '',
);


$this->product = DB::exec(
    'SELECT `url` , `id` , product_id ,
    ' . implode( ',' , array_keys( $this->data ) ) . '    
    FROM `shop_product` 
    LEFT JOIN `shop_product_data` ON
        `shop_product_data`.`product_id` = `shop_product`.`id` AND `shop_product_data`.`lang` = %s
    WHERE `id` = %d' , Localka::$lang , $this->id )->row();

if ( empty( $this->product ) )
{
    _Error::render( _Error::NOT_FOUND );
}


$this->result = null;
if ( isset($this->product['product_id']) )
{
    $this->action = 'update';
}
else
{
    $this->action = 'insert';
}



if ( $this->action == 'update' )
{
    if ( !empty( $_POST ) )
    {
        Session::check( 'post' );
        $_POST['filed']['date_up'] = 'CURRENT_TIMESTAMP';
        $_POST['field']['editor_id'] = Auth::id();
        $this->result = DB\Shop\product_data::update_row( Input::post( 'field' ), array( 'product_id' => $this->id, 'lang' => Localka::$lang ) );
        
        if ( !(empty( $_POST['field']['name'] ) ) )
        {
            \DB\Shop\product_related::insert_words( $this->id , Localka::$lang , $_POST['field']['name'] );
        }
    }

    $this->data = Helper::redeclare_array( $this->data , $this->product , Input::post('field' , array() ) );
}
else
{
    if ( !empty( $_POST ) )
    {
        Session::check( 'post' );
        
        $_POST['field']['product_id'] = $this->product['id'];
        $_POST['field']['lang'] = Localka::$lang;

        if ( DB\Shop\product_data::insert_row( Input::post( 'field' ) ) )
        {
            if ( !(empty( $_POST['field']['name'] ) ) )
            {
                \DB\Shop\product_related::insert_words( $this->id , Localka::$lang , $_POST['field']['name'] );
            }
            Page::go_back();
        }
    }
}
