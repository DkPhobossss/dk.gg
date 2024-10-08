<?php

class Word
{
    public static function stamming( $word , $lang )
    {
        $stem = array(
            'ru' => 'stem_russian_unicode' , 
            'en' => 'stem_english'
        );
        
        return call_user_func( $stem[ $lang ] , $word  );
    }
    

    
    public static function translit( $string )
    {
        $converter = array(
            'а' => 'a',   'б' => 'b',   'в' => 'v',
            'г' => 'g',   'д' => 'd',   'е' => 'e',
            'ё' => 'jo',   'ж' => 'zh',  'з' => 'z',
            'и' => 'i',   'й' => 'j',   'к' => 'k',
            'л' => 'l',   'м' => 'm',   'н' => 'n',
            'о' => 'o',   'п' => 'p',   'р' => 'r',
            'с' => 's',   'т' => 't',   'у' => 'u',
            'ф' => 'f',   'х' => 'h',   'ц' => 'c',
            'ч' => 'ch',  'ш' => 'sh',  'щ' => 'w',
            'ь' => '',  'ы' => 'y',   'ъ' => '',
            'э' => 'je',   'ю' => 'ju',  'я' => 'ja',

            'А' => 'A',   'Б' => 'B',   'В' => 'V',
            'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
            'Ё' => 'Jo',   'Ж' => 'Zh',  'З' => 'Z',
            'И' => 'I',   'Й' => 'j',   'К' => 'K',
            'Л' => 'L',   'М' => 'M',   'Н' => 'N',
            'О' => 'O',   'П' => 'P',   'Р' => 'R',
            'С' => 'S',   'Т' => 'T',   'У' => 'U',
            'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
            'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'W',
            'Ь' => '',  'Ы' => 'Y',   'Ъ' => '',
            'Э' => 'Je',   'Ю' => 'Ju',  'Я' => 'Ja',
        );
        return strtr($string, $converter);
    }
    
    public static function url_translit( $string )
    {
        $string = mb_strtolower( $string );
        
        $converter = array(
            'а' => 'a',   'б' => 'b',   'в' => 'v',
            'г' => 'g',   'д' => 'd',   'е' => 'e',
            'ё' => 'jo',   'ж' => 'zh',  'з' => 'z',
            'и' => 'i',   'й' => 'j',   'к' => 'k',
            'л' => 'l',   'м' => 'm',   'н' => 'n',
            'о' => 'o',   'п' => 'p',   'р' => 'r',
            'с' => 's',   'т' => 't',   'у' => 'u',
            'ф' => 'f',   'х' => 'h',   'ц' => 'c',
            'ч' => 'ch',  'ш' => 'sh',  'щ' => 'w',
            'ь' => '',  'ы' => 'y',   'ъ' => '',
            'э' => 'je',   'ю' => 'ju',  'я' => 'ja',
            ' ' => '_'
        );
        $string = strtr( $string , $converter );
        return preg_replace ( '/[^a-zA-Z0-9\-\_]/', '' , $string );
    }
    
    /**
     * Return soundex of words
     * @param string $text
     * @return array 
     */
    public static function create_encoding_words( $text , $lang )
    {
       // $text = trim( preg_replace('|\s+|', ' ', $text) );
        $words = mb_split( '[^a-zA-Zа-яА-Я0-9\']+' , $text );

        foreach ( $words as $key => &$value )
        {
            $value =  self::translit( self::stamming( $value , $lang ) );
            if ( empty ( $value ) )
            {
                unset( $words[ $key ] );
            }
        }

        unset( $value );
        return $words;  
    }
    
    
    
    /*function str2url($str) {
        // переводим в транслит
        $str = rus2translit($str);
        // в нижний регистр
        $str = strtolower($str);
        // заменям все ненужное нам на "-"
        $str = preg_replace('~[^-a-z0-9_]+~u', '-', $str);
        // удаляем начальные и конечные '-'
        $str = trim($str, "-");
        return $str;
    }*/
}