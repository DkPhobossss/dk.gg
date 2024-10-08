<? Output::css( 'css/test' ) ?>
<? Output::css( 'css/jquery.modal' ) ?>
<? Output::css( 'css/tooltipster.bundle' ) ?>

<? Output::js('js/lang/' . Localka::$lang ) ?>
<? Output::jquery( true ); ?>
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

            <div id="content">
                <? if ( !empty( $this->short_news ) ) : ?>
                    <? Output::js( 'js/scroller' ) ?>
                    <h1 class="root2">Zemex</h1>

                    <div class="short_news_wrapper">
                        <div id="news_slider">
                            <a class="arrow_left disabled"></a><div class="placeholder clear_block">
                                <div class="slider" style="margin-left:0;">
                                    <? foreach ( $this->short_news as $row ) : ?>
                                        <div class="block">
                                            <div class="title clear_block">
                                                <a href="<?= $row['url'] ?>">
                                                    <img src="<?= $row['image'] ?>" alt="<?= $row['title'] ?>" title="<?= $row['title'] ?>" />
                                                </a>
                                                <h2><a href="<?= $row['url'] ?>"><?= $row['title'] ?></a></h2>
                                            </div>

                                            <div class="preview">
                                                <?= $row['preview'] ?>...
                                            </div>

                                            <div class="right_text mar_top_5">
                                                <span class="left gray italic small">
                                                    <?= Output::date_format( $row['date_ins'] ) ?>
                                                </span>

                                                <a href="<?= $row['url'] ?>"><?= ( 'More' ) ?>...</a>
                                            </div>
                                        </div>
                                    <? endforeach; ?>
                                </div>
                            </div><a class="arrow_right"></a>
                        </div>
                    </div>
                <? endif; ?>


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