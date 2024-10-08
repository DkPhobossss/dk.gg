<? Output::seo(  $this->seo ); ?>
<? Output::css( 'modules/shop/shop' ); ?>

<? $this->css(); ?>

<?= Output::add( 'DB\Rules::READ_NEWS' ,  'edit/video' , 'right' )?>
    <h1>
        <?= $this->seo['seo_title'] ?>
    </h1>

<?= $this->pagination_html ?>

    <div id="cats" class="clear_block">
        <? foreach ( $this->data as $row ): ?>
            <div class="left">
                <?= $this->access  ? Output::admin_panel( 'admin control_right_top' ,
                    array( null , Output::ADMIN_EDIT , 'edit/video?data=true&id=' . $row['id'])  ,
                    array( null , Output::ADMIN_GLOBAL_EDIT , 'edit/video?&id=' . $row['id'] ) ,
                    '<hr>' ,
                    array( null , Output::ADMIN_DELETE , 'delete/video?id=' . $row['id'])
                ) : ''?>

                <a href="video/<?= $row['url'] ?>" class="relative block">
                    <img src="<?= $row['image'] ?>" alt="<?= $row['title'] ?>" title="<?= $row['title'] ?>" class="cat" />
                    <h2><?= $row['title'] ?></h2>
                    <div class="video_views"><?= $row['views'] ?></div>
                    <div class="video_time"><?= $row['time'] ?></div>
                </a>
            </div>
        <? endforeach; ?>
    </div>

<?= $this->pagination_html ?>