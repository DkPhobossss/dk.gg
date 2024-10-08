<?php

$this->macrotasks = DB\DOTA_2\Heroes_macrotask::DATA();
$this->macrotask = Input::get('macrotask');


if ( !empty( $this->macrotask ) && empty( $this->macrotasks[ $this->macrotask ]) )
{
    _Error::render( _Error::NOT_FOUND );
}


if ( !empty( $_POST['query']) )
{
    Session::check( 'post' );

    /*farm stacks
    $this->query_data = \DB::exec('SELECT
                r.id as role_id,
                r.role,
                h.`name`, h.ms, h.projectile_speed,
                a.name as a_name,
                a.behavior
                
                FROM `dota_2_heroes_role`  as r
                INNER JOIN `dota_2_heroes` as h
                ON
                r.hero_id = h.id
                LEFT JOIN
                `dota_2_heroes_abilities` as `h_a`
                ON h_a.hero_id = h.id AND 
                    h_a.ultimate = 0
                LEFT JOIN `dota_2_abilities` as a ON
                a.`id` = h_a.ability_id
                WHERE `disabled` = 0')->rows('role_id', true);


     * Stacks farm
     * depends on AOE
     *
     * 5 => 0..2 for range  2..4 for melee
     * 4 => 2..4 for range 4..6 for melee
     * 3 => 6..8 for range 8..10 for melee
     * 2 => 8..10 for range 10..12 for melee
     * 1 => 10..12 for range 12..14 for melee
     * +2 for each aoe
     */

    /* $update = array();
     $dependings = array(
         1 => 10,
         2 => 8,
         3 => 6,
         4 => 2,
         5 => 0,
     );
     foreach ( $this->query_data as $role_id => $abilities )
     {
         $update[ $role_id ] = reset( $abilities );
         $aoe_count = 0;
         foreach ( $abilities as $row )
         {
             $s = json_decode( $row['behavior'] , true );
             if ( !is_array( $s ) )
             {
                 if ( $s == 'AOE' )
                 {
                     $aoe_count++;
                 }
             }
             else
             {
                 foreach ( $s as $value )
                 {
                     if ( $value == 'AOE')
                     {
                         $aoe_count++;
                     }
                 }
             }
         }
         $update[ $role_id ]['aoe_count'] = $aoe_count;
     }


     try
     {
         DB::transaction();
         foreach ( $update as $role_id => $row )
         {
             $macro_task_value = $dependings[ $row['role'] ];
             if ( $row['projectile_speed'] == 0 )
             {
                 $macro_task_value += 2;
             }
             $macro_task_value += $row['aoe_count'] * 2;

             DB\DOTA_2\Heroes_role::update( array( \DB\DOTA_2\Heroes_macrotask::MACRO_TASK_STACK_FARM  => $macro_task_value ) , array('id' => $role_id ) );
         }


         DB::commit();
     }
     catch ( \Exception $e )
     {
         DB::rollback();
         throw new \Exception\Fatal( $e->getMessage() );
     }*/

    /******************* STACKS FARM ENDS *******************/

    /******************* MOVE STARTS *******************/

    /*

    $this->query_data = \DB::exec('SELECT
                r.id as role_id,
                r.role, r.hero_id,
                h.`name`, h.ms, h.projectile_speed    
                FROM `dota_2_heroes_role`  as r
                INNER JOIN `dota_2_heroes` as h
                ON
                r.hero_id = h.id
                WHERE `disabled` = 0')->rows('role_id');

    //ms from 275 to 330, range is usually slower. each 5ms gives + 1
    //if got talent = go +1  Movement Speed

    $talents = DB\DOTA_2\Heroes_talent::select( array( 'hero_id', 'lvl', 'left_talent_value' , 'left_talent_text', 'right_talent_value' , 'right_talent_text' ) ,
        array( 'left_talent_text' => 'Movement Speed', 'OR', 'right_talent_text' => 'Movement Speed' ) )->rows('hero_id');

    try
    {
        DB::transaction();
        foreach ( $this->query_data as $role_id => $row )
        {
            $macrotask_value = ( $row['ms'] - 275 ) / 5;

            if ( isset( $talents[ $row['hero_id'] ] ) )
            {
                $macrotask_value += 1;
            }

            DB\DOTA_2\Heroes_role::update( array( \DB\DOTA_2\Heroes_macrotask::MACRO_TASK_MOVE  => $macrotask_value ) , array('id' => $role_id ) );
        }

        DB::commit();
    }
    catch ( \Exception $e )
    {
        DB::rollback();
        throw new \Exception\Fatal( $e->getMessage() );
    }


    /******************* MOVE ENDS *******************/
    /******************* SCOUT STARTS *******************/

    /*
     * Scout depends on pushing lanes and mobility and roles and vision
     *
     * 1-st not scouting but pushing lanes - 0
     * 2-nd not scouting but pushing lanes - 1
     * 3 pos can scout and 50% push lanes - 2 can reveal by escape - 3
     * 4-st is scouting and 50% ward placer 50% pushing lanes can reveal by escape - 6
     * 5 is hard scout and ward placer but not pushing lanes can reveal by own death - 9
     *
     * score 10 gets support 5 with normal mobility
     * score 0 gets
     *
     * maxim core score gets slark 1800/1800 and ward detecting abilities. Sniper(1400) 18
     *
     */

    /*$dependings = array(
        1 => 0,
        2 => 2,
        3 => 4,
        4 => 6,
        5 => 8,
    );

    $this->query_data = \DB::exec('SELECT
                r.id as role_id,
                r.role, r.hero_id, r.move, r.push,
                h.`name`
                FROM `dota_2_heroes_role`  as r
                INNER JOIN `dota_2_heroes` as h
                ON
                r.hero_id = h.id
                WHERE `disabled` = 0')->rows('role_id');

    try
    {
        DB::transaction();
        foreach ( $this->query_data as $role_id => $row )
        {
            $macrotask_value = $dependings[ $row['role']];
            $macrotask_value += round( ( $row['push'] ) / 2 + $row['move']  / 3 ) - 3;

            DB\DOTA_2\Heroes_role::update( array( \DB\DOTA_2\Heroes_macrotask::MACRO_TASK_SCOUT  => $macrotask_value ) , array('id' => $role_id ) );
        }

        DB::commit();
    }
    catch ( \Exception $e )
    {
        DB::rollback();
        throw new \Exception\Fatal( $e->getMessage() );
    }

    /******************* SCOUT ENDS *******************/



    /******************* RUNES STARTS *******************/
    /**
     * Runes control depends on role and scout/mobility and ability(invis,stun,high dps,tank, annoying ground ability) to fight on rune. also roles
     *
     *
     */

    /**
    $dependings = array(
        1 => 0,
        2 => 2,
        3 => 3,
        4 => 4,
        5 => 3,
    );

    $this->query_data = \DB::exec('SELECT
                r.id as role_id,
                r.role, r.hero_id, r.move, r.scout,
                h.`name`
                FROM `dota_2_heroes_role`  as r
                INNER JOIN `dota_2_heroes` as h
                ON
                r.hero_id = h.id
                WHERE `disabled` = 0')->rows('role_id');

    try
    {
        DB::transaction();
        foreach ( $this->query_data as $role_id => $row )
        {
            $macrotask_value = $dependings[ $row['role']];
            $macrotask_value += round( ( $row['scout'] ) / 4 + $row['move']  / 3 ) - 1;

            //echo $row['name'] . ':' . $macrotask_value . '</br>';

            DB\DOTA_2\Heroes_role::update( array( \DB\DOTA_2\Heroes_macrotask::MACRO_TASK_RUNES  => $macrotask_value ) , array('id' => $role_id ) );
        }

        DB::commit();
    }
    catch ( \Exception $e )
    {
        DB::rollback();
        throw new \Exception\Fatal( $e->getMessage() );
    }



    /******************* RUNES ENDS *******************/
    /******************* BAIT STARTS *******************/


    /**
     * BAIT depends on tanky heroes. bitting on supports is bad idea, same as for initiators(3,2) but good for tanky heroes. counter-initation
     *
     * str => high + 4
     * agi => med + 2
     * int => low + 0
     *
     */

    /**$dependings = array(
        1 => 3,
        2 => 4,
        3 => 6,
        4 => 1,
        5 => 0,
    );

    $attr_dependings = array(
        'str' => 4,
        'agi' => 2,
        'int' => 0
    );

    $this->query_data = \DB::exec('SELECT
                r.id as role_id,
                r.role, r.hero_id, 
                h.`name`, h.primary_attr
                FROM `dota_2_heroes_role`  as r
                INNER JOIN `dota_2_heroes` as h
                ON
                r.hero_id = h.id
                WHERE `disabled` = 0')->rows('role_id');

    try
    {
        DB::transaction();
        foreach ( $this->query_data as $role_id => $row )
        {
            $macrotask_value = $dependings[ $row['role']];
            $macrotask_value += $attr_dependings[ $row['primary_attr'] ];


            //echo $row['name'] . ':' . $macrotask_value . '</br>';

            DB\DOTA_2\Heroes_role::update( array( \DB\DOTA_2\Heroes_macrotask::MACRO_TASK_BAIT  => $macrotask_value ) , array('id' => $role_id ) );
        }

        DB::commit();
    }
    catch ( \Exception $e )
    {
        DB::rollback();
        throw new \Exception\Fatal( $e->getMessage() );
    }


    /******************* BAIT ENDS *******************/

    /******************* TOWER DESTROY STARTS **********/

    /**
     * Basically its core-heroes macrotask usually the hero which is bad for bait is bad for tower taking
     * The heroes who can push lanes good or have good tempo also good at tower taking. For range heroes is better.
     * INT heroes are usually not good for killing towers
     */

    /**

    $dependings = array(
        1 => 5,
        2 => 4,
        3 => 2,
        4 => 1,
        5 => 0,
    );

    $attr_dependings = array(
        'str' => 2,
        'agi' => 4,
        'int' => 0
    );

    $this->query_data = \DB::exec('SELECT
                r.id as role_id,
                r.role, r.bait, r.push,
                h.`name`, h.primary_attr, h.projectile_speed, h.attack_range
                FROM `dota_2_heroes_role`  as r
                INNER JOIN `dota_2_heroes` as h
                ON
                r.hero_id = h.id
                WHERE `disabled` = 0')->rows('role_id');

    try
    {
        DB::transaction();
        foreach ( $this->query_data as $role_id => $row )
        {
            $macrotask_value = $dependings[ $row['role']];
            $macrotask_value += $attr_dependings[ $row['primary_attr'] ];

            if ( $row['projectile_speed'] != 0 && $row['role'] <= 3 && $row['attack_range'] >= 400 )
            {
                $macrotask_value += ceil( ( $row['attack_range'] - 300 ) / 100 );
            }

            $macrotask_value += round( ( $row['push'] ) / 7 );
            $macrotask_value += ceil( ( $row['bait'] - 20 ) / 7 );

            $macrotask_value += 2;

            //echo $row['name'] . ':' . $macrotask_value . '</br>';

            DB\DOTA_2\Heroes_role::update( array( \DB\DOTA_2\Heroes_macrotask::MACRO_TASK_SIEGE  => $macrotask_value ) , array('id' => $role_id ) );
        }

        DB::commit();
    }
    catch ( \Exception $e )
    {
        DB::rollback();
        throw new \Exception\Fatal( $e->getMessage() );
    }


    /******************* TOWER DESTROY ENDS **********/
    /******************* TEAM FIGHT ENDS **********/

    /**
     * TEAM FIGHT the higher position is the better is TF. but pos-2 and pos-3 is better than pos-1
     * 3 2 5 1 4
     */

    /**

    $dependings = array(
        1 => 0,
        2 => 2,
        3 => 3,
        4 => 1,
        5 => 0,
    );

    $attr_dependings = array(
        'str' => 2,
        'agi' => 0,
        'int' => 3
    );

    $this->query_data = \DB::exec('SELECT
    r.id as role_id,
    r.role, r.siege, r.bait, r.push,
    h.`name`, h.primary_attr, h.projectile_speed, h.attack_range
    FROM `dota_2_heroes_role`  as r
    INNER JOIN `dota_2_heroes` as h
    ON
    r.hero_id = h.id
    WHERE `disabled` = 0')->rows('role_id');

    try
    {
        DB::transaction();
        foreach ( $this->query_data as $role_id => $row )
        {
            $macrotask_value = $dependings[ $row['role']];
            $macrotask_value += $attr_dependings[ $row['primary_attr'] ];

            //if ( $row['projectile_speed'] != 0 && $row['role'] <= 3 && $row['attack_range'] >= 400 )
            //{
            //    $macrotask_value += ceil( ( $row['attack_range'] - 300 ) / 100 );
            //}

            $macrotask_value += round( ( $row['siege']  / 7 ) + ($row['bait']  / 7 ) + ( $row['push'] / 10 ) );


            //$macrotask_value = $macrotask_value - 1;

            //max 13
            $macrotask_value = round( $macrotask_value * 20 / 11 );


            //echo $row['name'] . ':' . $macrotask_value . '</br>';

            DB\DOTA_2\Heroes_role::update( array( \DB\DOTA_2\Heroes_macrotask::MACRO_TASK_TEAMFIGHT  => $macrotask_value ) , array('id' => $role_id ) );
        }

        DB::commit();
    }
    catch ( \Exception $e )
    {
        DB::rollback();
        throw new \Exception\Fatal( $e->getMessage() );
    }


    /******************* TEAM FIGHT ENDS **********/
    /******************* TOWER DEFENSE STARTS  **********/

    /**
     *  Tower defense depends on hero role. Basically cores with low early tempo are bad and cores with low tf
     *  Supports usuall deds tower, who can reagro creeps atleast
     *  lich,treant +  sniper pos-1(2), zeus, warden
     *
     * range support is good. melee pos-3 is good
     * if hero can split - he's actually good tower defender.
     */

    /**

    $dependings = array(
        1 => 0,
        2 => 2,
        3 => 4,
        4 => 3,
        5 => 3,
    );

    $attr_dependings = array(
        'str' => 2,
        'agi' => 0,
        'int' => 2
    );

    $this->query_data = \DB::exec('SELECT
    r.id as role_id,
    r.role, r.teamfight,
    h.`name`, h.primary_attr, h.projectile_speed, h.attack_range
    FROM `dota_2_heroes_role`  as r
    INNER JOIN `dota_2_heroes` as h
    ON
    r.hero_id = h.id
    WHERE `disabled` = 0')->rows('role_id');

    try
    {
        DB::transaction();
        foreach ( $this->query_data as $role_id => $row )
        {
            $macrotask_value = $dependings[ $row['role']];
            $macrotask_value += $attr_dependings[ $row['primary_attr'] ];

            if ( $row['projectile_speed'] != 0 && $row['role'] > 3 && $row['attack_range'] >= 500 )
            {
                $macrotask_value += 2;
            }

            if ( $row['projectile_speed'] == 0 && $row['role'] == 3 )
            {
                $macrotask_value += 2;
            }

            $macrotask_value += round( ( $row['teamfight']  / 10 ) );

            //max 13
            $macrotask_value = $macrotask_value * 2;


            //echo $row['name'] . ':' . $macrotask_value . '</br>';

            DB\DOTA_2\Heroes_role::update( array( \DB\DOTA_2\Heroes_macrotask::MACRO_TASK_PROTECT  => $macrotask_value ) , array('id' => $role_id ) );
        }

        DB::commit();
    }
    catch ( \Exception $e )
    {
        DB::rollback();
        throw new \Exception\Fatal( $e->getMessage() );
    }


    /******************* TEAM FIGHT ENDS **********/

    /******************* HERO SAVE STARTS  **********/

    /**
     *  SAVE
     *  usually its int heroes from pos 5 tp 1
     */

    /**

    $dependings = array(
        1 => 0,
        2 => 0,
        3 => 0,
        4 => 0,
        5 => 2,
    );


    $this->query_data = \DB::exec('SELECT
    r.id as role_id,
    r.role, r.teamfight,
    h.`name`, h.primary_attr, h.projectile_speed, h.attack_range
    FROM `dota_2_heroes_role`  as r
    INNER JOIN `dota_2_heroes` as h
    ON
    r.hero_id = h.id
    WHERE `disabled` = 0')->rows('role_id');

    try
    {
        DB::transaction();
        foreach ( $this->query_data as $role_id => $row )
        {
            $macrotask_value = $dependings[ $row['role']];

            if ( $row['primary_attr'] == 'int' )
            {
                if ( $row['role'] == 3 )
                {
                    $macrotask_value += 2;
                }
                elseif ( $row['role'] > 3 )
                {
                    $macrotask_value += 4;
                }

            }
            elseif ( $row['primary_attr'] == 'str' )
            {
                if ( $row['role'] == 3 )
                {
                    $macrotask_value += 1;
                }
                elseif ( $row['role'] > 3 )
                {
                    $macrotask_value += 2;
                }
            }


            //echo $row['name'] . ':' . $macrotask_value . '</br>';

            DB\DOTA_2\Heroes_role::update( array( \DB\DOTA_2\Heroes_macrotask::MACRO_TASK_DEFEND  => $macrotask_value ) , array('id' => $role_id ) );
        }

        DB::commit();
    }
    catch ( \Exception $e )
    {
        DB::rollback();
        throw new \Exception\Fatal( $e->getMessage() );
    }


    /******************* HERO SAVE ENDS **********/
}


if ( !empty( $_POST['role'] ) )
{
    //Session::check('post');
    $this->affected_rows = 0;
    try
    {
        DB::transaction();
        foreach ( $_POST['role'] as $id => $macrotask_value )
        $this->affected_rows += DB\DOTA_2\Heroes_role::update( array( $this->macrotask => $macrotask_value ), array('id' => $id ) );

        DB::commit();
    }
    catch ( \Exception $e )
    {
        DB::rollback();
        throw new \Exception\Fatal( $e->getMessage() );
    }
}

if ( !empty( $this->macrotask ) )
{
    $this->data = DB\DOTA_2\Heroes_role::get_all_heroes_roles_by_marcrotask( $this->macrotask );
}

$this->roles_description = \DOTA_2\Hero::roles();


