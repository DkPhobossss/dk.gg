<?= Output::title( ( "seo_title_shop" ) ) ?>
<?= Output::description( ( "seo_description_shop" ) ) ?>
<?= Output::keywords( ( "seo_keywords_shop" ) ) ?>

<?= $this->css() ?>


    <h1 class="zemex">
        <?= ( "Каталог" ) ?>
    </h1>

    <div id="cats" class="clear_block">
        <? foreach ( $this->data as $url => $row ) : ?>
            <div class="left">
                <? if ( Auth::rule( ) ) :  ?>
                    <?= Output::admin_panel( 'control_right_top', 
                        array( null, Output::ADMIN_EDIT, 'edit/shop/cat?data=true&id=' . $row['id'] ), 
                        array( null, Output::ADMIN_GLOBAL_EDIT, 'edit/shop/cat?id=' . $row['id'] ));
                    ?>
                <? endif; ?>

                <a href="shop/<?= $url ?>">
                    <img src="<?= $row['image_catalogue'] ?>" alt="<?= $row['name'] ?>" title="<?= $row['name'] ?>" class="cat" />
                    <h2><?= $row['name'] ?></h2>
                </a>
            </div>
        <? endforeach; ?>
            <div class="left" style="opacity: 0.35;">
                <? $year = date('Y') + 1; ?>
                <a href="<?= Config::$ckfinderbase ?>files/catalogue.pdf" onclick="return false;">
                    <img src="<?= Config::$ckfinderbase ?>images/shop/cat/catalogue/zemex.jpg" alt="<?= ('Каталог') ?> <?= $year ?>" title="<?= ('Скачать каталог') ?> <?= $year ?>" class="cat" />
                    <h2><?= ('Каталог') ?> <?= $year ?></h2>
                </a>
            </div>
    </div>

</div>

<?= $this->module('/blocks/shop_footer' , true ); ?>
