<?= Output::js( 'js/highcharts' )?>
<?= Output::seo( $this->data )?>

<?= Template::content_DEFAULT( !isset( $this->role ) ? $this->data['name'] : ( $this->data['name']. ', ' . $this->roles_description[ $this->roles[ $this->role ]['role'] ]['name'] ), $this) ?>

<? $this->js(); ?>

<div class="row branching_next" id="first">
    <script type="text/javascript">
        var ATTRIBUTE_GROWTH = <?= \DOTA_2\Hero::attribute_growth_json()?>;
        var HERO = {
            base_hp_reg : <?= $this->data ['base_hpreg'] ?>,
            base_mp_reg : <?= $this->data ['base_mpreg'] ?>,
            primary_attribute : '<?= $this->data ['primary_attr'] ?>',
            str_base : <?= $this->data[ 'str' ] ?>,
            str_inc : <?= $this->data[ 'str_inc' ] ?>,
            agi_base : <?= $this->data[ 'agi' ] ?>,
            agi_inc : <?= $this->data[ 'agi_inc' ] ?>,
            int_base : <?= $this->data[ 'int' ] ?>,
            int_inc : <?= $this->data[ 'int_inc' ] ?>,
            base_dmg_min : <?= $this->data[ 'base_dmg_min' ] ?>,
            base_dmg_max : <?= $this->data[ 'base_dmg_max' ] ?>,
            base_as : <?= $this->data[ 'base_as' ] ?>,
            bas : <?= $this->data[ 'bas' ] ?>,
            base_armor : <?= $this->data[ 'base_armor' ] ?>,
            attack_range : <?= $this->data['attack_range'] ?>,
            magic_resist : <?= $this->data[ 'magic_resist' ] ?>,
            ms : <?= $this->data[ 'ms' ] ?>,
            hp : 0,
            mp: 0,
            hp_reg : 0,
            mp_reg : 0,
            armor : 0,
            str : 0,
            int : 0,
            agi : 0,
            as : 0,
            dmg_min : 0,
            dmg_max : 0,
            BASE_HP : <?= \DOTA_2\Hero::BASE_HP ?>,
            BASE_MP : <?= \DOTA_2\Hero::BASE_MP ?>,
            TALENT_STATS : null
        }
    </script>

    <div class="hero_data">
        <div class="introdution">
            <div class="container">
                <div class="avatar">
                    <div class="relative">
                        <?= DOTA_2\Hero::avatar_vertical_html( $this->data ['name'], $this->data['system_image_name']  )?>
                        <img id="talents" tooltip_data='{"interactive":true,"side":"top","trigger":"click","theme":"dota_tooltip","arrow":false}' class="tooltip" data-tooltip-content="#talents_content" src="<?= Config::$static_url?>images/dota_2/talent.png" alt="<?=('Talents')?>" title="<?=('Talents')?>"/>
                        <div id="lvl_container">
                            <div id="lvl_up">+</div>
                            <div id="lvl">1</div>
                            <div id="lvl_down">–</div>
                        </div>
                    </div>
                    <div class="hp" reg="<?= $this->data ['start_hpreg'] ?>">
                        <?= $this->data ['start_hp'] ?> / <?= $this->data ['start_hp'] ?>
                    </div>
                    <div class="mp" reg="<?= $this->data ['start_mpreg'] ?>">
                        <?= $this->data ['start_mp'] ?> / <?= $this->data ['start_mp'] ?>
                    </div>
                </div>

                <div class="stats">
                    <div class="attributes">
                        <div class="title"><a href="learn/glossarij/primary_attributes"><?=__('Base_stats')?></a></div>
                        <? foreach ( array( 'str' => array('text' => __('Strength'), 'url' => 'strength' ),
                                         'agi' => array( 'text' => __('Agility'), 'url' => 'agility' ) ,
                                         'int' => array( 'text' => __('Intelligence'), 'url' => 'intelligence' ) )
                         as $key => $row ) :?>
                            <div class="item <?= ( $this->data['primary_attr'] == $key ? 'primary' : '' )?>">
                                <span>
                                    <span id="<?= $key ?>"><?= $this->data[ $key ] ?></span> + <?= $this->data[ $key . '_inc' ] ?>
                                </span>
                                <a href="learn/glossarij/<?= $row['url']?>">
                                    <img alt="<?= $row['text'] ?>" title="<?= $row['text'] ?>"  src="<?= Config::$static_url?>images/dota_2/<?= $key ?>.png"   />
                                </a>
                            </div>
                        <? endforeach; ?>
                    </div>

                    <div class="attack">
                        <div class="title"><?=__('Attack_stats')?></div>
                        <div class="item">
                            <span>
                                <span id="start_dmg_min"><?= $this->data[ 'start_dmg_min' ] ?></span> - <span id="start_dmg_max"><?= $this->data[ 'start_dmg_max' ] ?></span>
                            </span>
                            <a href="learn/glossarij/attack"><img alt="<?= __('Attack') ?>" title="<?= __('Attack') ?>"  src="<?= Config::$static_url?>images/dota_2/attack.png"   /></a>
                        </div>


                        <div class="item">
                            <span id="attack_per_second">
                                <?= \DOTA_2\Hero::attack_per_second( $this->data[ 'base_as' ], $this->data[ 'bas' ], $this->data[ 'agi' ]  ); ?>
                            </span>
                            <a href="learn/glossarij/attack_speed"><img alt="<?= __('Attack_count') ?>" title="<?= ( __('Attack_count') . ' ' . __('in second') )  ?>"  src="<?= Config::$static_url?>images/dota_2/attack_speed.png"   /></a>
                        </div>

                        <div class="item">
                            <span id="attack_range">
                                <?= $this->data[ 'attack_range' ] ?>
                            </span>
                            <a href="learn/glossarij/attack_range"><img alt="<?= __('Attack_range') ?>" title="<?= __('Attack_range') ?>"  src="<?= Config::$static_url?>images/dota_2/attack_range.png"   /></a>
                        </div>


                        <div class="item">
                            <? if ( empty( $this->data[ 'projectile_speed' ] ) ) : ?>
                                <span title="<?= __('Melee_fighter') ?>">
                                    ∞
                                </span>
                            <? else: ?>
                                <span>
                                    <?= $this->data[ 'projectile_speed' ] ?>
                                </span>
                            <? endif; ?>
                            <a href="learn/glossarij/projectile_speed"><img alt="<?= __('Projectile_speed') ?>" title="<?= __('Projectile_speed') ?>"  src="<?= Config::$static_url?>images/dota_2/projectile_speed.png"   /></a>
                        </div>

                        <div class="item">
                            <span>
                                <?= $this->data[ 'attack_point' ] ?>+<?= $this->data[ 'attack_backswing' ] ?>
                            </span>
                            <a href="learn/glossarij/attack_animation"><img alt="<?= __('Attack_animation') ?>" title="<?= __('Attack_animation') ?>"  src="<?= Config::$static_url?>images/dota_2/attack_animation.png"   /></a>
                        </div>
                    </div>

                    <div class="defend">
                        <div class="title"><?=__('Defend_stats')?></div>
                        <div class="item">
                            <span id="start_armor"><?= $this->data[ 'start_armor' ] ?></span>
                            <a href="learn/glossarij/armor"><img alt="<?= __('Armor') ?>" title="<?= __('Armor') ?>"  src="<?= Config::$static_url?>images/dota_2/armor.png"   /></a>
                        </div>

                        <div class="item">
                            <span id="magic_resist"><?= $this->data[ 'magic_resist' ] ?>%</span>
                            <a href="learn/glossarij/magic_resistance"><img alt="<?= __('Magic_resistance') ?>" title="<?= __('Magic_resistance') ?>"  src="<?= Config::$static_url?>images/dota_2/magic_resist.png"   /></a>
                        </div>

                        <div class="item">
                            <span id="damage_block"><?= $this->data[ 'damage_block' ] ?></span>
                            <a href="learn/glossarij/damage_block"><img alt="<?= __('Damage_block') ?>" title="<?= __('Damage_block') ?>"  src="<?= Config::$static_url?>images/dota_2/damage_block.png"   /></a>
                        </div>
                    </div>


                    <div class="move">
                        <div class="title"><?=__('Move_stats')?></div>
                        <div class="item">
                            <span id="ms"><?= $this->data[ 'ms' ] ?></span>
                            <a href="learn/glossarij/move_speed"><img alt="<?= __('Move_speed') ?>" title="<?= __('Move_speed') ?>. <?=__('Number_of_legs')?> <?= $this->data[ 'legs' ] ?>"  src="<?= Config::$static_url?>images/dota_2/move_speed.png"   /></a>
                        </div>

                        <div class="item">
                            <span><?= $this->data[ 'turn_rate' ] ?></span>
                            <a href="learn/glossarij/turn_rate"><img alt="<?= __('Turn_rate') ?>" title="<?= __('Turn_rate') ?>"  src="<?= Config::$static_url?>images/dota_2/turn_rate.png"   /></a>
                        </div>

                        <div class="item">
                            <span>
                                <?= $this->data[ 'vision_day' ] ?>/<?= $this->data[ 'vision_night' ] ?>
                            </span>
                            <a href="learn/glossarij/vision"><img alt="<?= __('Vision_day/night') ?>" title="<?= __('Vision_day/night') ?>"  src="<?= Config::$static_url?>images/dota_2/vision.png"   /></a>
                        </div>

                        <div class="item">
                            <span>
                                <?= $this->data[ 'collision_size' ] ?>
                            </span>
                            <a href="learn/glossarij/collision_size"><img alt="<?= __('Collision_size') ?>" title="<?= __('Collision_size') ?>"  src="<?= Config::$static_url?>images/dota_2/collision_size.png"   /></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="skills">
                <div class="abilities">
                    <? foreach ( $this->abilities as $row ) : ?>
                        <div class="item2">
                            <img src="<?= $row['img'] ?>" class="ability tooltip" tooltip_data='{"interactive":true,"side":"top","trigger":"click","theme":"dota_tooltip","arrow":false}' data-tooltip-content="#<?= $row['system_name'] ?>" title="<?= $row['name'] ?>" alt="<?= $row['name'] ?>" />
                            <div class="none">
                                <div id="<?= $row['system_name'] ?>">
                                    <div class="title">
                                        <img src="<?= $row['img'] ?>" title="<?= $row['name'] ?>" alt="<?= $row['name'] ?>" />
                                        <?= $row['name'] ?>
                                    </div>

                                    <div class="aghanim_effect ability_description">
                                        <div>
                                            <?= $row[ 'description' ] ?>
                                        </div>

                                        <? if ( isset( $row[ 'dmg' ] ) ) : ?>
                                            <div>
                                                <img src="<?= Config::$static_url ?>images/dota_2/damage_symbol.png" alt="<?= __('Damage') ?>" title="<?= __('Damage') ?>" />
                                                <?= __('Damage') ?> : <?= implode( ' / ' , json_decode( $row[ 'dmg' ] ) ) ?>
                                            </div>
                                        <? endif; ?>

                                        <? if ( isset( $row[ 'dmg_type' ] ) ) : ?>
                                            <div>
                                                <a href="learn/glossarij/damage_type" target="_blank">
                                                    <img src="<?= Config::$static_url ?>images/dota_2/damage_type_symbol.png" alt="<?= __('Damage_type') ?>" title="<?= __('Damage_type') ?>" />
                                                    <?= __('Damage_type') ?>
                                                </a> :
                                                <span class="damage_type_<?= $row[ 'dmg_type' ] ?>"><?= __( $row[ 'dmg_type' ] ) ?></span>
                                            </div>
                                        <? endif; ?>

                                        <? if ( isset( $row[ 'bkbpierce' ] ) ) : ?>
                                            <div>
                                                <a href="learn/glossarij/bkb_pierce" target="_blank">
                                                    <img src="<?= Config::$static_url ?>images/dota_2/bkb_symbol.png" alt="bkb" title="bkb" />
                                                    <?= __('Bkb_pierce') ?>
                                                </a> :
                                                <? if ( $row['bkbpierce'] ) : ?>
                                                    <span class="damage_type_Pure"><?=  __('Yes') ?></span>
                                                <? else : ?>
                                                    <?= __('No') ?>
                                                <? endif; ?>
                                            </div>
                                        <? endif; ?>

                                        <? if ( isset( $row[ 'cd' ] ) ) : ?>
                                            <div>
                                                <a href="learn/glossarij/cooldown" target="_blank">
                                                    <img src="<?= Config::$static_url ?>images/dota_2/cd_symbol.png" alt="<?= __('Cooldown') ?>" title="<?= __('Cooldown') ?>" />
                                                    <?= __('Cooldown') ?>
                                                </a> :

                                                <?= is_array( $t = json_decode( $row[ 'cd' ] ) ) ? implode( ' / ' ,  $t ) : $t ?>
                                            </div>
                                        <? endif; ?>

                                        <? if ( isset( $row[ 'mc' ] ) ) : ?>
                                            <div>
                                                <a href="learn/glossarij/manacost" target="_blank">
                                                    <img src="<?= Config::$static_url ?>images/dota_2/mana_symbol.png" alt="<?= __('Manacost') ?>" title="<?= __('Manacost') ?>" />
                                                    <?= __('Manacost') ?>
                                                </a> :
                                                <?= is_array( $t = json_decode( $row[ 'mc' ] ) ) ? implode( ' / ' ,  $t ) : $t ?>
                                            </div>
                                        <? endif; ?>

                                        <div>
                                            <?=__('More_detailed_info')?>: <a target="_blank" rel="nofollow" href="<?= Localka::$settings[ Localka::$lang ]['gamepedia_url'] ?><?= $this->data['url'] ?>#<?= str_replace( ' ' , '_' , $row['name'] ) ?>">dota2.gamepedia</a>.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <? endforeach; ?>
                </div>

                <div class="icons aghanim tooltip" title="<?=__('Aghanim')?>" tooltip_data='{"interactive":true,"side":"top","trigger":"click","theme":"dota_tooltip","arrow":false}' data-tooltip-content="#aghanim_content">

                </div>
            </div>

            <div class="none">
                <div id="talents_content">
                    <div class="title">
                        <?=__('Talent_tree')?>
                    </div>
                    <? foreach ( $this->talents as $lvl => $row ) : ?>
                        <div class="block">
                            <div class="talent">
                                <span><?= $row['left_talent'] ?></span>
                            </div>

                            <div class="lvl">
                                <?= $lvl ?>
                            </div>

                            <div class="talent">
                                <span><?= $row['right_talent'] ?></span>
                            </div>
                        </div>
                    <? endforeach;?>
                </div>

                <div id="aghanim_content">
                    <div class="title">
                        <a href="learn/glossarij/aghanim" target="_blank"><?=__('Aghanim_effect')?></a>
                    </div>

                    <div class="aghanim_effect">
                        <? foreach ( $this->aghanim as $row ) : ?>
                            <img src="<?= $this->abilities[ $row['ability_id'] ]['img'] ?>"  title="<?= $this->abilities[ $row['ability_id'] ]['name'] ?>" alt="<?= $this->abilities[ $row['ability_id'] ]['name'] ?>" /> <b><?= $this->abilities[ $row['ability_id'] ]['name'] ?></b>
                            <ul>
                                <li>
                                    <?= $row['effect'] ?>
                                </li>
                            </ul>
                        <? endforeach;?>
                    </div>
                </div>

                <div id="hero_battle_tempo">
                    <div class="title">
                        <?=__('Hero_battle_tempo')?>
                    </div>
                    <div class="aghanim_effect ability_description">
                        <?=__('How_hard_is_to_handle_hero')?>.
                        <div>
                            <a target="_blank" href="learn/glossarij/battle_tempo"><?= __('More_information')?></a>.
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="description relative">
            <?if ( $this->access ) : ?>
                <?= Output::admin_panel( 'control_right_top',
                    array( null, Output::ADMIN_EDIT, 'edit/learn/hero?id=' . $this->data['id']  ),
                    array( null, Output::ADMIN_GLOBAL_EDIT, 'edit/learn/hero?aghanim=true&id=' . $this->data['id'] , __('Edit') . ' ' . __('Aghanim') ),
                    '<hr/>',
                    array( null, Output::ADMIN_GLOBAL_EDIT, 'edit/learn/hero?talent=true&id=' . $this->data['id'] . '&lvl=' . DB\DOTA_2\Heroes_talent::$lvls[0], __('Edit') . ' ' . __('Talents') . ' lvl ' . DB\DOTA_2\Heroes_talent::$lvls[0] ),
                    array( null, Output::ADMIN_GLOBAL_EDIT, 'edit/learn/hero?talent=true&id=' . $this->data['id'] . '&lvl=' . DB\DOTA_2\Heroes_talent::$lvls[1], __('Edit') . ' ' . __('Talents') . ' lvl ' . DB\DOTA_2\Heroes_talent::$lvls[1] ),
                    array( null, Output::ADMIN_GLOBAL_EDIT, 'edit/learn/hero?talent=true&id=' . $this->data['id'] . '&lvl=' . DB\DOTA_2\Heroes_talent::$lvls[2], __('Edit') . ' ' . __('Talents') . ' lvl ' . DB\DOTA_2\Heroes_talent::$lvls[2] ),
                    array( null, Output::ADMIN_GLOBAL_EDIT, 'edit/learn/hero?talent=true&id=' . $this->data['id'] . '&lvl=' . DB\DOTA_2\Heroes_talent::$lvls[3], __('Edit') . ' ' . __('Talents') . ' lvl ' . DB\DOTA_2\Heroes_talent::$lvls[3] ),
                    '<hr/>',
                    array( null, Output::ADMIN_ADD, 'edit/learn/hero?add_role=true&hero_id=' . $this->data['id'], __('Add_hero_role')  ),
                    '<hr/>',
                    array( null, Output::ADMIN_UPDATE, 'edit/learn/hero?update_hero_talents=1'  , __('Update_heroes_talents') ),
                    array( null, Output::ADMIN_UPDATE, 'edit/learn/hero?update_hero_aghanims=1', __('Update_heroes_aghanims') ),
                    '<hr/>',
                    array( null, Output::ADMIN_UPDATE, 'edit/learn/hero?update_hero_stats=1&id=' . $this->data['id'] . '&name=' . $this->data['name']  , __('Update_hero') ),
                    array( null, Output::ADMIN_UPDATE, 'edit/learn/hero?update_hero_stats=1&description=1&id=' . $this->data['id'] . '&name=' . $this->data['name']  , __('Update_hero_with_description') ),
                    array( null, Output::ADMIN_UPDATE, 'edit/learn/hero?update_heroes_stats=1', __('Update_heroes_list') )
                )
                ?>
            <? elseif( Auth::rule( Auth::EDITOR ) ) : ?>
                <?= Output::admin_panel( 'control_right_top',
                    array( null, Output::ADMIN_EDIT, 'edit/learn/hero?id=' . $this->data['id']  ),
                    '<hr/>',
                    array( null, Output::ADMIN_GLOBAL_EDIT, 'edit/learn/hero?aghanim=true&id=' . $this->data['id'] , __('Edit') . ' ' . __('Aghanim') ),
                    '<hr/>',
                    array( null, Output::ADMIN_GLOBAL_EDIT, 'edit/learn/hero?talent=true&id=' . $this->data['id'] . '&lvl=' . DB\DOTA_2\Heroes_talent::$lvls[0], __('Edit') . ' ' . __('Talents') . ' lvl ' . DB\DOTA_2\Heroes_talent::$lvls[0] ),
                    array( null, Output::ADMIN_GLOBAL_EDIT, 'edit/learn/hero?talent=true&id=' . $this->data['id'] . '&lvl=' . DB\DOTA_2\Heroes_talent::$lvls[1], __('Edit') . ' ' . __('Talents') . ' lvl ' . DB\DOTA_2\Heroes_talent::$lvls[1] ),
                    array( null, Output::ADMIN_GLOBAL_EDIT, 'edit/learn/hero?talent=true&id=' . $this->data['id'] . '&lvl=' . DB\DOTA_2\Heroes_talent::$lvls[2], __('Edit') . ' ' . __('Talents') . ' lvl ' . DB\DOTA_2\Heroes_talent::$lvls[2] ),
                    array( null, Output::ADMIN_GLOBAL_EDIT, 'edit/learn/hero?talent=true&id=' . $this->data['id'] . '&lvl=' . DB\DOTA_2\Heroes_talent::$lvls[3], __('Edit') . ' ' . __('Talents') . ' lvl ' . DB\DOTA_2\Heroes_talent::$lvls[3] )
                )
                ?>
            <? endif; ?>
            <h2 class="skill_name line_bottom">
                <?=__('Description')?>, <?=__('Talents') ?>, <?=__('Aghanims_reason') ?> <?=__('for') ?> <?= $this->data ['name'] ?>
            </h2>

            <div>
                <?= $this->data ['description'] ?>
            </div>
        </div>
    </div>

    <div class="hero_roles branching_prev active">
        <div class="branching_next" id="second">
            <div class="title_with_image flex_justify_center" >
                <?= \DOTA_2\Hero::icon_html( $this->data['name'], $this->data['url'] ); ?>
                <h2><?= $this->data['name'] ?>, <a href="learn/glossarij/roles"><?= __('Possible_game_roles')?></a></h2>
            </div>
        </div>
        <div class="list">
            <? foreach ( $this->roles as $role_id => $role ) : ?>
                <div class="block <?= ( !$role['visible'] ? 'not_visible' : '' ) ?> <?= ( $role['disabled'] ? 'disabled' : '' ) ?>">
                    <h3>
                        <img src="<?= Config::$static_url ?>images/dota_2/role_<?= $role['role'] ?>.png" alt="<?= $this->roles_description[ $role['role'] ][ 'name' ] ?>" title="<?= $this->roles_description[ $role['role'] ][ 'name' ] ?>">
                        <a target="_blank" href="learn/glossarij/<?= $this->roles_description[ $role['role'] ][ 'url' ] ?>">
                            <?if ( is_null( $role['type'] ) ) : ?>
                                <?= $this->roles_description[ $role['role'] ][ 'name' ] ?>
                            <? else : ?>
                                <span class="role_name" type="<?= $role['type'] ?>">
                                    <?= $this->roles_description[ $role['role'] ][ 'name' ] ?>
                                </span>
                            <? endif; ?>
                        </a>
                    </h3>

                    <div class="more relative">
                        <?if ( $this->access ) : ?>
                            <?= Output::admin_panel( 'control_right_top',
                                array( null, Output::ADMIN_GLOBAL_EDIT, 'edit/learn/hero?add_role=true&id=' . $role_id, __('Edit_hero_role')  ),
                                array( null, Output::ADMIN_EDIT, 'edit/learn/hero?add_role=true&data=true&id=' . $role_id, __('Edit_hero_role_description')  ),
                                '<hr/>',
                                array( null, Output::ADMIN_GLOBAL_EDIT, 'edit/learn/hero?edit_allies=true&id=' . $role_id, __('Edit_hero_allies_synergy')  ),
                                array( null, Output::ADMIN_GLOBAL_EDIT, 'edit/learn/hero?edit_enemies=true&id=' . $role_id, __('Edit_hero_enemies_synergy')  ),
                                '<hr/>',
                                array( null, ( $role['visible'] ? Output::ADMIN_HIDE : Output::ADMIN_SHOW ), 'edit/learn/hero?add_role=true&visible=' . !$role['visible'] . '&id=' . $role_id  )
                            )
                            ?>
                        <? elseif( Auth::rule( Auth::EDITOR ) ) : ?>
                            <?= Output::admin_panel( 'control_right_top',
                                array( null, Output::ADMIN_EDIT, 'edit/learn/hero?add_role=true&data=true&id=' . $role_id, __('Edit_hero_role_description')  )
                            )
                            ?>
                        <? endif; ?>
                        <a class="button" role="<?= $role['role'] ?>" role_id="<?= $role_id ?>" href="learn/heroes/<?= $this->data['url']?>?role=<?= $role['role'] ?>"><?=__('Know more')?></a>
                    </div>

                    <div class="line_top_left"></div>
                    <div class="line_bot_left"></div>
                    <div class="line_top_right"></div>
                    <div class="line_bot_right"></div>
                </div>
            <? endforeach;?>
        </div>
    </div>
</div>

<div class="row_2 branching_prev" id="third">
    <? $styles = array(
        1 => array( 'type' => 'circle', 'color' => "#7cc5ec" ),
        2 => array( 'type' => 'square', 'color' =>  "#8085e9" ),
        3 => array( 'type' => 'diamond', 'color' => "#f15c50" ),
        4 => array( 'type' => 'triangle', 'color' => "#2b908f" ),
        5 => array( 'type' => 'triangle-down', 'color' => "#f7a35c"),
    );
    $macrotasks = array(
        DB\DOTA_2\Heroes_macrotask::MACRO_TASK_STACK,
        DB\DOTA_2\Heroes_macrotask::MACRO_TASK_SCOUT,
        DB\DOTA_2\Heroes_macrotask::MACRO_TASK_RUNES,
        DB\DOTA_2\Heroes_macrotask::MACRO_TASK_MOVE,
        DB\DOTA_2\Heroes_macrotask::MACRO_TASK_DEFEND,
        DB\DOTA_2\Heroes_macrotask::MACRO_TASK_STACK_FARM,
        DB\DOTA_2\Heroes_macrotask::MACRO_TASK_FARM,
        DB\DOTA_2\Heroes_macrotask::MACRO_TASK_SIEGE,
        DB\DOTA_2\Heroes_macrotask::MACRO_TASK_ROSHAN,
        DB\DOTA_2\Heroes_macrotask::MACRO_TASK_PUSH,
        DB\DOTA_2\Heroes_macrotask::MACRO_TASK_BAIT,
        DB\DOTA_2\Heroes_macrotask::MACRO_TASK_TEAMFIGHT,
        DB\DOTA_2\Heroes_macrotask::MACRO_TASK_ROSHAN_PROTECT,
        DB\DOTA_2\Heroes_macrotask::MACRO_TASK_PROTECT,
        DB\DOTA_2\Heroes_macrotask::MACRO_TASK_ATTACK,
    );
    ?>

    <script type="text/javascript">
        var style = <?= json_encode( $styles )?>;
        var macrotasks = {
            data : <?= json_encode( $this->macrotasks, JSON_UNESCAPED_UNICODE );?>,
            keys : <?= json_encode( $macrotasks, JSON_UNESCAPED_UNICODE ); ?>,
            values : {}
        };
        var roles_data = {};
    </script>



    <div class="title_with_image flex_justify_center" id="waiting">
        <h3><?=__('Press_role_button_to_get_content')?>...</h3>
    </div>

    <? foreach ( $this->roles as $role_id => $role ) : ?>
        <div class="<?= ( isset ( $this->role ) && ( $this->role == $role_id ) ? '' : 'none' )  ?> role_<?= $role_id ?>">
            <div class="title_with_image flex_justify_center">
                <img src="<?= Config::$static_url ?>images/dota_2/role_<?= $role['role'] ?>.png" alt="<?= $this->roles_description[ $role['role'] ][ 'name' ] ?>" title="<?= $this->roles_description[ $role['role'] ][ 'name' ] ?>">
                <h3>
                    <a target="_blank" href="learn/glossarij/<?= $this->roles_description[ $role['role'] ][ 'url' ] ?>">
                        <?if ( is_null( $role['type'] ) ) : ?>
                            <?= $this->roles_description[ $role['role'] ][ 'name' ] ?>
                        <? else : ?>
                            <span class="role_name" type="<?= $role['type'] ?>">
                                <?= $this->roles_description[ $role['role'] ][ 'name' ] ?>
                            </span>
                        <? endif; ?>
                    </a>
                </h3>
            </div>
        </div>
        <script type="text/javascript">
            roles_data[<?= $role_id ?>] = [<?= $role[ DB\DOTA_2\Heroes_macrotask::MACRO_TASK_LANING ] ?>,
                <?= $role[ DB\DOTA_2\Heroes_macrotask::MACRO_TASK_CARRY_EARLY_TEMPO ] ?>,
                <?= $role[ DB\DOTA_2\Heroes_macrotask::MACRO_TASK_CARRY_MID_TEMPO ] ?>,
                <?= $role[ DB\DOTA_2\Heroes_macrotask::MACRO_TASK_CARRY_LATE_TEMPO ] ?>];

            macrotasks.values[<?= $role_id ?>] = [
                <? foreach ( $macrotasks as $value ) : ?>
                    <?= $role[ $value ]?>,
                <? endforeach; ?>
            ];
        </script>
    <? endforeach;?>


    <div class="mar_top_big mar_bot_big" id="charts">
        <div class="chart">
            <div class="title">
                <span tooltip_data='{"interactive":true,"side":"top","trigger":"click","theme":"dota_tooltip","arrow":false}' class="tooltip" data-tooltip-content="#hero_battle_tempo" ><?= __('Hero_battle_tempo') ?> <sup class="comment">(?)</sup></span>
            </div>
            <div id="highcharts_tempo"></div>
        </div>

        <div class="chart">
            <div class="title">
                <?= __('Macrotasks')?><a href="learn/glossarij/macro_task" target="_blank"> <sup class="comment">(?)</sup></a>
            </div>
            <div id="highcharts_macrotask"></div>
        </div>
    </div>


    <? foreach ( $this->roles as $role_id => $role ) : ?>
        <div class="<?= ( isset ( $this->role ) && ( $this->role == $role_id ) ? '' : 'none' )  ?> role_<?= $role_id ?>">
            <div class="content">
                <?= $role['content'] ?>
            </div>
        </div>
    <? endforeach;?>
</div>


