<?php

namespace DB\DOTA_2;
use DB;
use DOTA_2\Hero;


class Heroes_macrotask extends DB\Table
{
    static $table_name = 'dota_2_heroes_macrotask';

    CONST MAX = 20;
    CONST MIN = 0;

    const MACRO_TASK_ATTACK = 'attack';
    const MACRO_TASK_BAIT = 'bait';
    const MACRO_TASK_CARRY_EARLY_TEMPO = 'carry_early_tempo';
    const MACRO_TASK_CARRY_MID_TEMPO = 'carry_mid_tempo';
    const MACRO_TASK_CARRY_LATE_TEMPO = 'carry_late_tempo';
    const MACRO_TASK_DEFEND = 'defend';
    const MACRO_TASK_FARM = 'farm';
    const MACRO_TASK_LANING = 'laning';
    const MACRO_TASK_MOVE = 'move';
    const MACRO_TASK_PROTECT = 'protect';
    const MACRO_TASK_PUSH = 'push';
    const MACRO_TASK_ROSHAN = 'roshan';
    const MACRO_TASK_ROSHAN_PROTECT = 'roshan_protect';
    const MACRO_TASK_RUNES = 'runes';
    const MACRO_TASK_SCOUT = 'scout';
    const MACRO_TASK_SIEGE = 'siege';
    const MACRO_TASK_STACK = 'stack';
    const MACRO_TASK_STACK_FARM = 'stack_farm';
    const MACRO_TASK_TEAMFIGHT = 'teamfight';



    /** 0-2 3-5 6-8 9-11 12-14 15-17 18-20
     * @param $int int
     * @return string
     */
    public static function description_from_value( $value, $html = false )
    {
        if ( $html === false )
            return __('Macrotask_description_' . ( floor( $value / 3 ) ) );

        $value = floor( $value / 3 );
        return '<span class="macrotask_' . $value . '">' . __('Macrotask_description_' .  $value )  . '</span>';
    }

    public static function DATA( $description = false )
    {
        return \DB::exec('SELECT
        `t1`.`name`,`t1`.`url`, `t1`.`priority`,
        `t2`.`text`' . ( $description ? ',`t2`.`description`' : '' ) . '
        FROM ' . self::$table_name . ' as `t1`
        LEFT JOIN
            ' . \DB\DOTA_2\Heroes_macrotask_data::$table_name . ' as `t2` ON
                `t1`.`name` = `t2`.`name` AND
                `t2`.`lang` = %s
        ORDER BY `priority` ASC, `order` DESC', \Localka::$lang )->rows('name');
    }

    public static function calculate_max()
    {
        try
        {
            \DB::transaction();

            $data = self::select('*' )->rows();
            foreach ( $data as $row )
            {
                $macrotask_name = $row['name'];
                $sum = 0;
                $roles = array(
                    Hero::ROLE_CARRY => 0,
                    Hero::ROLE_MID => 0,
                    Hero::ROLE_OFFLANE => 0,
                    Hero::ROLE_SOFT_SUPPORT => 0,
                    Hero::ROLE_HARD_SUPPORT => 0,
                );

                foreach ( $roles as $role => &$value )
                {
                    $value = \DB::exec('SELECT
                    max(`' . $macrotask_name . '`) as `max` 
                    FROM 
                        `' . \DB\DOTA_2\Heroes_role::$table_name . '` 
                    WHERE 
                        role = %d AND 
                        disabled=0', $role)->value();

                    $sum += $value;
                }

                self::update( array(
                    'max_1' => $roles[ Hero::ROLE_CARRY ],
                    'max_2' => $roles[ Hero::ROLE_MID ],
                    'max_3' => $roles[ Hero::ROLE_OFFLANE ],
                    'max_4' => $roles[ Hero::ROLE_SOFT_SUPPORT ],
                    'max_5' => $roles[ Hero::ROLE_HARD_SUPPORT ],
                    'max' => $sum
                ), array('name' => $macrotask_name) );
            }
            unset( $value );



            \DB::commit();
        }
        catch ( \Exception $e )
        {
            \DB::rollback();
            throw new \Exception\Fatal( $e->getMessage() );
        }
    }

    public static function max_all()
    {
        return self::select( array( 'name', 'max') )->rows('name', 'max');
    }

}

