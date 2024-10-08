<?php
if ( isset( $_GET['logout'] ) && Auth::id() )
{
    Auth::logout();
    Page::go_back();
}
elseif ( Input::post('mode') === 'auth' && !Auth::id() )
{	
    Auth::login( Input::post('login'), Input::post('password') );
    Page::go_back();
}

if ( Auth::rule( 'DB\Rules::BACKEND' ) )
{   //var_dump($this);die;
    $this->access = true;
    
    $this->args('submodule');
    
    $this->modules = array(
        'home' => array( 'icon' => 'home' , 
                    'text' => 'Home' , 
                    'href' => Config::adminKA
        ) ,
        'translate' => array( 'icon' => 'translate' , 
                    'text' => 'Translate ' . Localka::$lang , 
                    'href' => Config::adminKA . '/translate'
        ) ,
        'on_site' => array( 'icon' => 'shutdown' , 
                    'text' => 'Return to site' , 
                    'href' => Config::$root_url
        ) , 
    );
}



