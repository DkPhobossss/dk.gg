<?php

if ( Auth::id() && Session::check('get') )
{
    Auth::logout();
}
Page::go_back();