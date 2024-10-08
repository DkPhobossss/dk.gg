<?php
class Parser
{
    protected $loaded_data = null;
    protected $compiled_data = array();

    public function load_file( $file_name )
    {
        $this->loaded_data = file_get_contents( $file_name );

        return $this;
    }


    public function compile()
    {
        return $this;
    }
}