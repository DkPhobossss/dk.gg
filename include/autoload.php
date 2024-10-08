<?php

function __( $text )
{
    return ( !empty( \Localka::BOOK[ \Localka::$lang ][ $text ] )   ? \Localka::BOOK[ \Localka::$lang ][ $text ]
        : $text
    );
}

function ___( $text )
{
    return ( !empty( \Localka::BOOK_TEMP[ \Localka::$lang ][ $text ] )   ? \Localka::BOOK_TEMP[ \Localka::$lang ][ $text ]
        : ( !empty( \Localka::BOOK[ \Localka::$lang ][ $text ] )   ? \Localka::BOOK[ \Localka::$lang ][ $text ]
            : $text
        )
    );
}

function fobi_loader($class) {
    require_once( __DIR__ . '/../classes/' . str_replace('\\', '/', $class) . '.class.php' );
}

spl_autoload_register('fobi_loader');