<? Output::css( 'css/test' ) ?>
<? Output::css( 'css/jquery.modal' ) ?>
<? Output::css( 'css/tooltipster.bundle' ) ?>

<? Output::js('js/lang/' . Localka::$lang ) ?>
<? Output::cdn_js( Output::$jquery ) ?>
<? Output::js( 'js/global' ) ?>
<? Output::js( 'js/jquery.form.min' ) ?>
<? Output::js('js/jquery.modal.min') ?>
<? Output::js('js/tooltipster.bundle.min') ?>
<? Output::js('js/jquery.smoothscroll') ?>
<? Output::js('js/jquery.tablesorter.min') ?>


<div class="main">
    <header id="header">
        <a class="logo" href="<?= Config::$root_url?>">
            <? $rand = rand(1,4); ?>
            <? for ($i = 1; $i <= 4; $i++) : ?>
                <img <?=( $i == $rand ? 'class="visible"' :'' )?> title="logo" alt="logo" src="<?=Config::$static_url?>/images/logo_<?=$i?>.png" />
            <? endfor; ?>
            <span class="site_name"><?= Config::SITE_NAME?></span>
        </a>

        <?= $this->module( '/menu/top', isset( Link::$parts[0] ) ? Link::$parts[0] : '' ) ?>
        <?= $this->module( '/menu/top_right' ) ?>
    </header>
    <div id="wrap">

            <div id="content" class="admin_area">
                <div id="default_template">
                </div>

                <div class="row">
                    <? if ( !is_array( $this->submodule ) ) :?>
                        <? $this->submodule_args = array( '/' . $this->submodule ); ?>
                        <? if ( count( $this->args ) > 1 ) : ?>
                            <? $this->submodule_args = array_merge( $this->submodule_args , array_splice( $this->args , 1 ) ); ?>
                        <? endif; ?>
                        <?= call_user_func_array( array( $this, 'module' ) ,  $this->submodule_args ) ?>
                    <? else : ?>
                        <? reset( $this->submodule ); ?>
                        <? while ( ( $module = current( $this->submodule ) ) ) : ?>
                            <? $next = next( $this->submodule ); ?>
                            <? if ( is_array( $next ) ) :?>
                                <?= call_user_func_array( array( $this, 'module' ) ,  array_merge( array( '/' . $module ) , $next ) ); ?>
                                <? next( $this->submodule ); ?>
                            <? else : ?>
                                <?= call_user_func_array( array( $this, 'module' ) ,  array( '/' . $module ) ); ?>
                            <? endif; ?>
                        <? endwhile; ?>
                    <? endif; ?>
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