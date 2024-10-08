<? if ( !empty( $this->data ) ) :?>
    <? $this->css() ?>
    <? $this->js(); ?>

    <div class="foba_gallery" id="g<?= $this->gallery_id ?>" url="<?= $this->gallery_url ?>">
        <div class="carousel">
            <a class="arrow_left disabled"></a>
            <div class="placeholder" style="width:<?= $this->width ?>px;">
                <div class="slider">
                    <? foreach ( $this->data as $row ) : ?>
                        <a class="relative" href="gallery/<?= $this->gallery_url ?>/<?= $row['id'] ?>" id="p<?= $row['id'] ?>" source="<?= Config::uploads?>gallery/<?= $this->gallery_id?>/<?= $row['source'] ?>">
                            <img alt="<?= $row['title'] ?>" _src="<?= Config::uploads?>gallery/<?= $this->gallery_id?>/<?= $row['src'] ?>" src="<?= Config::uploads?>gallery/<?= $this->gallery_id?>/<?= $row['preview'] ?>">
                            <? if ( $this->access ) : ?>
                            <span title="delete"  class="delete" href="<?= Page::admin( 'delete/watch/gallery/photo?id=' . $row['id'] . '&' . Output::href_session() ) ?>"></span>
                            <span title="edit" class="edit" href="<?= Page::admin( 'edit/watch/gallery/photo?id=' . $row['id'] ) ?>"></span>
                            <? endif; ?>
                        </a>
                    <? endforeach; ?>
                </div>
            </div>
            <a class="arrow_right"></a>
        </div>
        <div class="info"><span class="offset">6</span>/<?= count( $this->data ) ?></div>
    </div>

    <x-dialog class="gallery_dialog content news_content" overlay=".overlay"><x-button-close></x-button-close>
        <div class="gallery_description">
            <h1></h1>
            <div class="table_div">
                <div class="body">
                    <a class="arrow_left"></a>
                    <div class="photo"></div>
                    <a class="arrow_right"></a>
                </div>
            </div>
            <div class="right_text mar_hor_10">
                <b class="left"><?=_ ('Photo') ?> <span></span> <?=_ ('of') ?> <?= count( $this->data ) ?></b>
                <a class="source" target="_blank"><?=_ ('Original image') ?></a>
            </div>
            <div class="stats">
                <div class="rating"></div>
                <div class="s"></div>
            </div>
        </div>
        <div class="watch_comments"></div>
     </x-dialog>
<? endif; ?>