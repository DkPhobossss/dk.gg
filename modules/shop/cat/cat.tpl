<? Output::seo( $this->cat ) ?>
<? $this->css() ?>

<? if ( $this->view != 'plitka' ) : ?>
    <div class="relative">
        <div id="controls" class="round absolute">
            <a <?= $this->view != 'plitka' ? '' : ( 'href="shop/' . $this->cat_url  . '?view=list"' ) ?>>
                <img src="/images/list.jpg" alt="<?= ('Отобразить списком') ?>" title="<?= ('Отобразить списком') ?>" />
            </a>
            <a <?= $this->view == 'plitka' ? '' : ( 'href="shop/' . $this->cat_url  . '?view=plitka"' ) ?>>
                <img src="/images/plitka.jpg" alt="<?= ('Отобразить плиткой') ?>" title="<?= ('Отобразить плиткой') ?>" href="shop/<? $this->cat_url ?>?view=plitka" />
            </a>
        </div>
    </div>
    <? foreach ( $this->data as $row ) : ?>
        <div class="product relative round">
            <?if ( Auth::rule( ) ) : ?>
                <?= Output::admin_panel( 'control_right_top', 
                    array( null, Output::ADMIN_ADD, 'edit/shop/product?cat_id=' . $row['id'] ), 
                    '<hr>',
                    array( null, Output::ADMIN_EDIT, 'edit/shop/product?data=true&id=' . $row['id'] ), 
                    array( null, Output::ADMIN_GLOBAL_EDIT, 'edit/shop/product?&id=' . $row['id'] ), 
                    '<hr>' , 
                    array( null, Output::ADMIN_DELETE, 'delete/shop/product?id=' . $row['id'] ) )
                ?>
            <? endif; ?>

            <div class="clear_block">
                <a href="<?= $row['url'] ?>" class="left">
                    <img src="<?= $row['image_text'] ?>" alt="<?= $row['name'] ?>" title="<?= $row['name'] ?>" />
                </a>

                <h2 class="header_hidden">
                    <?= $row['name'] ?>
                </h2>

                <a class="absolute black_button" href="<?= $row['url'] ?>"><?= ( 'More' ) ?></a>
            </div>


            <a class="block" href="<?= $row['url'] ?>">
                <img src="<?= $row['image_preview'] ?>" alt="<?= $row['name'] ?>" title="<?= $row['name'] ?>" />
            </a>
        </div>
    <? endforeach; ?>

    <div class="pagination_block round">
        <?=$this->pagination?>
    </div>
<? else : ?>
    <? Output::css('modules/shop/shop'); ?>

    <div id="content" class="round">
        
        <div id="controls" class="round">
            <a <?= $this->view != 'plitka' ? '' : ( 'href="shop/' . $this->cat_url  . '?view=list"' ) ?>>
                <img src="/images/list.jpg" alt="<?= ('Отобразить списком') ?>" title="<?= ('Отобразить списком') ?>" />
            </a>
            <a <?= $this->view == 'plitka' ? '' : ( 'href="shop/' . $this->cat_url  . '?view=plitka"' ) ?>>
                <img src="/images/plitka.jpg" alt="<?= ('Отобразить плиткой') ?>" title="<?= ('Отобразить плиткой') ?>" href="shop/<? $this->cat_url ?>?view=plitka" />
            </a>
        </div>
        
        <h1><?= $this->cat['name'] ?></h1>
        
        <div id="cats" class="clear_block">
            <? foreach ( $this->data as $url => $row ) : ?>
                <div class="left">
                    <a href="<?= $row['url'] ?>" >
                        <img src="<?= $row['image_preview_plitka'] ?>" alt="<?= $row['name'] ?>" title="<?= $row['name'] ?>" class="cat" />
                        <h2><?= $row['name'] ?></h2>
                    </a>
                </div>
            <? endforeach; ?>
        </div>
    </div>

    <div class="pagination_block round">
        <?=$this->pagination?>
    </div>
<? endif; ?>

<?= $this->module('/blocks/shop_footer'); ?>