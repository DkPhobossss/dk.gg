<?php

class CURL
{
    public static function url_get_contents( $url , $timeout = 1500, $follow_redirect = false , $cookie_name = null,  $user_agent = 'Mozilla/5.0' )
    {
        $ch = curl_init( $url );
        curl_setopt( $ch, CURLOPT_USERAGENT, $user_agent );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 ); # Убираем вывод данных в браузер. Пусть функция их возвращает а не выводит
        curl_setopt( $ch , CURLOPT_CONNECTTIMEOUT_MS , $timeout );//1 second
        
        if ( $follow_redirect )
            curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1 ); // следовать за редиректами
        
        if ( isset( $cookie_name ) )
        {
            curl_setopt( $ch, CURLOPT_COOKIEFILE, dirname($_SERVER['SCRIPT_FILENAME']) ."/$cookie_name.txt" ); //Из какого файла читать
            curl_setopt( $ch, CURLOPT_COOKIEJAR, dirname($_SERVER['SCRIPT_FILENAME']) ."/$cookie_name.txt" ); //В какой файл записывать
        }

        $data = curl_exec($ch);

        if ( curl_errno( $ch ) )
        {
            trigger_error( curl_error($ch) , E_USER_NOTICE );
        }
        elseif( $data === FALSE )
        {
            trigger_error( "CURL : $url has no data. Timeout : $timeout ms" , E_USER_NOTICE );
        }

        curl_close( $ch );
        return $data;
    }
    
    
    public static function post( $url , $data, $timeout = 1500, $follow_redirect = false , $cookie_name = null, $user_agent = 'Mozilla/5.0' )
    {
        $ch = curl_init();
        
        curl_setopt( $ch, CURLOPT_USERAGENT, $user_agent );
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $ch, CURLOPT_POST, 1 );
        
        curl_setopt( $ch ,CURLOPT_CONNECTTIMEOUT_MS , $timeout );//1 second
        
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );// просто отключаем проверку сертификата 
        
        if ( $follow_redirect )
            curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1 ); // следовать за редиректами
        
        if ( isset( $cookie_name ) )
        {
            curl_setopt( $ch, CURLOPT_COOKIEFILE, dirname($_SERVER['SCRIPT_FILENAME']) ."/$cookie_name.txt" ); //Из какого файла читать
            curl_setopt( $ch, CURLOPT_COOKIEJAR, dirname($_SERVER['SCRIPT_FILENAME']) ."/$cookie_name.txt" ); //В какой файл записывать
        }
        
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $data ); //"a=4&b=7"

        $data = curl_exec($ch);
        
        if ( curl_errno( $ch ) )
        {
            trigger_error( curl_error($ch) , E_USER_NOTICE );
        }
        elseif( $data === FALSE )
        {
            trigger_error( "CURL : $url has no data. Timeout : $timeout ms" , E_USER_NOTICE );
        }

        curl_close($ch);
        return $data;
    }

    public static function remote_file_exists( $url )
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        // don't download content
        curl_setopt($ch, CURLOPT_NOBODY, 1);
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($ch);
        curl_close($ch);
        if ( $result !== FALSE )
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}