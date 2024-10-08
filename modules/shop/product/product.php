<?php

$this->args( 'cat_url' , 'product_url' );

$this->cats = DB\Shop\cat::get();
if ( !array_key_exists( $this->cat_url, $this->cats ) )
{
    _Error::render( _Error::NOT_FOUND );
}

$this->data = DB::exec('SELECT 
            `shop_product`.`id` , `shop_product`.`image_text`,
            `shop_product`.`image_large_1`, `shop_product`.`image_large_2` , `shop_product`.`image_large_3`, `shop_product`.`image_large_4`,
            `shop_product`.`image_large_5`, `shop_product`.`image_large_6` , `shop_product`.`image_large_7`, `shop_product`.`image_large_8`,
            `shop_product`.`image_large_9`, `shop_product`.`image_large_10`,
            `shop_product`.`image_preview_product`, `shop_product`.`image_source`,
            `shop_product_data`.`name`, `shop_product_data`.`content`, `shop_product_data`.`views`,
            `shop_product_data`.`seo_title`,`shop_product_data`.`seo_description`,`shop_product_data`.`seo_keywords`
    FROM `shop_product`
    LEFT JOIN `shop_product_data` ON 
        `shop_product_data`.`product_id` = `shop_product`.`id` AND 
        `shop_product_data`.`lang` = %s
    WHERE 
        `cat_id` = %s AND
        `url` = %s' , Localka::$lang , $this->cats[ $this->cat_url ]['id'] , $this->product_url
)->row();

if ( empty( $this->data ) )
{
    _Error::render( _Error::NOT_FOUND );
}

DB\Shop\product_data::update( array('views' => array('`views` + 1') ) , array('product_id' => $this->data['id'] , 'lang' => Localka::$lang ) );


$this->models = DB\Shop\model::select( '*' , array('product_id' => $this->data['id'] ) )->rows();
$this->links = DB\Shop\product_link::select( '*' , array('product_id' => $this->data['id'] , 'lang' => Localka::$lang ) )->rows();