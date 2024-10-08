<?php
chdir('../');


class Link extends Module
{

    static $parts = array( );
    static $url_parts = array( );

    const ROOT = 'links';
    const BASE = '$arg'; // can't be like pattern ^\w+$
    
    


    protected static $root;

    public function __construct( $uri )
    {
        //1-st time on index.php
        if ( empty( $uri ) && empty(Cookie::get('lang') ) )
        {

            $locale = locale_accept_from_http( Input::server('HTTP_ACCEPT_LANGUAGE') );
            foreach ( \Localka::$settings as $key => $val)
            {
                if ( ( $val['accept_language'] == $locale ) && ( $key != \Localka::DEFAULT_LANGUAGE ) )
                {
                    Page::go( '/' . $val['url'] );
                }
            }
        }

        $path = static::root() . '/';
        $args = array( );

        $parts = mb_split( '/', $uri );
        $first_uri_part = reset( $parts );



        if ( !empty( \Localka::$settings[ $first_uri_part ] ) && (sizeof($parts) > 1) && empty( \Localka::$settings[ $first_uri_part ]['disabled'] ) && ( \Localka::DEFAULT_LANGUAGE != $first_uri_part ) )
        {
            //some language but not default
            \Localka::$lang = $first_uri_part;
            \Localka::$lang_url = '/' . \Localka::$lang;
            Config::$root_url .=  ('/' .\Localka::$settings[ $first_uri_part ]['url'] );
            array_shift( $parts );
        }
        else
        {
            \Localka::$lang = \Localka::DEFAULT_LANGUAGE;
            \Localka::$lang_url = '/';
        }

        self::$url_parts = $parts;




        Output::$base = Config::$root_url . '/';
        Cookie::set( 'lang' , \Localka::$lang );


        if ( empty( $uri ) || ( ( $uri == ( \Localka::$lang . '/') ) && ( \Localka::$lang != \Localka::DEFAULT_LANGUAGE )  ) )
        {
            parent::__construct( null , $args );
            return;
        }


        foreach ( $parts as &$part )
        {
            if ( !mb_ereg_match( '^\w+$', $part ) || !is_dir( $path . $part ) )
            {	
                $args[] = $part;
                $part = self::BASE;
            }

            if ( !is_dir( $path . $part ) )
            {	
                $this->error( $path . $part );
            }


            $path .= $part . '/';
            self::$parts[] = $part; //var_dump($part);die;
        }
        unset( $part );



      
        parent::__construct(  implode('/', $parts ) , $args );
    }

    protected function error( $message = '' )
    {
        _Error::render( _Error::NOT_FOUND );
    }

}