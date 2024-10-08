<?php
Auth::check_access();

if ( Input::get('update_items') )
{
    DOTA_2\Item::synchronize();
    Page::go_back();
}
elseif ( Input::get('update_skills') )
{
    DOTA_2\Skill::synchronize();
    Page::go_back();
}
elseif ( Input::get('full_data') )
{
    echo $this->module( 'page', $this->module( 'main/' . Config::adminKA,  Config::adminKA . '/learn/heroes/full_data' ) );
}
else
{
    echo $this->module( 'page', $this->module( 'main/' . Config::adminKA,  Config::adminKA . '/learn/heroes' ) );
}


