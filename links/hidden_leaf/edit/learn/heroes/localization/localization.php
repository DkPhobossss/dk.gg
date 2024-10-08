<?php
Auth::check_access();

if ( Input::post('submit') )
{
    if ( isset( $_FILES['doc'] ) && ( $_FILES['doc']['error'] == 0 ) )
    {
        $temp_file_location = $_FILES['doc']['tmp_name'];

        $FVDF_Parser = new Parser\VDF();

        $FVDF_Parser->load_file( $temp_file_location )->compile()->parse_abilities();


        $this->success = true;
    }
    else
    {
        die('Error downloading file');
    }
}