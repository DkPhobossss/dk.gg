<?php
//same as delete , but more options
Session::check( 'get' );

/**
 * 0) rule
 * 1) array(table_main , table_field, table_value )     [, condition , condition_2 ... ]   array( DB\Watch\Channel::$table_name , 'id' , Input::get('id') )
 * 2) array(table_join , field_join , field_valie )     [, condition , condition_2 ... ]   array( 'global_comments' , 'news_id' , DB\Watch\Channel::$table_name . '.`id`' , ' AND `global_comments`.`type` = 4' )
 * ....
 * N)
 */

if ( isset( $this->args[0] ) )
{
    Auth::check_access( $this->args[0] );
}

$query_part1 = 'DELETE `' . $this->args[1][0] .'`';
$query_part2 = ' FROM `' . $this->args[1][0] .'`';

$i = 4;

for ( $i = 2, $c = count( $this->args ) ; $i < $c; $i++ )
{
    $query_part1 .= ', `' . $this->args[$i][0] .'`'; 
    
    $query_part2 .= ' LEFT JOIN `' . $this->args[$i][0] .'`
                        ON
                            `' . $this->args[$i][0] .'`.`' . $this->args[$i][1] .'` = ' . $this->args[$i][2];
                            
    for ( $j = 3; $j < count( $this->args[$i]) ; $j++ )
    {
        $query_part2 .= $this->args[$i][$j];
    }
}

$query_part2 .= ' WHERE `' . $this->args[1][0] .'`.`' . $this->args[1][1] .'` = %s';
for ( $j = 3; $j < count( $this->args[1]) ; $j++ )
{
    $query_part2 .= $this->args[$i][$j];
}

DB::exec( $query_part1 . $query_part2 , $this->args[1][2] );