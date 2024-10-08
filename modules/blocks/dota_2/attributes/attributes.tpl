<div class="primary_attribute heroes_list">
    <? if ( empty( $this->primary_attribute) ) : ?>
        <h2 class="center_text"><?=__('Primary_attributes') ?></h2>
        <table class="sortable primary_attribute counter">
            <thead>
                <tr>
                    <th>
                        <?=__('Hero'); ?>
                    </th>

                    <th>
                        <?=__('Primary_attribute'); ?>
                    </th>

                    <th>
                        <?=__('Strength'); ?>
                    </th>

                    <th>
                        <?=__('Strength_inc'); ?>
                    </th>

                    <th>
                        <?=__('Agility'); ?>
                    </th>

                    <th>
                        <?=__('Agility_inc'); ?>
                    </th>

                    <th>
                        <?=__('Intelligence'); ?>
                    </th>

                    <th>
                        <?=__('Intelligence_inc'); ?>
                    </th>

                    <th>
                        <?=__('Total_base_stats'); ?>
                    </th>

                    <th>
                        <?=__('Total_base_stats_inc'); ?>
                    </th>

                    <th>
                        <?=__('Strength') . ' ' . __('on_lvl') ?> <?= \DOTA_2\Hero::LVL_MAX ?>
                    </th>

                    <th>
                        <?=__('Agility') . ' ' . __('on_lvl') ?> <?= \DOTA_2\Hero::LVL_MAX ?>
                    </th>

                    <th>
                        <?=__('Intelligence') . ' ' . __('on_lvl') ?> <?= \DOTA_2\Hero::LVL_MAX ?>
                    </th>
                </tr>
            </thead>
            <tbody>
                <? foreach ( $this->data as $row ) : ?>
                    <tr>
                        <td>
                            <a href="learn/heroes/<?= $row['url'] ?>">
                                <?= DOTA_2\Hero::avatar_small_html( $row['name'], $row['system_image_name'] ) ?> <?= $row['name'] ?>
                            </a>
                        </td>

                        <th>
                            <img class="icon_18" src="<?= Config::$static_url?>images/dota_2/<?= $row['primary_attr'] ?>.png" alt="<?= $row['primary_attr'] ?>" title="<?= $row['primary_attr'] ?>" />
                        </th>

                        <th>
                            <?= $row['str'] ?>
                        </th>

                        <th>
                            <?= $row['str_inc'] ?>
                        </th>

                        <th>
                            <?= $row['agi'] ?>
                        </th>

                        <th>
                            <?= $row['agi_inc'] ?>
                        </th>

                        <th>
                            <?= $row['int'] ?>
                        </th>

                        <th>
                            <?= $row['int_inc'] ?>
                        </th>

                        <th>
                            <?= ( $row['str'] + $row['agi'] + $row['int'] ) ?>
                        </th>

                        <th>
                            <?= ( $row['str_inc'] + $row['agi_inc'] + $row['int_inc'] ) ?>
                        </th>

                        <th>
                            <?= floor( $row['str'] + ( \DOTA_2\Hero::LVL_MAX - 1 ) * $row['str_inc'] ) ?>
                        </th>

                        <th>
                            <?= floor( $row['agi'] + ( \DOTA_2\Hero::LVL_MAX - 1 ) * $row['agi_inc'] ) ?>
                        </th>

                        <th>
                            <?= floor( $row['int'] + ( \DOTA_2\Hero::LVL_MAX - 1 ) * $row['int_inc'] ) ?>
                        </th>
                    </tr>
                <? endforeach;?>
            </tbody>
        </table>
    <? elseif ( $this->primary_attribute == 'str') : ?>
        <div class="title">
            <img src="<?= Config::$static_url?>images/dota_2/str.png" alt="<?=__('Strength') ?>" title="<?=__('Strength') ?>" />
            <h2><?=__('Strength') ?></h2>
        </div>
        <table class="sortable primary_attribute counter">
            <thead>
                <tr>
                    <th>
                        <?=__('Hero'); ?>
                    </th>

                    <th>
                        <?=__('Strength'); ?>
                    </th>

                    <th>
                        <?=__('Strength_inc'); ?>
                    </th>

                    <th>
                        <?=__('Start_hp'); ?>
                    </th>

                    <th>
                        <?=__('Start_hpreg'); ?>
                    </th>

                    <th>
                        <?=__('Start_dmg_min'); ?>
                    </th>

                    <th>
                        <?=__('Start_dmg_max'); ?>
                    </th>

                    <th>
                        <?=__('Strength') . ' ' . __('on_lvl') ?> <?= \DOTA_2\Hero::LVL_MAX ?>
                    </th>

                    <th>
                        <?=__('HP') . ' ' . __('on_lvl') ?> <?= \DOTA_2\Hero::LVL_MAX ?>
                    </th>

                    <th>
                        <?=__('HP_reg') . ' ' . __('on_lvl') ?> <?= \DOTA_2\Hero::LVL_MAX ?>
                    </th>

                    <th>
                        <?=__('Damage') . ' ' . __('on_lvl') ?> <?= \DOTA_2\Hero::LVL_MAX ?>
                    </th>
                </tr>
            </thead>
            <tbody>
            <? foreach ( $this->data as $row ) : ?>
                <tr>
                    <td>
                        <a href="learn/heroes/<?= $row['url'] ?>">
                            <?= DOTA_2\Hero::avatar_small_html( $row['name'], $row['system_image_name'] ) ?> <?= $row['name'] ?>
                        </a>
                    </td>

                    <th>
                        <?= $row['str'] ?>
                    </th>

                    <th>
                        <?= $row['str_inc'] ?>
                    </th>

                    <th>
                        <?= $row['start_hp'] ?>
                    </th>

                    <th>
                        <?= $row['start_hpreg'] ?>
                    </th>

                    <th>
                        <?= $row['start_dmg_min'] ?>
                    </th>

                    <th>
                        <?= $row['start_dmg_max'] ?>
                    </th>

                    <th>
                        <? $strength_lvl_30 = floor( $row['str'] + ( \DOTA_2\Hero::LVL_MAX - 1 ) * $row['str_inc'] ); ?>
                        <?= $strength_lvl_30 ?>
                    </th>

                    <th>
                        <?= \DOTA_2\Hero::hp( $strength_lvl_30  ); ?>
                    </th>

                    <th>
                        <?= \DOTA_2\Hero::hp_reg( $strength_lvl_30 , $row['base_hpreg']  ); ?>
                    </th>

                    <th>
                        <?= $row['base_dmg_min'] + $strength_lvl_30 ?>-<?= $row['base_dmg_max'] + $strength_lvl_30 ?>
                    </th>
                </tr>
            <? endforeach;?>
            </tbody>
        </table>
    <? elseif ( $this->primary_attribute == 'agi') : ?>
        <div class="title">
            <img src="<?= Config::$static_url?>images/dota_2/agi.png" alt="<?=__('Agility') ?>" title="<?=__('Agility') ?>" />
            <h2><?=__('Agility') ?></h2>
        </div>
        <table class="sortable primary_attribute counter">
            <thead>
                <tr>
                    <th>
                        <?=__('Hero'); ?>
                    </th>

                    <th>
                        <?=__('Agility'); ?>
                    </th>

                    <th>
                        <?=__('Agility_inc'); ?>
                    </th>

                    <th>
                        <?=__('Start_armor'); ?>
                    </th>

                    <th>
                        <?=__('Attack_per_sec'); ?>
                    </th>

                    <th>
                        <?=__('Attack_reload'); ?>
                    </th>

                    <th>
                        <?=__('Start_dmg_min'); ?>
                    </th>

                    <th>
                        <?=__('Start_dmg_max'); ?>
                    </th>

                    <th>
                        <?=__('Agility') . ' ' . __('on_lvl') ?> <?= \DOTA_2\Hero::LVL_MAX ?>
                    </th>

                    <th>
                        <?=__('Armor') . ' ' . __('on_lvl') ?> <?= \DOTA_2\Hero::LVL_MAX ?>
                    </th>

                    <th>
                        <?=__('Attack_per_sec') . ' ' . __('on_lvl') ?> <?= \DOTA_2\Hero::LVL_MAX ?>
                    </th>

                    <th>
                        <?=__('Attack_reload') . ' ' . __('on_lvl') ?> <?= \DOTA_2\Hero::LVL_MAX ?>
                    </th>

                    <th>
                        <?=__('Damage') . ' ' . __('on_lvl') ?> <?= \DOTA_2\Hero::LVL_MAX ?>
                    </th>
                </tr>
            </thead>
            <tbody>
            <? foreach ( $this->data as $row ) : ?>
                <tr>
                    <td>
                        <a href="learn/heroes/<?= $row['url'] ?>">
                            <?= DOTA_2\Hero::avatar_small_html( $row['name'], $row['system_image_name'] ) ?> <?= $row['name'] ?>
                        </a>
                    </td>

                    <th>
                        <?= $row['agi'] ?>
                    </th>

                    <th>
                        <?= $row['agi_inc'] ?>
                    </th>

                    <th>
                        <?= $row['start_armor'] ?>
                    </th>

                    <th>
                        <?= \DOTA_2\Hero::attack_per_second( $row['base_as'] , $row['bas'], $row['agi']  ); ?>
                    </th>

                    <th>
                        <?= \DOTA_2\Hero::attack_interval( $row['base_as'] , $row['bas'], $row['agi']  ); ?>
                    </th>

                    <th>
                        <?= $row['start_dmg_min'] ?>
                    </th>

                    <th>
                        <?= $row['start_dmg_max'] ?>
                    </th>

                    <th>
                        <? $agility_lvl_30 = floor( $row['agi'] + ( \DOTA_2\Hero::LVL_MAX - 1 ) * $row['agi_inc'] ); ?>
                        <?= $agility_lvl_30 ?>
                    </th>

                    <th>
                        <?= \DOTA_2\Hero::armor( $row['base_armor'],  $agility_lvl_30 ); ?>
                    </th>

                    <th>
                        <?= \DOTA_2\Hero::attack_per_second( $row['base_as'] , $row['bas'], $agility_lvl_30  ); ?>
                    </th>

                    <th>
                        <?= \DOTA_2\Hero::attack_interval( $row['base_as'] , $row['bas'], $agility_lvl_30  ); ?>
                    </th>

                    <th>
                        <?= $row['base_dmg_min'] + $agility_lvl_30?>-<?= $row['base_dmg_max'] + $agility_lvl_30 ?>
                    </th>
                </tr>
            <? endforeach;?>
            </tbody>
        </table>
    <? else : ?>
        <div class="title">
            <img src="<?= Config::$static_url?>images/dota_2/int.png" alt="<?=__('Intelligence') ?>" title="<?=__('Intelligence') ?>" />
            <h2><?=__('Intelligence') ?></h2>
        </div>
        <table class="sortable primary_attribute counter">
            <thead>
            <tr>
                <th>
                    <?=__('Hero'); ?>
                </th>

                <th>
                    <?=__('Intelligence'); ?>
                </th>

                <th>
                    <?=__('Intelligence_inc'); ?>
                </th>

                <th>
                    <?=__('Start_mp'); ?>
                </th>

                <th>
                    <?=__('Start_mpreg'); ?>
                </th>

                <th>
                    <?=__('Start_dmg_min'); ?>
                </th>

                <th>
                    <?=__('Start_dmg_max'); ?>
                </th>

                <th>
                    <?=__('Intelligence') . ' ' . __('on_lvl') ?> <?= \DOTA_2\Hero::LVL_MAX ?>
                </th>

                <th>
                    <?=__('MP') . ' ' . __('on_lvl') ?> <?= \DOTA_2\Hero::LVL_MAX ?>
                </th>

                <th>
                    <?=__('MP_reg') . ' ' . __('on_lvl') ?> <?= \DOTA_2\Hero::LVL_MAX ?>
                </th>

                <th>
                    <?=__('Damage') . ' ' . __('on_lvl') ?> <?= \DOTA_2\Hero::LVL_MAX ?>
                </th>
            </tr>
            </thead>
            <tbody>
            <? foreach ( $this->data as $row ) : ?>
                <tr>
                    <td>
                        <a href="learn/heroes/<?= $row['url'] ?>">
                            <?= DOTA_2\Hero::avatar_small_html( $row['name'], $row['system_image_name'] ) ?> <?= $row['name'] ?>
                        </a>
                    </td>

                    <th>
                        <?= $row['int'] ?>
                    </th>

                    <th>
                        <?= $row['int_inc'] ?>
                    </th>

                    <th>
                        <?= $row['start_mp'] ?>
                    </th>

                    <th>
                        <?= $row['start_mpreg'] ?>
                    </th>

                    <th>
                        <?= $row['start_dmg_min'] ?>
                    </th>

                    <th>
                        <?= $row['start_dmg_max'] ?>
                    </th>

                    <th>
                        <? $intelligence_lvl_30 = floor( $row['int'] + ( \DOTA_2\Hero::LVL_MAX - 1 ) * $row['int_inc'] ); ?>
                        <?= $intelligence_lvl_30 ?>
                    </th>

                    <th>
                        <?= \DOTA_2\Hero::mp( $intelligence_lvl_30  ); ?>
                    </th>

                    <th>
                        <?= \DOTA_2\Hero::mp_reg( $intelligence_lvl_30 , $row['base_mpreg']  ); ?>
                    </th>

                    <th>
                        <?= $row['base_dmg_min'] + $intelligence_lvl_30 ?>-<?= $row['base_dmg_max'] + $intelligence_lvl_30 ?>
                    </th>
                </tr>
            <? endforeach;?>
            </tbody>
        </table>
    <? endif; ?>
</div>