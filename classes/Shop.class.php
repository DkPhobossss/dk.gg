<?php

class Shop
{
    CONST SPEND_GOLD = 'spend_gold';
    CONST GEAR = 'professional_gaming_gear';
    CONST NAVI = 'navi_edition';
    CONST CHANGE_NICKNAME_PRICE = 20;
    
    /**
     * 
     * @return array() - system array for frontend index page
     */
    public static function sections_index( $key = null, $key2 = null )
    {
        static $data = null;
        
        if ( !isset( $data ) )
        $data = array(
            self::NAVI      => array(
                'url' => 'http://shop.navi-gaming.com/' . Localka::$lang_main ,
                'name' => __('Natus Vincere Edition') ,
                'class' => 'navi_products'
            ) , 
            self::GEAR      => array(
                'url' => 'http://shop.navi-gaming.com/' . Localka::$lang_url  . self::GEAR ,
                'name' => __('Professional Gaming Gear') ,
                'class' => 'gear'
            ) , 
            self::SPEND_GOLD => array(
                'url' => 'http://shop.navi-gaming.com/' . Localka::$lang_url  . self::SPEND_GOLD ,
                'name' => '<span class="gold_16"></span>' .  __('Spend GOLD') ,
                '_name' =>   __('Spend GOLD') ,
                'class' => 'spend_gold'
            ) , 
        );
        
        return isset( $key ) ? ( isset( $key2 ) ? $data[ $key ][ $key2 ] 
                                                : $data[ $key ] ) 
                            : $data ;
    }
    
    
    public static function spend_gold_cats( $key = null, $key2 = null )
    {
        static $data = null;
        
        if ( !isset( $data ) )
        $data = array(
            'lottery' => array( 
                'name' => __('Lottery and Autcion') ,
                'url' => 'http://shop.navi-gaming.com/' . Localka::$lang_url  . self::SPEND_GOLD . '/lottery',
                'image' => 'http://s.navi-gaming.com/uploads/userfiles/images/shop/86_86/system/loto.png',
                'seo_title' => __('seo_title_shop_spend_gold_lottery'),
                'seo_description' => __('seo_description_shop_spend_gold_lottery'),
                'seo_keywords' => __('seo_keywords_shop_spend_gold_lottery'),
              ) ,
            'awards' => array( 
                'name' => __('Awards') ,
                'url' => 'http://shop.navi-gaming.com/' . Localka::$lang_url  . self::SPEND_GOLD . '/awards',
                'image' => 'http://s.navi-gaming.com/uploads/userfiles/images/shop/86_86/system/awards.png',
                'seo_title' => __('seo_title_shop_spend_gold_awards'),
                'seo_description' => __('seo_description_shop_spend_gold_awards'),
                'seo_keywords' => __('seo_keywords_shop_spend_gold_awards'),
            ) ,
            'change_nickname' => array( 
                'name' => __('Change Nickname') ,
                'url' => 'http://shop.navi-gaming.com/' . Localka::$lang_url  . self::SPEND_GOLD . '/change_nickname',
                'image' => 'http://s.navi-gaming.com/uploads/userfiles/images/shop/86_86/system/change.png',
                'seo_title' => __('seo_title_shop_spend_gold_change_nickname'),
                'seo_description' => __('seo_description_shop_spend_gold_change_nickname'),
                'seo_keywords' => __('seo_keywords_shop_spend_gold_change_nickname'),
            ) ,
            'premium' => array( 
                'name' => __('Premium') ,
                'url' => 'http://shop.navi-gaming.com/' . Localka::$lang_url  . self::SPEND_GOLD . '/premium',
                'image' => 'http://s.navi-gaming.com/uploads/userfiles/images/shop/86_86/system/premium.png',
                'seo_title' => __('seo_title_shop_spend_gold_premium'),
                'seo_description' => __('seo_description_shop_spend_gold_premium'),
                'seo_keywords' => __('seo_keywords_shop_spend_gold_premium'),
                'disabled' => true
            ) ,
            'buy_gold' => array( 
                'name' => __('Buy GOLD') ,
                'url' => 'http://shop.navi-gaming.com/' . Localka::$lang_url  . self::SPEND_GOLD . '/buy_gold',
                'image' => 'http://s.navi-gaming.com/uploads/userfiles/images/shop/86_86/system/gold.png',
                'seo_title' => __('seo_title_shop_spend_gold_buy_gold'),
                'seo_description' => __('seo_description_shop_spend_gold_buy_gold'),
                'seo_keywords' => __('seo_keywords_shop_spend_gold_buy_gold'),
                'disabled' => true
            ) ,
        );
        
        return isset( $key ) ? ( isset( $key2 ) ? $data[ $key ][ $key2 ] 
                                                : $data[ $key ] ) 
                            : $data ;
    }
    
    public static function spend_gold_cats_values()
    {
        return array_values( self::spend_gold_cats() );
    }
    
    
    public static function sync_zona51()
    {
        $action = 'zona51 product sync';
        $timeout = 4000;
        $currency = 'UAH';
        $url = 'http://www.3ona51.com/ru/pricelist-partner-8.xml';
        
        return self::sync_yml( $action, $url, $timeout, $currency, array( 'offers' , 'offer' ) , 'zona_id' );
    }
    
    
    public static function sync_fucken_pro()
    {
        $action = 'fucken_pro product sync';
        $timeout = 12000;
        $currency = 'RUR';
        $url = 'http://fucken.pro/sites/default/files/yml/yml.xml';
        
        return self::sync_yml( $action, $url, $timeout, $currency, array( 'shop', 'offers' , 'offer' ) , 'fucken_pro_id' );
    }
    
    
    private static function sync_yml( $action , $url , $timeout, $currency, array $offer_key, $shop_id_field_name )
    {
        DB\Cron::log($action, 'start' );
        
        $data = CURL::url_get_contents( $url , $timeout );
        if ( empty ( $data ) )
        {
            DB\Cron::log($action, 'data empty, timeout ' . $timeout );
            return false;
        }

        if ( ( $data = simplexml_load_string( $data ) ) === FALSE ) 
        {
            DB\Cron::log($action, 'data empty, cant parse XML.' . print_r( $data , true ) );
            return false;
        }
        
        foreach( $offer_key as $value )
        {
            $data = $data->{$value};
        }
        
        if ( empty( $data ) )
        {
            DB\Cron::log($action, 'data empty invalid XML key.' . print_r( $data , true ) );
            return false;
        }

        
        $products = DB::exec("SELECT 
                            `$shop_id_field_name` AS `shop_id` , `id`, `price_$currency` AS `price`
                            FROM `shop_product`
                            WHERE `$shop_id_field_name` IS NOT NULL")->rows('shop_id');
        

        $buffer = array();
        foreach ( $data as $row )
        {
            $product_id = (int) $row->attributes()->id;
            $price = (int) $row->price;
            $t_currency = (string) $row->currencyId; 

            if ( array_key_exists( $product_id, $products ) && ( $t_currency == $currency ) && $products[ $product_id ]['price'] != $price )
            {
                $buffer[ $products[ $product_id ]['id'] ] = $price;
            }
        }

        
        $affected_rows = 0;
        foreach ( $buffer as $product_id => $price )
        {
            $affected_rows += DB\Shop\product::update ( array( 'price_' . $currency => $price ), array('id' => $product_id ) );
        }
        
        DB\Cron::log($action, 
            "Finish.\r\n" .
            "count: " . count( $products ) . "\r\n" .
            "need update: " . count( $buffer ) . "\r\n" .
            "updated: $affected_rows (" . implode( ',' , array_keys( $buffer ) )  . ")" 
        );
        return true;
        
        /*
         * UPDATE
            `shop_product` 
            SET `price_UAH` = 0
            WHERE `zona_id` IS NOT NULL;
            UPDATE
            `shop_product` 
            SET `price_RUR` = 0
            WHERE `fucken_pro_id` IS NOT NULL;
         */
    }
}