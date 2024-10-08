<?= Output::title( __('Draft:calculate:title' ) )?>
<?= Output::description( __('Draft:calculate:description' ) )?>
<?= Output::keywords( __('Draft:calculate:keywords' ) )?>

<?= Template::content_DEEP( __('Draft:calculate:title' ), __('Draft:calculate:text' ), $this ) ?>


<? Output::js( \Cache\File\JS::get( \Cache\File\JS::KEY_ROLE ) ) ?>
<? Output::js( \Cache\File\JS::get( \Cache\File\JS::KEY_MACROTASK ) ) ?>

<? Output::js('js/highcharts')?>
<? Output::js('modules/learn/heroes/heroes')?>
<? Output::js('js/dota_2/draft')?>
<? Output::js('js/jquery.arctext')?>

<? $this->js(); ?>



<div id="draft_calculate">
    <div id="teams">
        <div id="radiant" team="Radiant">
            <div class="title_with_image">
                <h2><?=__( DOTA_2\Draft::TEAM_RADIANT )?></h2>
                <img class="pointer" id="refresh_radiant" src="<?= Config::$static_url ?>images/system/refresh.png" title="<?=__('Clean')?>" alt="<?=__('Clean')?>" />
            </div>
            <div class="items">
                <? foreach( $this->teams[ DOTA_2\Draft::TEAM_RADIANT ] as $role => $role_data ) : ?>
                    <div class="role" role="<?= $role ?>">
                        <div class="placeholder">
                            <div class="hero">
                                <img class="avatar" src="<?= Config::$static_url?>images/dota_2/unknown_hero.png" alt="<?= $role_data['name'] ?>" title="<?= $role_data['name'] ?>" />
                                <img class="delete none" src="<?= Config::$static_url?>images/system/remove.png" title='<?=__('Delete')?>' alt='<?=__('Delete')?>' />
                            </div>
                        </div>
                        <div class="description">
                            <img src="<?= Config::$static_url ?>images/dota_2/role_<?= $role ?>.png" alt="<?= $role_data['name'] ?>" title="<?= $role_data['name'] ?>">
                            <a target="_blank" href="learn/glossarij/<?= $role_data['url'] ?>">
                                <?= $role_data['alt_name'] ?>
                            </a>
                        </div>
                    </div>
                <? endforeach;?>
            </div>
        </div>

        <div id="versus">
            <div>VS</div>
        </div>

        <div id="dire" team="Dire">
            <div class="title_with_image">
                <h2><?=__( DOTA_2\Draft::TEAM_DIRE )?></h2>
                <img class="pointer" id="refresh_dire" src="<?= Config::$static_url ?>images/system/refresh.png" title="<?=__('Clean')?>" alt="<?=__('Clean')?>" />
            </div>
            <div class="items">
            <? foreach( $this->teams[ DOTA_2\Draft::TEAM_DIRE ] as $role => $role_data ) : ?>
                <div class="role" role="<?= $role ?>">
                    <div class="placeholder">
                        <div class="hero">
                            <img class="avatar" src="<?= Config::$static_url?>images/dota_2/unknown_hero.png" alt="<?= $role_data['name'] ?>" title="<?= $role_data['name'] ?>" />
                            <img class="delete none" src="<?= Config::$static_url?>images/system/remove.png" title='<?=__('Delete')?>' alt='<?=__('Delete')?>' />
                        </div>
                    </div>
                    <div class="description">
                        <img src="<?= Config::$static_url ?>images/dota_2/role_<?= $role ?>.png" alt="<?= $role_data['name'] ?>" title="<?= $role_data['name'] ?>">
                        <a target="_blank" href="learn/glossarij/<?= $role_data['url'] ?>">
                            <?= $role_data['alt_name'] ?>
                        </a>
                    </div>
                </div>
            <? endforeach;?>
            </div>
        </div>
    </div>

    <div class="row" id="pick_container">
        <h2 class="center_text"><span id="roles_title"></span> <?= __('Heroes')?></h2>
        <div class="heroes_list" id="heroes_list">
            <? foreach ( \DOTA_2\Hero::attributes_array()  as $attribute => $attribute_data ) :?>
                <div class="title_with_image">
                    <img alt="<?= $attribute_data['text'] ?>" title="<?= $attribute_data['text'] ?>"  src="<?= Config::$static_url?>images/dota_2/<?= $attribute ?>.png"  />
                    <h2><a href="learn/glossarij/<?= $attribute_data['url'] ?>" target="_blank"><?= $attribute_data['text'] ?></a></h2>
                </div>
                <div class="block">
                    <? foreach ( $this->heroes[ $attribute ] as $hero ) :?>
                        <a class="hero" system_url="<?= $hero['system_image_name']?>" id="<?= $hero['id']?>"><?= DOTA_2\Hero::avatar_animated_html( $hero['name'], $hero['system_image_name'], null ) ?></a>
                    <? endforeach; ?>
                </div>
            <? endforeach; ?>
        </div>
    </div>

    <div class="row none" id="charts_container">
        <div id="charts">
            <div class="chart">
                <div class="title">
                    <span tooltip_data='{"interactive":true,"side":"top","trigger":"click","theme":"dota_tooltip","arrow":false}' class="tooltip" data-tooltip-content="#draft_battle_tempo" ><?= __('Hero_battle_tempo') ?> <sup class="comment">(?)</sup></span>
                </div>
                <div class="description" id="highcharts_tempo"></div>
            </div>

            <div class="chart">
                <div class="title">
                    <?= __('Macrotasks')?><a href="learn/glossarij/macro_task" target="_blank"> <sup class="comment">(?)</sup></a>
                </div>
                <form id="chart_check-boxes" class="chart_check-boxes"></form>
                <div class="description" id="highcharts_macrotask_detailed"></div>
            </div>

            <div class="break"></div>

            <div class="chart">
                <div class="title">
                    <span tooltip_data='{"interactive":true,"side":"top","trigger":"click","theme":"dota_tooltip","arrow":false}' class="tooltip" data-tooltip-content="#draft_analysis"><?= __('Analysis')?> <sup class="comment">(beta)</sup></span>
                </div>
                <div class="description text">Result.</div>
            </div>


            <div class="chart">
                <div class="title">
                   &nbsp;<sup class="comment">&nbsp;</sup></a>
                </div>
                <div class="description" id="highcharts_macrotask"></div>
            </div>
        </div>
    </div>

    <div class="none">
        <div id="draft_battle_tempo">
            <div class="title">
                <?=__('Hero_battle_tempo')?>
            </div>
            <div class="aghanim_effect ability_description">
                <?=__('Draft_battle_tempo_description')?>.
            </div>
        </div>

        <div id="draft_analysis">
            <div class="title">
                <?=__('Draft_analysys')?>
            </div>
            <div class="aghanim_effect ability_description">
                <?=__('Draft_analysys_description')?>.
            </div>
        </div>
    </div>
</div>