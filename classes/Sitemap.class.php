<?php
class Sitemap
{
    public static $data = array();

    public static function branch( $url )
    {
        return self::$data[ $url ];
    }
}

Sitemap::$data = array(
    '' => array(
        'text' => __('Root'),
    ),
    'learn' => array(
        'text' => __('Learn'),
        'items' => array(
            'heroes' => array(
                'text' =>  __('Heroes_list')
            ),
            'glossarij' => array(
                'text' => __('Glossary'),
            ),
            'draft' => array(
                'text' => __('Draft:title'),
            ),
            'school' => array(
                'text' => __('Learn_School')
            ),
        )
    ),
    'digitize' => array(
        'text' => __('Digitize')
    ),
    'heroes' => __('Heroes'),
    'watch' => __( 'Watch' ),
    'read'=> array(
        'text' => __('Read'),
        'items' => array(

        )
    ),
);