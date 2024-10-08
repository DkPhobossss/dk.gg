<?php

namespace DB\DOTA_2;
use DB;


class Heroes_role extends DB\Table
{
    static $table_name = 'dota_2_heroes_role';


    static $fields = array(
        'hero_id' => array(
            'type' =>'enum' ,
            'disable_update' => true,
            'pseudo_primary' => true
        ),
        'role' => array(
            'type' => 'enum',
            'length' => array( "1" => '1',"2" => '2', "3" => '3', "4" => '4', "5" => '5'),
            'disable_update' => true,
            'pseudo_primary' => true
        ),
        'visible' => array(
            'type' => 'bool',
            'default' => 0
        ),
        'disabled' => array(
            'type' => 'bool',
            'default' => 1
        ),
        'popularity' => array(
            'type' => 'int',
            'length' => 3,
            'default' => 50
        ),
        Heroes_macrotask::MACRO_TASK_LANING => array(
            'type' => 'int',
            'default' => 10,
            'min' =>  Heroes_macrotask::MIN,
            'max' =>  Heroes_macrotask::MAX
        ),
        Heroes_macrotask::MACRO_TASK_STACK => array(
            'type' => 'int',
            'default' => 10,
            'min' =>  Heroes_macrotask::MIN,
            'max' =>  Heroes_macrotask::MAX
        ),
        Heroes_macrotask::MACRO_TASK_STACK_FARM => array(
            'type' => 'int',
            'default' => 10,
            'min' =>  Heroes_macrotask::MIN,
            'max' =>  Heroes_macrotask::MAX
        ),
        Heroes_macrotask::MACRO_TASK_MOVE => array(
            'type' => 'int',
            'default' => 10,
            'min' =>  Heroes_macrotask::MIN,
            'max' =>  Heroes_macrotask::MAX
        ),
        Heroes_macrotask::MACRO_TASK_RUNES => array(
            'type' => 'int',
            'default' => 10,
            'min' =>  Heroes_macrotask::MIN,
            'max' =>  Heroes_macrotask::MAX
        ),
        Heroes_macrotask::MACRO_TASK_SCOUT => array(
            'type' => 'int',
            'default' => 10,
            'min' =>  Heroes_macrotask::MIN,
            'max' =>  Heroes_macrotask::MAX
        ),
        Heroes_macrotask::MACRO_TASK_BAIT => array(
            'type' => 'int',
            'default' => 10,
            'min' =>  Heroes_macrotask::MIN,
            'max' =>  Heroes_macrotask::MAX
        ),
        Heroes_macrotask::MACRO_TASK_SIEGE => array(
            'type' => 'int',
            'default' => 10,
            'min' =>  Heroes_macrotask::MIN,
            'max' =>  Heroes_macrotask::MAX
        ),
        Heroes_macrotask::MACRO_TASK_PROTECT => array(
            'type' => 'int',
            'default' => 10,
            'min' =>  Heroes_macrotask::MIN,
            'max' =>  Heroes_macrotask::MAX
        ),
        Heroes_macrotask::MACRO_TASK_FARM => array(
            'type' => 'int',
            'default' => 10,
            'min' =>  Heroes_macrotask::MIN,
            'max' =>  Heroes_macrotask::MAX
        ),
        Heroes_macrotask::MACRO_TASK_DEFEND => array(
            'type' => 'int',
            'default' => 10,
            'min' =>  Heroes_macrotask::MIN,
            'max' =>  Heroes_macrotask::MAX
        ),
        Heroes_macrotask::MACRO_TASK_ATTACK => array(
            'type' => 'int',
            'default' => 10,
            'min' =>  Heroes_macrotask::MIN,
            'max' =>  Heroes_macrotask::MAX
        ),
        Heroes_macrotask::MACRO_TASK_PUSH => array(
            'type' => 'int',
            'default' => 10,
            'min' =>  Heroes_macrotask::MIN,
            'max' =>  Heroes_macrotask::MAX
        ),
        Heroes_macrotask::MACRO_TASK_ROSHAN => array(
            'type' => 'int',
            'default' => 10,
            'min' =>  Heroes_macrotask::MIN,
            'max' =>  Heroes_macrotask::MAX
        ),
        Heroes_macrotask::MACRO_TASK_ROSHAN_PROTECT => array(
            'type' => 'int',
            'default' => 10,
            'min' =>  Heroes_macrotask::MIN,
            'max' =>  Heroes_macrotask::MAX
        ),
        Heroes_macrotask::MACRO_TASK_TEAMFIGHT => array(
            'type' => 'int',
            'default' => 10,
            'min' =>  Heroes_macrotask::MIN,
            'max' =>  Heroes_macrotask::MAX
        ),
        Heroes_macrotask::MACRO_TASK_CARRY_LATE_TEMPO => array(
            'type' => 'int',
            'default' => 10,
            'min' =>  Heroes_macrotask::MIN,
            'max' =>  Heroes_macrotask::MAX
        ),
        Heroes_macrotask::MACRO_TASK_CARRY_EARLY_TEMPO => array(
            'type' => 'int',
            'default' => 10,
            'min' =>  Heroes_macrotask::MIN,
            'max' =>  Heroes_macrotask::MAX
        ),
    );


    /**
     * @param $data = array( [Xi] => [Yi] ). Xi - role, Yi => role_id
     *
     * not safe!
     */
    public static function get_data_for_team_power( $data )
    {
        $where = '';
        foreach ( $data as $role => $role_id )
        {
            $where .= "(`id` = $role_id AND `role` = $role ) OR";
        }

        return \DB::exec('SELECT
            `role`,
            `teamfight`, `roshan`, `push`, `farm`, `defend`, `attack`, `siege`, `protect`, 
            `laning`, `carry_early_tempo`, `carry_mid_tempo`, `carry_late_tempo`
        FROM `' . self::$table_name . '`
        WHERE
            (
                ' . substr( $where, 0, -2  ) . '
             )
        ')->rows('role');
    }

    public static function get_by_hero_id( $hero_id, $access )
    {
        return \DB::exec('SELECT
            `t1`.*, 
            `t2`.`content`
            FROM 
                `' . self::$table_name  . '` as `t1`
            LEFT JOIN
                `' . \DB\DOTA_2\Heroes_role_data::$table_name . '` as `t2` ON
                    `t1`.`id` = `t2`.`role_id` AND
                    `t2`.`lang` = %s
            WHERE 
                `t1`.`hero_id` = %d ' .
            ( $access ? '' :  'AND `t1`.`visible` = 1 ' ).
            'ORDER BY 
                `t1`.`popularity` DESC
        ', \Localka::$lang, $hero_id )->rows('id');
    }

    public static function get_all_heroes_roles( )
    {
        return \DB::exec('SELECT
        `t1`.`*`,
        `t2`.`name`, `t2`.`url`
        FROM
            ' . self::$table_name .' as `t1`
        INNER JOIN
            ' . \DB\DOTA_2\Heroes::$table_name . ' as `t2` ON
                `t1`.`hero_id` = `t2`.`id` AND
                `t1`.`disabled` = 0
        ORDER BY `hero_id` ASC, `role` ASC
        ')->rows();
    }

    public static function get_all_heroes_roles_by_marcrotask( $macrotask )
    {
        return \DB::exec('SELECT
        `t1`.`id`, `t1`.`role`, `t1`.`' . $macrotask . '` as `macrotask`,
        `t2`.`name`, `t1`.`type` , `t2`.`url`
        FROM
            ' . self::$table_name .' as `t1`
        INNER JOIN
            ' . \DB\DOTA_2\Heroes::$table_name . ' as `t2` ON
                `t1`.`hero_id` = `t2`.`id` AND
                `t1`.`disabled` = 0
        ORDER BY `hero_id` ASC, `role` ASC
        ')->rows();
    }

    public static function get_by_role_id( $id )
    {
       /* return \DB::exec('SELECT
        `t1`.`id`, `t1`.`role`, `t1`.`' . $macrotask . '` as `macrotask`,
        `t2`.`name`, `t2`.`url`
        FROM
            ' . self::$table_name .' as `t1`
        INNER JOIN
            ' . \DB\DOTA_2\Heroes::$table_name . ' as `t2` ON
                `t1`.`hero_id` = `t2`.`id` AND
                `t1`.`disabled` = 0
        ORDER BY `hero_id` ASC, `role` ASC
        ')->rows();*/
    }

    public static function get_random_heroes( $hero_count  )
    {
        return \DB::exec('SELECT
        `t1`.`*`,
        `t2`.`name`, `t2`.`url`
        FROM
            ' . self::$table_name .' as `t1`
        INNER JOIN
            ' . \DB\DOTA_2\Heroes::$table_name . ' as `t2` ON
                `t1`.`hero_id` = `t2`.`id` AND
                `t1`.`disabled` = 0
        ORDER BY RAND()
        LIMIT 0,%d
        ', $hero_count)->rows();
    }
}