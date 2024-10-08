<?php



class Bootstrap
{

    public static function run()
    {
        try
        {
            date_default_timezone_set( Config::default_time_zone );
            mb_internal_encoding( Config::encoding );
            mb_regex_encoding( Config::encoding );

            if ( Config::DEBUG )
            {
                Timer::start();
                DB::debug(true);
            }
            
            Config::set_error_handler( 'file' );

            self::process_query( );
        }
        catch ( Exception\Fatal $e )
        {
            trigger_error( $e->getMessage() , E_USER_WARNING );
            _Error::render( _Error::FATAL, $e->getMessage() );
        }
        catch ( Exception\User $e )
        {
            _Error::render( _Error::USER, $e->getErrors() );
        }
        catch ( Exception $e )
        {
            trigger_error( $e->getMessage() , E_USER_WARNING );
            _Error::render( _Error::USER, $e->getMessage() );
        }
    }

    
    private static function process_query( )
    {
        $uri_parts = explode('?', mb_substr( Input::server( 'REQUEST_URI' ) , 1), 2);

        if ( mb_ereg_match( '^[a-z]{2}?/?ajax/json/', $uri_parts[0] ) )
        {
            $link = new Link\JSON( $uri_parts[0] );
        }
        else
        {
            $link = new Link( $uri_parts[0] );
        }

        print $link->execute();
    }
}