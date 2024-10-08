<?php
Session::check( 'get' );

/**
 * 0) rule
 * 1) table_main
 * 2) table_main_field_main
 * 3) table_main_value_main
 * n = 0..M
 * 4 + n) table_related
 * 5 + n) table_related_field
 * 6 + n) table_main_field
 */

if ( isset( $this->args[0] ) )
{
    Auth::check_access( $this->args[0] );
}

$query_part1 = 'DELETE `' . $this->args[1] .'`';
$query_part2 = ' FROM `' . $this->args[1] .'`';

$i = 4;
while( isset( $this->args[$i] ) && isset( $this->args[$i+1] ) && isset( $this->args[$i+2] ) )
{
    $query_part1 .= ', `' . $this->args[$i] .'`'; 
    
    $query_part2 .= ' LEFT JOIN `' . $this->args[$i] .'`
                        ON
                            `' . $this->args[$i] .'`.`' . $this->args[$i+1] .'` = `' . $this->args[1] .'`.`' . $this->args[$i+2] .'`';
    $i += 3;
}

$query_part2 .= ' WHERE `' . $this->args[1] .'`.`' . $this->args[2] .'` = %s';


DB::exec( $query_part1 . $query_part2 , $this->args[3] );