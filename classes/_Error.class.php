<?php
class _Error
{
    CONST USER = 'user';
    CONST FATAL = 'fatal';
    CONST NOT_FOUND = '404';
    CONST FORBIDDEN = '403';
    
    private static $errors;
    public static $title;
     
    public static function render( $filename , $errors = '' )
    {
        while ( ob_get_level() ) {
            ob_end_clean();
        }
        self::$errors = $errors;
        
        switch ( $filename )
        {
            case self::USER : 
            {
                self::$title = __('Error');
                break;
            }
            
            case self::NOT_FOUND : 
            {
                self::$title = '404 Not Found';
                break;
            }
            
            case self::FORBIDDEN : 
            {
                self::$title = '403 Forbidden';
                break;
            }
            
            default : 
            {
                self::$title = __('Error!');
                $filename = self::USER;
            }
            
        }

        $link = new Link\Error( $filename );

        print $link->execute();
        die();
    }
    
    public static function get_errors_html()
    {
        if ( !is_array( self::$errors ) )
        {
            return self::$errors;
        }
        
        $html = '';
        foreach ( self::$errors as $error )
        {
            $html .=  $error . '</br>';
        }
        return $html;
    }
}