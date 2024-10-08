<?php
namespace DOTA_2;
class Draft
{
    CONST TEAM_RADIANT = 'radiant';
    CONST TEAM_DIRE = 'dire';

    CONST EARLY_TEAMFIGHT_MULTIPLIER = 0.15;

    CONST MID_TEAMFIGHT_MULTIPLIER = 0.5;
    //20 and 9-10   10 10 82 89 89

    CONST LATE_TEAMFIGHT_MULTIPLIER = 0.33;
    //20 and 14 max

    CONST HEROES_PER_TEAM = 5;

    private $teams = null;
    private $macrotask_max = null;

    public function __construct( $team_1 = null, $team_2 = null )
    {
        if ( !is_null( $team_1 ) )
            $this->teams[ $team_1 ] = array();

        if ( !is_null( $team_2 ) )
            $this->teams[ $team_2 ] = array();
    }

    public function add_team( $team_name )
    {
        $this->teams[ $team_name ] = array();
    }

    public function add_hero( $team, int $role, int $role_id )
    {
        if ( !isset( $this->teams[ $team ] ) )
        {
            throw new \Exception\User( __('team_not_exists') );
        }

        switch ( $role )
        {
            case Hero::ROLE_CARRY :
            {
                return $this->add_carry( $team, $role_id );
            }
            case Hero::ROLE_MID :
            {
                return $this->add_mid( $team, $role_id );
            }
            case Hero::ROLE_OFFLANE :
            {
                return $this->add_offlane( $team, $role_id );
            }
            case Hero::ROLE_SOFT_SUPPORT :
            {
                return $this->add_soft_support( $team, $role_id );
            }
            case Hero::ROLE_HARD_SUPPORT :
            {
                return $this->add_hard_support( $team, $role_id );
            }
        }
    }


    private function add_carry( $team, $role_id )
    {
        $this->teams[ $team ]['heroes'][ Hero::ROLE_CARRY ]['role_id'] = $role_id;
    }

    private function add_mid( $team, $role_id )
    {
        $this->teams[ $team ]['heroes'][ Hero::ROLE_MID ]['role_id'] = $role_id;
    }

    private function add_offlane( $team, $role_id )
    {
        $this->teams[ $team ]['heroes'][ Hero::ROLE_OFFLANE ]['role_id'] = $role_id;
    }

    private function add_soft_support( $team, $role_id )
    {
        $this->teams[ $team ]['heroes'][ Hero::ROLE_SOFT_SUPPORT ]['role_id'] = $role_id;
    }

    private function add_hard_support( $team, $role_id )
    {
        $this->teams[ $team ]['heroes'][ Hero::ROLE_HARD_SUPPORT ]['role_id'] = $role_id;
    }


    public function calculate_team_power( $team_name )
    {
        if ( !isset( $this->teams[ $team_name ] ) )
        {
            return false;
        }

        if ( sizeof( $this->teams[ $team_name ]['heroes'] ) != self::HEROES_PER_TEAM )
        {
            return false;
        }



        $data = \DB\DOTA_2\Heroes_role::get_data_for_team_power(array(
            Hero::ROLE_CARRY => $this->teams[ $team_name ]['heroes'][ Hero::ROLE_CARRY ]['role_id'],
            Hero::ROLE_MID => $this->teams[ $team_name ]['heroes'][ Hero::ROLE_MID ]['role_id'],
            Hero::ROLE_OFFLANE => $this->teams[ $team_name ]['heroes'][ Hero::ROLE_OFFLANE ]['role_id'],
            Hero::ROLE_SOFT_SUPPORT => $this->teams[ $team_name ]['heroes'][ Hero::ROLE_SOFT_SUPPORT ]['role_id'],
            Hero::ROLE_HARD_SUPPORT => $this->teams[ $team_name ]['heroes'][ Hero::ROLE_HARD_SUPPORT ]['role_id'],
        ));



        if ( sizeof( $data ) != self::HEROES_PER_TEAM )
        {
            return false;
        }

        $this->teams[ $team_name ]['battle_tempo'] = array(
            \DB\DOTA_2\Heroes_macrotask::MACRO_TASK_LANING => 0,
            \DB\DOTA_2\Heroes_macrotask::MACRO_TASK_CARRY_EARLY_TEMPO => 0,
            \DB\DOTA_2\Heroes_macrotask::MACRO_TASK_CARRY_MID_TEMPO => 0,
            \DB\DOTA_2\Heroes_macrotask::MACRO_TASK_CARRY_LATE_TEMPO => 0,
        );

        $this->teams[ $team_name ]['macrotasks'] = array(
            \DB\DOTA_2\Heroes_macrotask::MACRO_TASK_TEAMFIGHT => 0,
            \DB\DOTA_2\Heroes_macrotask::MACRO_TASK_PUSH => 0,
            \DB\DOTA_2\Heroes_macrotask::MACRO_TASK_SIEGE => 0,
            \DB\DOTA_2\Heroes_macrotask::MACRO_TASK_ATTACK => 0,
            \DB\DOTA_2\Heroes_macrotask::MACRO_TASK_ROSHAN => 0,
            \DB\DOTA_2\Heroes_macrotask::MACRO_TASK_DEFEND => 0,
            \DB\DOTA_2\Heroes_macrotask::MACRO_TASK_PROTECT => 0,
            \DB\DOTA_2\Heroes_macrotask::MACRO_TASK_FARM => 0,
        );


        foreach ( $data as $role => $role_data )
        {
            $this->teams[ $team_name ]['heroes'][ $role ]['macrotask_data'] = $role_data;
            $teamfight = $role_data[ \DB\DOTA_2\Heroes_macrotask::MACRO_TASK_TEAMFIGHT ];

            $this->teams[ $team_name ]['battle_tempo'][ \DB\DOTA_2\Heroes_macrotask::MACRO_TASK_LANING ] +=
                self::laning_power( $role_data[ \DB\DOTA_2\Heroes_macrotask::MACRO_TASK_LANING ] );
            $this->teams[ $team_name ]['battle_tempo'][ \DB\DOTA_2\Heroes_macrotask::MACRO_TASK_CARRY_EARLY_TEMPO ] +=
                self::early_game_power( $role_data[ \DB\DOTA_2\Heroes_macrotask::MACRO_TASK_CARRY_EARLY_TEMPO ], $teamfight );
            $this->teams[ $team_name ]['battle_tempo'][ \DB\DOTA_2\Heroes_macrotask::MACRO_TASK_CARRY_MID_TEMPO ] +=
                self::mid_game_power( $role_data[ \DB\DOTA_2\Heroes_macrotask::MACRO_TASK_CARRY_MID_TEMPO ], $teamfight );
            $this->teams[ $team_name ]['battle_tempo'][ \DB\DOTA_2\Heroes_macrotask::MACRO_TASK_CARRY_LATE_TEMPO ] +=
                self::late_game_power( $role_data[ \DB\DOTA_2\Heroes_macrotask::MACRO_TASK_CARRY_LATE_TEMPO ], $teamfight );


            foreach ( $this->teams[ $team_name ]['macrotasks'] as $macrotask_key => &$macrotask_value )
            {
                $macrotask_value += $role_data[ $macrotask_key ];
            }
        }
        unset( $macrotask_value );


        foreach ( $this->teams[ $team_name ]['macrotasks'] as $macrotask_key => &$macrotask_value )
        {
            $macrotask_value = round( $macrotask_value / $this->max( $macrotask_key ) * 100 ) ;
        }
        unset( $macrotask_value );


        $this->teams[ $team_name ]['battle_tempo'][ \DB\DOTA_2\Heroes_macrotask::MACRO_TASK_LANING ] =
            round( $this->teams[ $team_name ]['battle_tempo'][ \DB\DOTA_2\Heroes_macrotask::MACRO_TASK_LANING ] / $this->max( \DB\DOTA_2\Heroes_macrotask::MACRO_TASK_LANING ) * 100 );
        $this->teams[ $team_name ]['battle_tempo'][ \DB\DOTA_2\Heroes_macrotask::MACRO_TASK_CARRY_EARLY_TEMPO ] =
            round( $this->teams[ $team_name ]['battle_tempo'][ \DB\DOTA_2\Heroes_macrotask::MACRO_TASK_CARRY_EARLY_TEMPO ] / $this->max( \DB\DOTA_2\Heroes_macrotask::MACRO_TASK_CARRY_EARLY_TEMPO ) * 100    );
        $this->teams[ $team_name ]['battle_tempo'][ \DB\DOTA_2\Heroes_macrotask::MACRO_TASK_CARRY_MID_TEMPO ] =
            round( $this->teams[ $team_name ]['battle_tempo'][ \DB\DOTA_2\Heroes_macrotask::MACRO_TASK_CARRY_MID_TEMPO ] / $this->max( \DB\DOTA_2\Heroes_macrotask::MACRO_TASK_CARRY_MID_TEMPO ) * 100  );
        $this->teams[ $team_name ]['battle_tempo'][ \DB\DOTA_2\Heroes_macrotask::MACRO_TASK_CARRY_LATE_TEMPO ] =
            round( $this->teams[ $team_name ]['battle_tempo'][ \DB\DOTA_2\Heroes_macrotask::MACRO_TASK_CARRY_LATE_TEMPO ] / $this->max( \DB\DOTA_2\Heroes_macrotask::MACRO_TASK_CARRY_LATE_TEMPO ) * 100  );

        return array(
            'battle_tempo' => $this->teams[ $team_name ]['battle_tempo'],
            'macrotasks' => $this->teams[ $team_name ]['macrotasks']
        );
    }


    private function max( $macrotask = null )
    {
        if ( is_null( $this->macrotask_max ) )
        {
            $this->macrotask_max = \DB\DOTA_2\Heroes_macrotask::max_all();
        }

        return is_null( $macrotask ) ? $this->macrotask_max : $this->macrotask_max[ $macrotask ];
    }


    private function laning_power( $laning_macrotask )
    {
        return $laning_macrotask;
    }

    private function early_game_power( $tempo, $teamfight )
    {
        return ( $tempo + $teamfight * self::EARLY_TEAMFIGHT_MULTIPLIER ) / ( 1 + self::EARLY_TEAMFIGHT_MULTIPLIER / 2 );
    }

    private function mid_game_power( $tempo, $teamfight )
    {
        return ( $tempo + $teamfight * self::MID_TEAMFIGHT_MULTIPLIER ) / ( 1 + self::MID_TEAMFIGHT_MULTIPLIER / 2 );
    }

    private function late_game_power( $tempo, $teamfight )
    {
        return ( $tempo + $teamfight * self::LATE_TEAMFIGHT_MULTIPLIER ) / ( 1 + self::LATE_TEAMFIGHT_MULTIPLIER / 2 );
    }

    /**
     * Calculate power depending of 2 teams
     */
    public function calculate_power()
    {

    }

}