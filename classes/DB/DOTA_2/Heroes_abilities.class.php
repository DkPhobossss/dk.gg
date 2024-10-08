<?php

namespace DB\DOTA_2;
use DB;
use DOTA_2\API;

class Heroes_abilities extends DB\Table
{
    static $table_name = 'dota_2_heroes_abilities';

    public static function get_by_hero_id( $id )
    {
        return \DB::exec( 'SELECT 
        `t3`.`text` as `description`, `t2`.`id`,
        `t2`.`name`, `t2`.`dmg_type`, `t2`.`mc`,`t2`.`cd`,`t2`.`img`, `t2`.`system_name`, `t2`.`dmg`, `t2`.`bkbpierce`
        FROM
        `' . self::$table_name . '` as `t1`
        LEFT JOIN `' . DB\DOTA_2\Abilities::$table_name . '` as `t2` ON
            `t1`.`ability_id` = `t2`.`id`
        INNER JOIN`' . DB\DOTA_2\Abilities_description::$table_name . '` as `t3` ON
            `t3`.`ability_id` = `t2`.`id` AND
            `t3`.`lang` = %s
        WHERE `t2`.`hero_id` = %d
        ORDER BY 
            `t1`.`base_skill` DESC, 
            `t1`.`ultimate` ASC' , \Localka::$lang, $id )->rows('id');
    }

}