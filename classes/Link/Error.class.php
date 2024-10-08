<?php
namespace Link;
class Error extends \Module
{
    const ROOT = 'modules/errors/';
    protected $filename;

    public function __construct( $filename )
    { 
        $this->filename = $filename;
    }
    
    function execute( )
    {
        ob_start();
            echo $this->module( 'page', $this->module( 'errors', $this->filename ) , true );
        return ob_get_clean();
    }
}