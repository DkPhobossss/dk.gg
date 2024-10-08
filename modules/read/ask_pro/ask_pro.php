<?php

$this->access = Auth::rule( 60 );

$this->args('module' , 'arg1' , 'arg2');

$this->cats = DB::exec('SELECT
        `askpro_cat`.*,
        `askpro_cat_data`.`name`, `askpro_cat_data`.`info`
        FROM 
            `askpro_cat`
        LEFT JOIN 
            `askpro_cat_data` ON
                `askpro_cat_data`.`cat_id` = `askpro_cat`.`id` AND
                `askpro_cat_data`.`lang` = %s
        ORDER BY 
            `priority` DESC' , Localka::$lang )->rows('id');

if ( !$this->arg1 )
{
    if ( isset( Link::$url_parts[1]) && !isset( $this->cats[ Link::$url_parts[1] ]) )
    {
        _Error::render( _Error::NOT_FOUND );
    }
    $this->arg1 = $this->cats;
    $this->cat =  Link::$url_parts[1];
}
else
{
    $this->cat = null;
}
