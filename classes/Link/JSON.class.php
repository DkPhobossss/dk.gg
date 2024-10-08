<?php

namespace Link;
chdir('../');

class JSON extends \Module
{

    static $parts = array( );
    static $url_parts = array( );

    const ROOT = 'links';


    protected static $root;
    protected $response;

    public function __construct( $uri )
    {
        try
        {
            $path = static::root() . '/';
            $args = array( );

            $parts = mb_split( '/', $uri );
            $first_uri_part = reset( $parts );

            if ( !empty( \Localka::$settings[ $first_uri_part ] ) && (sizeof($parts) > 1) && empty( \Localka::$settings[ $first_uri_part ]['disabled'] ) && ( \Localka::DEFAULT_LANGUAGE != $first_uri_part ) )
            {
                //some language but not default
                \Localka::$lang = $first_uri_part;
                \Config::$root_url .=  ('/' .\Localka::$settings[ $first_uri_part ]['url'] );
                array_shift( $parts );
            }
            else
            {
                \Localka::$lang = \Localka::DEFAULT_LANGUAGE;
                \Config::$root_url .= '/';
            }

            if ( empty( $uri ) || ( ( $uri == ( \Localka::$lang . '/') ) && ( \Localka::$lang != \Localka::DEFAULT_LANGUAGE )  ) )
            {
                parent::__construct( null , $args );
                return;
            }


            self::$url_parts = $parts;

            foreach ( $parts as &$part )
            {
                if ( !mb_ereg_match( '^\w+$', $part ) || !is_dir( $path . $part ) )
                {
                    header( 'HTTP/1.0 404 Not Found' );
                    $this->error( $path . $part . ' not found' );
                    return;
                }

                $path .= $part . '/';
                self::$parts[] = $part;
            }
            unset( $part );

            parent::__construct(  implode('/', $parts ) , $args );
        }
        catch ( \Exception\Fatal $e )
        {
            $this->error( $e->getMessage() );
        }
        catch ( \Exception\User $e )
        {
            $this->error( $e->getErrors() );
        }
    }

    function execute()
    {    
        ob_start();
        try
        {
            print parent::execute();
        }
        catch ( \Exception\Fatal $e )
        {
            $this->error( $e->getMessage() );
        }
        catch ( \Exception\User $e )
        {
            $this->error( $e->getErrors() );
        }
        return ob_get_clean();
    }

    function error( $value, $key = '' )
    {
        if ( is_array( $value ) )
        {
            $this->response()->errors( $value )->output();
        }
        else
        {
            $this->response()->errors( array( $key => $value ) )->output();
        }
    }

    protected function response()
    {
        if ( !isset( $this->response ) )
        {
            $this->response = new JSON\Response();
        }
        return $this->response;
    }

}