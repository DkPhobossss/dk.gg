<? Output::seo(  $this->seo ); ?>

<?= Output::add( 'DB\Rules::READ_NEWS' ,  'edit/read/news?cat_id=' . $this->cat_id , 'right' )?>
<h1>
    <?= $this->seo['seo_title'] ?>
</h1>

<?= $this->pagination_html ?>

<? foreach ( $this->data as $row ): ?>
    <div class="news_body">
        <?= $this->access  ? Output::admin_panel( 'right' ,
                            array( null , Output::ADMIN_EDIT , 'edit/read/news?data=true&id=' . $row['id'])  ,
                            array( null , Output::ADMIN_GLOBAL_EDIT , 'edit/read/news?&id=' . $row['id'] ) ,
                            '<hr>' ,
                            array( null , Output::ADMIN_DELETE , 'delete/read/news?id=' . $row['id'])
                        ) : ''?>
        <h2 class="border_bottom"><a href="<?= DB\Read\news::$cats[ $this->cat_id ]; ?>/<?= $row['url'] ?>"><?= $row['title'] ?></a></h2>

        <div class="clear_block mar_bottom_20">
            <?= $row['preview'] ?>
        </div>

        <div class="right_text">
            <i class="left"><?= Output::date_format( $row['date_ins'] ) ?></i>
            <a class="black_button" href="<?= DB\Read\news::$cats[ $this->cat_id ]; ?>/<?= $row['url'] ?>"><?= (  'More' ) ?></a>
        </div>
    </div>
<? endforeach; ?>

<?= $this->pagination_html ?>