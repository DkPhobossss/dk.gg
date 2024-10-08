<?php
Auth::check_access();

if ( Input::get('icons'))
{
    //heroes
    $this->data = DB\DOTA_2\Heroes::select( array('name' , 'url'), null, array('name', 'ASC') )->rows();

    $s = 'CKEDITOR.config.dota_2_heroes_images = [';
    foreach ( $this->data as $row )
    {
       $s .= '"' . DOTA_2\Hero::icon( $row['url'] ) . '" ,';
    }
    $s = mb_substr( $s , 0, -2 );
    $s .= '];';

    $s .= '</br></br>';

    $s .= 'CKEDITOR.config.dota_2_heroes_descriptions = [';
    foreach ( $this->data as $row )
    {
        $s .= '"' . $row['name'] . '" ,';
    }
    $s = mb_substr( $s , 0, -2 );
    $s .= '];';

    $s .= '</br></br>';


    //items
    $this->data = DB\DOTA_2\Item::select( array('name' , 'system_name'), array('recipe' => array( 0 )), array('name', 'ASC') )->rows();

    $s .= 'CKEDITOR.config.dota_2_items_images = [';
    foreach ( $this->data as $row )
    {
        $s .= '"' . DOTA_2\Item::icon( $row['system_name'] ) . '" ,';
    }
    $s = mb_substr( $s , 0, -2 );
    $s .= '];';

    $s .= '</br></br>';

    $s .= 'CKEDITOR.config.dota_2_items_descriptions = [';
    foreach ( $this->data as $row )
    {
        $s .= '"' . $row['name'] . '" ,';
    }
    $s = mb_substr( $s , 0, -2 );
    $s .= '];';

    $s .= '</br></br>';


    //skills
    $this->data = DB\DOTA_2\Abilities::select( array('name' , 'img'), array( 'hero_id' => array( null , 'IS NOT') ), array('system_name', 'ASC') )->rows();

    $s .= 'CKEDITOR.config.dota_2_skills_images = [';
    foreach ( $this->data as $row )
    {
        $s .= '"' .  $row['img']  . '" ,';
    }
    $s = mb_substr( $s , 0, -2 );
    $s .= '];';

    $s .= '</br></br>';

    $s .= 'CKEDITOR.config.dota_2_skills_descriptions = [';
    foreach ( $this->data as $row )
    {
        $s .= '"' . $row['name'] . '" ,';
    }
    $s = mb_substr( $s , 0, -2 );
    $s .= '];';

    $s .= '</br></br>';
    echo $s;
}
