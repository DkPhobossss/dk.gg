<?php

namespace DOTA_2;


class Skill
{
    public static function image( $name, $url )
    {
        return '<img class="dota_2_ability" src="' . $url .'" alt="' . $name . '" title="' . $name . '"  />';
    }

    public static function synchronize()
    {
        $data = API::get_skills();

        foreach ( $data as $ability_name => &$row )
        {
            if ( isset( $row['img']) )
            {
                $row['img'] = 'http://cdn.dota2.com' . $row['img'];
            }

            if ( isset( $row['hero_id'] ) )
            {
                $row[ 'ultimate' ] = 0;
                $row[ 'base' ] = 0;
                if ( !empty( $row['attrib']) )
                {
                    foreach ( $row['attrib'] as $options )
                    {
                        if ( isset( $options['value'] ) && is_array( $options['value'] ) )
                        {
                            $size = sizeof( $options['value'] );
                            if ( $size == 4 )
                            {
                                $row[ 'ultimate' ] = 0;
                                $row[ 'base' ] = 1;
                                break;
                            }
                            elseif ( $size == 3 )
                            {
                                $row[ 'ultimate' ] = 1;
                                $row[ 'base' ] = 0;
                                break;
                            }
                        }
                    }
                }

                //still dont know?
                if ( ( $row[ 'ultimate' ] == 0 ) && ( $row[ 'ultimate' ] == 0 ) )
                {
                    foreach ( array('mc', 'cd', 'dmg') as $ability_key )
                    {
                        if (isset($row[$ability_key]) && is_array($row[$ability_key]))
                        {
                            $size = sizeof($row[$ability_key]);
                            if ($size == 4)
                            {
                                $row['ultimate'] = 0;
                                $row['base'] = 1;
                                break;
                            }
                            elseif ($size == 3)
                            {
                                $row['ultimate'] = 1;
                                $row['base'] = 0;
                                break;
                            }
                        }
                    }
                }

            }
        }
        unset( $row );

        //  missing icons
        $data['arc_warden_scepter']['img'] = 'https://gamepedia.cursecdn.com/dota2_gamepedia/b/b9/Rune_Forge_icon.png';
        $data['grimstroke_scepter']['img'] = 'https://gamepedia.cursecdn.com/dota2_gamepedia/4/4d/Dark_Portrait_icon.png';
        $data['juggernaut_swift_slash']['img'] = 'https://gamepedia.cursecdn.com/dota2_gamepedia/9/96/Swiftslash_icon.png';
        $data['kunkka_torrent_storm']['img'] = 'https://gamepedia.cursecdn.com/dota2_gamepedia/a/ad/Torrent_Storm_icon.png';
        $data['lycan_wolf_bite']['img'] = 'https://gamepedia.cursecdn.com/dota2_gamepedia/8/8b/Wolf_Bite_icon.png';
        $data['pudge_eject']['img'] = 'https://gamepedia.cursecdn.com/dota2_gamepedia/1/16/Eject_%28Pudge%29_icon.png';
        $data['rattletrap_overclocking']['img'] = 'https://gamepedia.cursecdn.com/dota2_gamepedia/3/3f/Overclocking_icon.png';
        $data['snapfire_gobble_up']['img'] = 'https://gamepedia.cursecdn.com/dota2_gamepedia/4/4e/Gobble_Up_icon.png';
        $data['snapfire_spit_creep']['img'] = 'https://gamepedia.cursecdn.com/dota2_gamepedia/8/88/Spit_Out_icon.png';
        $data['terrorblade_terror_wave']['img'] = 'https://gamepedia.cursecdn.com/dota2_gamepedia/5/5e/Terror_Wave_icon.png';
        $data['visage_stone_form_self_cast']['img'] = 'https://gamepedia.cursecdn.com/dota2_gamepedia/2/20/Stone_Form_%28Familiar%29_icon.png';
        $data['generic_hidden']['img'] = 'http://cdn.dota2.com/apps/dota2/images/abilities/doom_bringer_empty1_md.png';
        $data['rubick_hidden2']['img'] = 'http://cdn.dota2.com/apps/dota2/images/abilities/doom_bringer_empty1_md.png';
        $data['rubick_hidden1']['img'] = 'http://cdn.dota2.com/apps/dota2/images/abilities/doom_bringer_empty1_md.png';
        $data['morphling_morph']['img'] = 'https://gamepedia.cursecdn.com/dota2_gamepedia/9/9f/Morph_Replicate_icon.png';
        $data['monkey_king_primal_spring_early']['img'] = 'http://cdn.dota2.com/apps/dota2/images/abilities/monkey_king_primal_spring_md.png';

        //INVOKER
        //7845, invoker_ice_wall_ad Ice Wall (AD)
        //

        try
        {
            \DB::transaction();

            \DB\DOTA_2\Abilities::truncate( true );
            \DB\DOTA_2\Heroes_abilities::truncate( true );

            foreach ( $data as $ability_name => $row )
            {
                if ( isset( $row['dname']) )
                {
                    \DB\DOTA_2\Abilities::insert( array(
                        'id' => $row['id'],
                        'system_name' => $ability_name,
                        'name' => \Input::custom( $row, 'dname' ),
                        'behavior' => ( empty( $row['behavior'] ) ? null : json_encode( $row['behavior']) ) ,
                        'dmg_type' => \Input::custom( $row, 'dmg_type' ),
                        'bkbpierce' => ( empty( $row[ 'bkbpierce' ] ) ? null : ( $row['bkbpierce'] == 'Yes' ? 1 : 0 ) ),
                        'description' => \Input::custom( $row, 'desc' ),
                        'attrib' => ( empty( $row['attrib'] ) ? null : json_encode( $row['attrib']) ) ,
                        'dmg' => ( empty( $row['dmg'] ) ? null : json_encode( $row['dmg']) ) ,
                        'mc' => ( empty( $row['mc'] ) ? null : json_encode( $row['mc']) ) ,
                        'cd' => ( empty( $row['cd'] ) ? null : json_encode( $row['cd']) ),
                        'hero_id' => \Input::custom( $row, 'hero_id' ),
                        'img' => \Input::custom( $row, 'img' )
                    ) );

                    if ( isset( $row['hero_id']) )
                    {
                        \DB\DOTA_2\Heroes_abilities::insert(array(
                            'hero_id' => $row['hero_id'],
                            'ability_id' => $row['id'],
                            'ultimate' => $row['ultimate'],
                            'base_skill' => $row['base'],
                        ));
                    }
                }
            }

            \DB::commit();
        }
        catch ( \Exception $e )
        {
            \DB::rollback();
            throw new \Exception\Fatal( $e->getMessage() );
        }

        return true;
    }


    //public static function update_localizations
}