<?php

namespace DB\DOTA_2;
use DB;
use DOTA_2\API;

class Heroes extends DB\Table
{
    static $table_name = 'dota_2_heroes';

    public static function create_list()
    {
        $data = API::get_heroes();
        try
        {
            DB::transaction();
            foreach ( $data as $row )
            {
                self::insert_ignore(
                    array(
                        'id' => $row['id'],
                        'name' => $row['localized_name'],
                        'system_name' => $row['name']
                    )
                );
            }
            DB::commit();
        }
        catch ( \Exception $e )
        {
            DB::rollback();
            throw new \Exception\Fatal( $e->getMessage() );
        }

        return true;
    }

    public static function get_list()
    {
        return self::select( array( 'id', 'name' , 'primary_attr', 'url' , 'system_image_name'), null, array('primary_attr', 'ASC' , 'name' , 'ASC') )->rows('primary_attr', true);
    }

    public static function get_hero_data( $hero_url )
    {
        return \DB::exec('SELECT
                `t1`.*, 
                `t2`.`description` , 
                `t2`.`seo_title`, 
                `t2`.`seo_description`, 
                `t2`.`seo_keywords`
            FROM `' . self::$table_name .'` as `t1`
            LEFT JOIN `' . \DB\DOTA_2\Heroes_data::$table_name . '` as `t2` ON
                `t1`.`id` = `t2`.`hero_id` AND
                `t2`.`lang` = %s
            WHERE `t1`.`url` = %s
        ' , \Localka::$lang, $hero_url)->row();
    }


    public static function update_url_and_system_name()
    {
        return \DB::exec('UPDATE `' . self::$table_name . '`
                           SET 
                            `url` = REPLACE(`name`," ","_"), 
                            `system_image_name` = REPLACE(`system_name`,"npc_dota_hero_","")
        ');
    }

    public static function get_by_attr( $primary_attribute = null )
    {
        switch ( $primary_attribute )
        {
            case 'str':
            {
                return self::select( array('id', 'url', 'name', 'system_image_name' ,  'str', 'str_inc', 'base_dmg_max', 'base_dmg_min',
                    'start_hp', 'start_hpreg', 'base_hpreg', 'start_dmg_min', 'start_dmg_max'),
                    array('primary_attr' => $primary_attribute),
                    array('name' , 'ASC')
                )->rows();
                break;
            }
            case 'int' :
            {
                return self::select( array('id', 'url', 'name', 'system_image_name' ,  'int', 'int_inc', 'base_dmg_max', 'base_dmg_min',
                    'start_mp', 'start_mpreg', 'base_mpreg', 'start_dmg_min', 'start_dmg_max'),
                    array('primary_attr' => $primary_attribute),
                    array('name' , 'ASC')
                )->rows();
                break;
            }
            case 'agi' :
            {
                return self::select( array('id', 'url', 'name', 'system_image_name' ,  'agi', 'agi_inc', 'base_armor', 'base_as', 'bas', 'base_dmg_min', 'base_dmg_max',
                    'start_armor', 'start_dmg_min', 'start_dmg_max'),
                    array('primary_attr' => $primary_attribute),
                    array('name' , 'ASC')
                )->rows();
                break;
            }
            default :
            {
                return self::select( array('id', 'url', 'name', 'system_image_name' , 'primary_attr', 'str', 'str_inc','agi', 'agi_inc','int', 'int_inc'),
                    null,
                    array('name' , 'ASC')
                )->rows();
            }
        }
    }
}