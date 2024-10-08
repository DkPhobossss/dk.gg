<?php

if ( !Protector::check( Protector::ACTION_REFRESH_RANDOM_HERO_ROLES ) )
{
    $this->response()->errors( __('protector_spam') )->output();
}

$this->response()->data( array( 'html' => $this->module_ajax('/blocks/dota_2/macro_task', 20 ) ) )->output();