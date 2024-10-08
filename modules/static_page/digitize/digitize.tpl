<?= Output::title( __('Digitize' ) )?>
<?= Output::description( __('Digitize:description' ) )?>
<?= Output::keywords( __('Digitize:keywords' ) )?>

<?= Template::content_DEEP( __('Digitize'), __('Digitize:text'), $this ) ?>



<? $this->js(); ?>

<div class="row">
    <script type="text/javascript">
        var RANKS = <?= Skills::ranks_json(); ?>;
        var DATA= <?= Skills::data_json(); ?>;
        var MMR_RANGE = <?= Skills::ranges_json(); ?>;
    </script>
    <div class="group">
        <? foreach (  array( Skills::$GLOBAL_SKILLS_GAME, Skills::$GLOBAL_SKILLS_COMMON_GAME, Skills::$GLOBAL_SKILLS_PERSONAL , Skills::$GLOBAL_SKILLS_CHARACTER ) as $k => $global_skill ) :?>
            <div class="element">
                <h3><?= $global_skill['name'] ?></h3>
                <ul class="list">
                    <? $keys = 6;
                    $rand_keys = array_rand( $global_skill['skills'] , min( sizeof( $global_skill['skills'] ),  $keys ) );?>
                    <? for ( $i=0; $i < $keys; $i++ ) : ?>
                        <? if ( !isset( $rand_keys[$i] ) ) : ?>
                            <? break; ?>
                        <? endif; ?>
                        <? $skill_id = $global_skill['skills'][$rand_keys[$i]]; ?>
                        <li><?= $this->data[ $skill_id ]['name'] ?></li>
                    <? endfor; ?>
                </ul>

                <div class="more">
                    <a class="button_big" href="<?= Page::full_url() ?>#global_skill_<?= $k ?>"><?=__('Know more')?></a>
                </div>
            </div>
        <? endforeach; ?>
    </div>

    <div class="central">
        <h2><?= __('Table_of_skill_calculation')?></h2>

        <table id="skill_calculation" cellspacing="0">
            <thead>
                <tr class="header">
                    <th>
                        <?= __('Enter_your_mmr')?>
                    </th>

                    <th>

                    </th>

                    <th>
                        <?= __('Select_mmr_you_want')?>
                    </th>
                </tr>

                <tr>
                    <td>
                        <div class="choose">
                            <div for="mmr" class="default_placeholder">
                                <span class="mmr"></span>
                                <input class="default" id="mmr" type="number" min="0" max="9999" maxlength="4" placeholder="0" step="100"  />
                            </div>

                            <div class="rank">
                                <div id="player_rank_title">Uncalibrated</div>
                                <img id="player_rank_image" data-tooltip-content="#player_rank_image_content" src="<?= Config::$static_url ?>images/medals/0.png" alt="rank" title="rank" />

                                <div class="tooltip_select none">
                                    <div class="flex" id="player_rank_image_content">
                                        <? foreach ( Skills::RANKS as $row ) :  ?>

                                                <img src="<?= $row['url'] ?>" alt="<?= $row['text'] ?>" title="<?= $row['text'] ?>" mmr="<?= $row['start'] ?>" />

                                        <? endforeach;?>
                                    </div>
                                </div>
                             </div>
                        </div>
                    </td>

                    <th class="arrow">
                        &#8594;
                    </th>

                    <td>
                        <div class="choose">
                            <div class="rank">
                                <div id="player_rank_title_2">Uncalibrated</div>
                                <img id="player_rank_image_2" data-tooltip-content="#player_rank_image_content_2" src="<?= Config::$static_url ?>images/medals/0.png" alt="rank" title="rank" />

                                <div class="tooltip_select none">
                                    <div class="flex" id="player_rank_image_content_2">
                                        <? foreach ( Skills::RANKS as $row ) :  ?>
                                            <img src="<?= $row['url'] ?>" alt="<?= $row['text'] ?>" title="<?= $row['text'] ?>" mmr="<?= $row['start'] ?>" />
                                        <? endforeach;?>
                                    </div>
                                </div>
                            </div>

                            <div for="mmr_2" class="default_placeholder">
                                <input class="default" id="mmr_2" type="number" min="0" max="9999" maxlength="4" placeholder="0" step="200"  />
                                <span class="mmr"></span>
                            </div>
                        </div>
                    </td>
                </tr>

                <tr class="header">
                    <th>
                        <?=__('Expected_skills')?>
                    </th>

                    <th>
                        <?=__('Result')?>
                    </th>

                    <th>
                        <?=__('Necessary_skills'); ?>
                    </th>
                </tr>
            </thead>

            <tbody>
                <? foreach (  array( Skills::$GLOBAL_SKILLS_GAME, Skills::$GLOBAL_SKILLS_COMMON_GAME, Skills::$GLOBAL_SKILLS_PERSONAL , Skills::$GLOBAL_SKILLS_CHARACTER ) as $k => $global_skill ) :?>
                    <tr class="global_skill none" id="table_global_skill_<?= $k ?>">
                        <th colspan="3"><?= $global_skill['name'] ?></th>
                    </tr>
                    <? foreach ($global_skill['skills'] as $skill ) :?>
                        <? $name = $this->data[$skill]['name']; ?>
                        <tr class="<?= isset( $this->data[$skill]['range'][ Skills::MMR_RANGE_1 ] ) ? 'missing' : 'none' ?>" id="table_skill_<?= $skill?>">
                            <td>
                                <?= $name ?>
                            </td>

                            <th class="result" skill="<?= $skill?>">

                            </th>

                            <td>
                                <?= $name ?>
                                <a href="#popup" rel="modal:open" data="<?= $skill ?>" class="info">(?)</a>
                            </td>
                        </tr>
                    <? endforeach; ?>
                <? endforeach; ?>
            </tbody>

            <tfoot>
                <tr class="header">
                    <th>

                    </th>

                    <th>
                        <?=__('Advices'); ?>
                    </th>

                    <th>

                    </th>
                </tr>

                <tr>
                    <td colspan="3">
                        <div class="advices">
                            <div id="advice">
                                Вам нжуно больше работать над ластхитом, реагром, уделять внимание макро-задачам, прокачать в себе навыки характера
                            </div>

                            <div id="buttons">
                                <a class="button_big">Получить совет</a>
                                <a class="button_big" href="learn" target="_blank">Учись</a>
                                <?= $this->module( '/blocks/social_share' , 'button_big', '"theme": "tooltipster-light","side":"bottom","trigger":"click","interactive": true',  __('Digitize_social_text'), Page::full_url(), (Config::$static_url. 'images/favicon/android-chrome-192x192.png')  ) ?>
                            </div>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>




    <div class="central">
        <? foreach (  array( Skills::$GLOBAL_SKILLS_GAME, Skills::$GLOBAL_SKILLS_COMMON_GAME, Skills::$GLOBAL_SKILLS_PERSONAL , Skills::$GLOBAL_SKILLS_CHARACTER ) as $k => $global_skill ) :?>
            <div class="block">
                <h2 id="global_skill_<?= $k ?>"><?= $global_skill['name'] ?></h2>
                <? foreach ($global_skill['skills'] as $skill ) :?>
                    <div class="skill_container" id="skill_<?= $skill?>">
                        <div class="skill">
                            <? $name = $this->data[$skill]['name']; ?>
                            <div class="skill_name line_bottom"><?= $name ?></div>
                            <?= $this->data[$skill]['description'] ?>.
                            <? if ( count($this->data[$skill]['range']) > 1 ) :?>
                            <ul class="skill_list">
                                <? foreach ( $this->data[$skill]['range'] as $skill_description ) : ?>
                                    <li><?= $skill_description ?>.</li>
                                <? endforeach;?>
                            </ul>
                            <? endif; ?>
                        </div>
                        <div class="image">
                            <? if ( empty ( $this->data[$skill]['youtube_data'] ) ) : ?>
                                <img src="<?= Config::$static_url?>images/skill/<?= $this->data[$skill]['image']?>" alt="<?= $name ?>" title="<?= $name ?>" />
                                <? if ( !empty ( $this->data[$skill]['image_text'] ) ) : ?>
                                    <span class="image_text">
                                        <?= empty( $this->data[$skill]['image_text'] ) ? '' : $this->data[$skill]['image_text'] ;  ?>
                                    </span>
                                <? endif; ?>
                            <? else : ?>
                                <a href="#youtube_play" rel="modal:open" data="<?= $this->data[$skill]['youtube_data']  ?>&enablejsapi=1">
                                    <img src="<?= Config::$static_url?>images/skill/<?= $this->data[$skill]['image']?>" alt="<?= $name ?>" title="<?= $name ?>" />
                                    <? if ( !empty ( $this->data[$skill]['image_text'] ) ) : ?>
                                        <span class="image_text">
                                            <?= empty( $this->data[$skill]['image_text'] ) ? '' : $this->data[$skill]['image_text'] ;  ?>
                                        </span>
                                    <? endif; ?>
                                </a>
                            <? endif; ?>
                        </div>
                    </div>
                <? endforeach; ?>
            </div>
        <? endforeach; ?>
    </div>
</div>
    <div class="modal modal_video" id="youtube_play">
        <iframe width="100%" height="100%" frameborder="0" allowfullscreen></iframe>
    </div>

    <div class="modal" id="popup"></div>
