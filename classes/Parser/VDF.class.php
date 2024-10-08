<?php
namespace Parser;
class VDF extends \Parser
{
    public function compile()
    {
        // detect and convert utf-16, utf-32 and convert to utf8
        if      (substr($this->loaded_data, 0, 2) == "\xFE\xFF")         $this->loaded_data = mb_convert_encoding($this->loaded_data, 'UTF-8', 'UTF-16BE');
        else if (substr($this->loaded_data, 0, 2) == "\xFF\xFE")         $this->loaded_data = mb_convert_encoding($this->loaded_data, 'UTF-8', 'UTF-16LE');
        else if (substr($this->loaded_data, 0, 4) == "\x00\x00\xFE\xFF") $this->loaded_data = mb_convert_encoding($this->loaded_data, 'UTF-8', 'UTF-32BE');
        else if (substr($this->loaded_data, 0, 4) == "\xFF\xFE\x00\x00") $this->loaded_data = mb_convert_encoding($this->loaded_data, 'UTF-8', 'UTF-32LE');

        // strip BOM
        $this->loaded_data = preg_replace('/^[\xef\xbb\xbf\xff\xfe\xfe\xff]*/', '', $this->loaded_data);

        $lines = preg_split('/\n/', $this->loaded_data);

        $this->compiled_data = array();
        $stack = array(0=>&$this->compiled_data);
        $expect_bracket = false;
        $name = "";

        $re_keyvalue = '~^("(?P<qkey>(?:\\\\.|[^\\\\"])+)"|(?P<key>[a-z0-9\\-\\_]+))' .
            '([ \t]*(' .
            '"(?P<qval>(?:\\\\.|[^\\\\"])*)(?P<vq_end>")?' .
            '|(?P<val>[a-z0-9\\-\\_]+)' .
            '))?~iu';

        $j = count($lines);
        for($i = 0; $i < $j; $i++) {
            $line = trim($lines[$i]);

            // skip empty and comment lines
            if( $line == "" || $line[0] == '/') { continue; }

            // one level deeper
            if( $line[0] == "{" ) {
                $expect_bracket = false;
                continue;
            }

            if($expect_bracket) {
                trigger_error("vdf_decode: invalid syntax, expected a '}' on line " . ($i+1), E_USER_NOTICE);
                return Null;
            }

            // one level back
            if( $line[0] == "}" ) {
                array_pop($stack);
                continue;
            }

            // nessesary for multiline values
            while(True) {
                preg_match($re_keyvalue, $line, $m);

                if(!$m) {
                    trigger_error("vdf_decode: invalid syntax on line " . ($i+1), E_USER_NOTICE);
                    return NULL;
                }

                $key = (isset($m['key']) && $m['key'] !== "")
                    ? $m['key']
                    : $m['qkey'];
                $val = (isset($m['qval']) && (!isset($m['vq_end']) || $m['vq_end'] !== ""))
                    ? $m['qval']
                    : (isset($m['val']) ? $m['val'] : False);

                if($val === False) {
                    // chain (merge*) duplicate key
                    if(!isset($stack[count($stack)-1][$key])) {
                        $stack[count($stack)-1][$key] = array();
                    }
                    $stack[count($stack)] = &$stack[count($stack)-1][$key];
                    $expect_bracket = true;
                }
                else {
                    // if don't match a closing quote for value, we consome one more line, until we find it
                    if(!isset($m['vq_end']) && isset($m['qval'])) {
                        $line .= "\n" . $lines[++$i];
                        continue;
                    }

                    $stack[count($stack)-1][$key] = $val;
                }
                break;
            }
        }

        if(count($stack) !== 1)  {
            trigger_error("vdf_decode: open parentheses somewhere", E_USER_NOTICE);
            return NULL;
        }

        return $this;
    }

    public function parse_abilities()
    {
        $file_lang = mb_strtolower( $this->compiled_data['lang']['Language'] );
        foreach ( \Localka::$settings as $lang_key => $row )
        {
            if ( $row['language'] == $file_lang )
            {
                $language = $lang_key ;
                break;
            }
        }

        if ( is_null( $language ) )
        {
            throw new \Exception\Fatal( 'no language found' );
        }

        //DOTA_Tooltip_modifier_alchemist_scepter_bonus_damage_Description
        //DOTA_Tooltip_ability_skywrath_mage_mystic_flare_aghanim_description
        //DOTA_Tooltip_ability_skywrath_mage_arcane_bolt_aghanim_description
        //DOTA_Tooltip_ability_meepo_divided_we_stand_aghanim_description:Добавляет дополнительного клона.

        $ability_data = \DB\DOTA_2\Abilities::select( array('id' , 'hero_id' , 'system_name') , array( 'hero_id' => array( null , 'IS NOT' ) ) )->rows('system_name');
        $hero_data = \DB\DOTA_2\Heroes::select( array('id' , 'system_image_name' => 'name' ) )->rows('id');


        $update_aghs = array();
        $update_abilities = array();


        //terrorblade_terror_wave
        //grimstroke_scepter

        //snapfire and clinks aghs
        if ( $language == \Localka::RU )
        {
            $this->compiled_data['lang']['Tokens']['DOTA_Tooltip_ability_terrorblade_terror_wave_Description'] = 'Герой выпускает круговую волну, заставляющую задетых врагов бежать в страхе.';
            $this->compiled_data['lang']['Tokens']['DOTA_Tooltip_ability_snapfire_gobble_up_aghanim_description'] = 'Проглатывает крипа или союзного героя, чтобы затем плюнуть им во врагов. Цель может сидеть в животике не более 3 секунд.';
            $this->compiled_data['lang']['Tokens']['DOTA_Tooltip_ability_clinkz_burning_army_aghanim_description'] = "Герой призывает армию огненных скелетов-лучников. Лучники неподвижны и умирают от 2 aатак героев. Скелеты используют способность Searing Arrows текущего уровня и атакуют только героев. Их базовый урон равен 30% от базового урона вашего героя. Их дальность атаки равна дальности атаки вашего героя.";
        }
        else
        {
            $this->compiled_data['lang']['Tokens']['DOTA_Tooltip_ability_terrorblade_terror_wave_Description'] = 'Makes a wave travel outwards in all directions causing enemy heroes to become feared upon impact.';
            $this->compiled_data['lang']['Tokens']['DOTA_Tooltip_ability_snapfire_gobble_up_aghanim_description'] = 'Mortimer gobbles up a creep or an allied hero, which he can then spit towards enemies. The unit stays in his belly up to 3 seconds.';
            $this->compiled_data['lang']['Tokens']['DOTA_Tooltip_ability_clinkz_burning_army_aghanim_description'] = "Clinkz summons an army of fiery ranged skeleton archers. Archers are immobile and die with 2 attacks from a hero. Skeletons deal a percentage of Clinkz' damage, use his current Searing Arrows ability and attack only heroes. Attack range is equal to Clinkz's attack range.";
        }

        //wtf slark?
        unset( $this->compiled_data['lang']['Tokens']['DOTA_Tooltip_ability_slark_shadow_dance_aghanim_description'] );


        foreach ( $this->compiled_data['lang']['Tokens'] as $key => $value )
        {
            $key = str_replace( 'DOTA_Tooltip_ability_' , '' , $key, $count );
            if ( !empty ( $count ) )
            {
                //aghanim_description
                //Description
                if ( mb_stripos( $key, '_aghanim_description' ) !== FALSE )
                {
                    $key = str_ireplace( '_aghanim_description' , '', $key );
                    if ( isset( $ability_data[ $key ] ) )
                    {
                        $value = strip_tags( $value , '<font><br>' );
                        $value = str_replace('%%' , '%' , $value);
                        $value = str_replace('\n' , '</br>' , $value);
                        $value = preg_replace_callback('/\%[^% ]+\%/' , function() { return '<i>const</i>'; } , $value);
                        $hero_data[ $ability_data[ $key ]['hero_id'] ]['aghanim_description'][ $ability_data[ $key ]['id'] ] = $value ;
                    }
                }
                elseif ( mb_stripos( $key , '_Description') !== FALSE  || mb_strpos( $key , '_description') !== FALSE )
                {
                    $key = str_ireplace( '_description' , '', $key );
                    if ( isset( $ability_data[ $key ] ) )
                    {
                        $value = strip_tags( $value , '<font><br>' );
                        $value = str_replace('%%' , '%' , $value);
                        $value = str_replace('\n' , '</br>' , $value);
                        $value = preg_replace_callback('/\%[^% ]+\%/' , function() { return '<i>const</i>'; } , $value);
                        $ability_data[ $key ]['description'] = $value ;
                    }
                }
                else
                {

                }
            }

        }


        try
        {
            \DB::transaction();

            \DB\DOTA_2\Heroes_aghanim::delete( array('lang' => $language ) );

            foreach ( $hero_data as $key => $row )
            {
                foreach ( $row['aghanim_description'] as $ability_id => $value )
                {
                    \DB\DOTA_2\Heroes_aghanim::insert( array(
                        'hero_id' => $key,
                        'lang' => $language,
                        'ability_id' => $ability_id,
                        'effect' => $value
                    ));
                }
            }


            \DB\DOTA_2\Abilities_description::delete( array('lang' => $language ) );

            foreach ( $ability_data as $key => $row )
            {
                \DB\DOTA_2\Abilities_description::insert( array(
                    'ability_id' => $row['id'],
                    'lang' => $language,
                    'text' => $row['description']
                ));
            }


            \DB::commit();
        }
        catch ( \Exception $e )
        {
            \DB::rollback();
            throw new \Exception\Fatal( $e->getMessage() );
        }



    }



}