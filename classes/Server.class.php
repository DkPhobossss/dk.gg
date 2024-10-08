<?php

class Server
{

    private static $dir_permission = 0750;

    public static function temp_dir()
    {
        return ini_get( 'upload_tmp_dir' ) ? ini_get( 'upload_tmp_dir' ) : sys_get_temp_dir();
    }

    public static function mkdir( $dir )
    {
        if ( !file_exists( $dir ) && !is_dir( $dir ) )
        {
            if ( !mkdir( $dir, self::$dir_permission ) )
            {
                throw new Exception\Fatal( 'Cant create ' . $dir );
            }

            return true;
        }

        return false;
    }

    public static function deleteDir( $dirPath )
    {
        if ( !is_dir( $dirPath ) )
        {
            throw new Exception\Fatal( "$dirPath must be a directory" );
        }
        if ( substr( $dirPath, strlen( $dirPath ) - 1, 1 ) != '/' )
        {
            $dirPath .= '/';
        }
        $files = glob( $dirPath . '*', GLOB_MARK );
        foreach ( $files as $file )
        {
            if ( is_dir( $file ) )
            {
                self::deleteDir( $file );
            }
            else
            {
                unlink( $file );
            }
        }
        rmdir( $dirPath );
    }

    public static function check_writeble( $dir )
    {
        if ( !is_writable( $dir ) )
        {
            throw new Exception\Fatal( $dir . ' is not writable' );
        }

        return true;
    }

    public static function path()
    {
        return Config::SITE_ROOT . implode( '/', func_get_args() );
    }

}