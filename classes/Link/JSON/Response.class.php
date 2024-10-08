<?php

namespace Link\JSON;

class Response
{

    private $callbacks = array( );

    function __construct()
    {
        
    }

    function callback( $type, $data = array( ) )
    {
        if ( is_string( $type ) )
        {
            $data['type'] = $type;
        }
        else
        {
            $data = $type;
        }
        $this->callbacks[] = $data;
        return $this;
    }

    function reload()
    {
        return $this->callback( 'reload' );
    }

    function redirect( $url )
    {
        return $this->callback( 'redirect', array( 'url' => $url ) );
    }

    function errors( $errors = array() )
    {
        return $this->callback( 'errors', array( 'errors' => $errors ) );
    }

    function tooltip( $data = '' )
    {
        return $this->callback( 'tooltip', array( 'text' => $data ) );
    }

    function data( array $data )
    {
        return $this->callback( 'data', array( 'data' => $data ) );
    }
    
    function dialog( $key = '', $value = null )
    {
        return $this->callback( 'dialog', array( 'key' => $key, 'value' => $value ) );
    }

    function reload_captcha()
    {
        return $this->callback( 'captcha_reload' );
    }

    function output( $content = false )
    {
        header( 'Content-type: text/plain' );
        print json_encode( $content ?: $this->callbacks );
        die();
    }

}