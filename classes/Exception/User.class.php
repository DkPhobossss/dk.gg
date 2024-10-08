<?php

namespace Exception;

class User extends \Exception
{

    protected $errors;

    function __construct( $value, $key = '' )
    {
        parent::__construct();

        if ( is_array( $value ) )
        {
            $this->errors = $value;
        }
        else
        {
            $this->errors = array( $key => $value );
        }
    }

    function getErrors()
    {
        return $this->errors;
    }

}