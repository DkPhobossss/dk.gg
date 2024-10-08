<?php

/**
 * Назначение этого класса - редко-используемые функции или функции, которые нет смысла выносить в отдельный класс 
 */
class Helper
{


    public static function parse_forum_message( $comment )
    {
        $comment = preg_replace ( "/\[quote( author=([^\] ]*)[^\]]*)?\]/is", '<blockquote><div class="quote_head">$2</div>', $comment, -1, $open );
        $comment = str_replace ( '[/quote]', '</blockquote>', $comment, $closed );


        if ( ( $diff = $open - $closed ) )
        {
            if ( $diff > 0 )
            {
                for (; $diff > 0; $diff-- )
                {
                    $comment .= '</blockquote>';
                }
            }
            else
            {
                for (; $diff < 0; $diff++ )
                {
                    $comment = '<blockquote>' . $comment;
                }
            }
        }
        
        /*
         * Clean...
         * 
         * color,font,size,url... - \/?color(=[^\]]*)?
         * bold,italic,underline... - \/?b
         * youtube - nothing
         */
        
        $comment = preg_replace("/\[(\/?(color|font|size|url|hide|img)(=[^\]]*)?|\/?(b|i|u|s|center|right|left|spoiler|hr|sub|table|tr|td|sup))\]/is" , '' , $comment );
        
        //parse smilegi

        return $comment;
    }



    /**
     * Выводит все локали текщуго сервера
     * @return array 
     */
    public static function print_server_locales()
    {
        system( 'locale -a', $result );
        return $result;
    }

    /**
     * Выводит ошибки и ответы, которые возникают при использовании system , exec , etc
     * 
     * @param string $cmd
     * @param type $input
     * @return array 
     */
    public static function IO_exec( $cmd, $input = '' )
    {
        $proc = proc_open( $cmd, array( 0 => array( 'pipe', 'r' ), 1 => array( 'pipe', 'w' ), 2 => array( 'pipe', 'w' ) ), $pipes );
        fwrite( $pipes[0], $input );
        fclose( $pipes[0] );
        $stdout = stream_get_contents( $pipes[1] );
        fclose( $pipes[1] );
        $stderr = stream_get_contents( $pipes[2] );
        fclose( $pipes[2] );
        $rtn = proc_close( $proc );
        return array( 'stdout' => $stdout,
            'stderr' => $stderr,
            'return' => $rtn
        );
    }

    public static function glob_recursive( $pattern, $flags = 0 )
    {
        $files = glob( $pattern, $flags );

        foreach ( glob( dirname( $pattern ) . '/*', GLOB_ONLYDIR | GLOB_NOSORT ) as $dir )
        {
            $files = array_merge( $files, self::glob_recursive( $dir . '/' . basename( $pattern ), $flags ) );
        }

        return $files;
    }

    public static function get_last_used_file( $dir, $pattern, $flags )
    {
        $files = self::glob_recursive( $dir . $pattern, $flags );
        $max = 0;
        $file = false;
        foreach ( $files as $row )
        {
            $time = filemtime( $row );
            if ( $max < $time )
            {
                $max = $time;
                $file = $row;
            }
        }
        return $file;
    }

    
    
    /**
     * $arg_1 - array()
     * $arg_2 - array()
     * 
     * ....
     * $arg_N - array()
     * 
     * return $arg_1 array with values of $arg_i.
     * i - MAX Existing key $arg_1
     */
    public static function redeclare_array( )
    {
        $args = func_get_args();
        if ( count($args) < 2)
        {
            return $args[0];
        }
        
        $array = array_shift( $args );
        foreach ( $array as $key => &$value )
        {
            $temp = end( $args );
            if ( isset( $temp[ $key ] ) )
            {
                $value = $temp[$key];
                continue;
            }
            
            while ( ( $temp = prev( $args ) ) !== false )
            {
                if ( isset( $temp[ $key ] ) )
                {
                    $value = $temp[$key];
                    continue;
                }
            }
        }
        unset( $value );
        return $array;
    }
    
    public static function url2path( $url )
    {
        return Config::SITE_ROOT . ( mb_strpos($url , 'http://') === false  ? ltrim( $url , '/' )
                                                                            : mb_substr( $url, mb_strpos( $url, '/' , 8) + 1 ) );
    }

}
