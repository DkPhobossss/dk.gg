<?php


$Draft = new DOTA_2\Draft();
$result = array();

$insert_data = array(
    'user_id' => \Auth::id(),
    'user_ip' => \Auth::ip(),
);

foreach ( array( \DOTA_2\Draft::TEAM_RADIANT, \DOTA_2\Draft::TEAM_DIRE ) as $team )
{
    $team_data = Input::post( $team );
    if ( !empty(  $team_data ) && sizeof(  $team_data ) == 5 )
    {
        $Draft->add_team( $team );

        foreach ( $team_data as $role => $role_data )
        {
            $role = intval( $role );
            if ( $role < 1 || $role > 5 )
            {
                $this->response()->errors( __('invalid data') )->output();
            }

            $Draft->add_hero( $team, $role, intval( $role_data['role_id'] ) );
        }

        $power = $Draft->calculate_team_power( $team );

        if ( !empty( $power ) )
        {
            $result[ $team ] = $power;
            for ( $i = 1; $i <= 5; $i++ )
                $insert_data[ $team . '_' .$i ] = $team_data[ $i ][ 'role_id' ];
        }

    }
}

if ( empty( $result ) )
{
    $this->response()->errors( __('invalid data') )->output();
}


\DB\DOTA_2\Draft_log::insert(
    $insert_data
);

$this->response()->data( $result )->output();