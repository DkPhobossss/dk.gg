<? $this->args('submodule'); ?>

<? Output::css( 'css/test' ) ?>
<? Output::css( 'css/jquery.modal' ) ?>
<? Output::css( 'css/tooltipster.bundle' ) ?>

<? Output::js('js/lang/' . Localka::$lang ) ?>
<? Output::cdn_js( Output::$jquery ) ?>

<? Output::js( 'js/jquery.form.min' ) ?>
<? Output::js('js/jquery.modal.min') ?>
<? Output::js('js/tooltipster.bundle.min') ?>
<? Output::js('js/jquery.smoothscroll') ?>



<div class="main">
    <header id="header">
        <a class="logo" href="<?= Config::$root_url?>">
            <? $rand = rand(1,4); ?>
            <? for ($i = 1; $i <= 4; $i++) : ?>
                <img <?=( $i == $rand ? 'class="visible"' :'' )?> title="logo" alt="logo" src="<?=Config::$static_url?>/images/logo_<?=$i?>.png" />
            <? endfor; ?>
            <span class="site_name"><?= Config::SITE_NAME?></span>
        </a>

        <?= $this->module( '/menu/top' ) ?>
        <?= $this->module( '/menu/top_right' ) ?>
    </header>

    <div id="wrap">

        <div id="content">

            <?= $this->module( '/errors/' . $this->submodule ) ?>

            <div class="row">
                <a onclick="history.go(-1)" style="cursor: pointer"><?= __( 'go back' ) ?></a>
            </div>
        </div>


    </div>


    <footer id="footer">
        <div class="row">
            <? Output::css('css/fontisto');?>
            <div class="socials">
                <img class="pugna" src="<?=Config::$static_url?>images/pugna_twitter.png" alt="pugna" title="pugna" />

                <div>
                    <div class="h3"><?=__('Socials')?></div>
                    <ul class="social-networks bounce">
                        <? foreach ( Output::$socials as $social_id => $row ) : ?>
                            <li>
                            <? if ( !empty( $row['url'] )  ): ?>
                                <a target="_blank" href="<?= $row['url'] ?>"  title="<?= $row['text'] ?>" class="fi fi-<?= $social_id ?>"><?= $row['text'] ?></a>
                            <? else : ?>
                                <a title="<?= $row['text'] ?>"  tooltip_data='{"side":"bottom","trigger":"click" }' class="tooltip fi fi-<?= $social_id ?>"><?= $row['text'] ?></a></li>
                            <? endif; ?>
                            </li>

                        <? endforeach; ?>
                    </ul>
                </div>
            </div>

            <div class="credits">
                <a class="logo" href="<?= Config::$root_url?>">
                    <img style="opacity:1;" title="logo" alt="logo" src="<?=Config::$static_url?>/images/logo_1.png" />
                    <span class="site_name"><?= Config::SITE_NAME?></span>
                </a>

                <span class="copyrigt">© DkPhobos</span>
            </div>
        </div>
    </footer>
</div>


<?= $this->module( '/login' ) ?>

<div id="ajax_container"></div>