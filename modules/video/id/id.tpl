<? Output::seo(  $this->data ); ?>
<? $this->css(); ?>

<?= $this->access  ? Output::admin_panel( 'right' ,
    array( null , Output::ADMIN_EDIT , 'edit/video?data=true&id=' . $this->data['id'])  ,
    array( null , Output::ADMIN_GLOBAL_EDIT , 'edit/video?&id=' . $this->data['id'] ) ,
    '<hr>' ,
    array( null , Output::ADMIN_DELETE , 'delete/video?id=' . $this->data['id'])
) : ''?>
<h1>
    <a href="video"><?= ('Video') ?></a> - <?= $this->data['title'] ?>
</h1>

<div class="news_content clear_block">
    <?= $this->data['content'] ?>
</div>


<div>
    <div class="right news_info">
        <img src="<?=Config::$static_url?>images/system/clock_16.png" alt="Date" title="Date" /><?= Output::date_format( $this->data['date_ins'] ) ?>
        <? if ( $this->access ) : ?>
            <img src="<?=Config::$static_url?>images/system/views_16.png" alt="Views" title="Views" /><?= $this->data['views'] ?>
        <? endif; ?>
    </div>

    <?= $this->module( '/blocks/social_share' , 'mar_top_20' , $this->data['image'] ) ?>
</div>

<? if ( !empty( $this->extra ) ) : ?>
    <? Output::css( 'modules/shop/shop' ); ?>
    <? Output::css( 'modules/video/video' ); ?>

    <h3 class="mar_top_20"><?= ('More videos') ?></h3>
    <div id="cats" class="clear_block">
        <? foreach ( $this->extra as $row ): ?>
            <div class="left">
                <a href="video/<?= $row['url'] ?>" class="relative block">
                    <img src="<?= $row['image'] ?>" alt="<?= $row['title'] ?>" title="<?= $row['title'] ?>" class="cat" />
                    <h2><?= $row['title'] ?></h2>
                    <div class="video_views"><?= $row['views'] ?></div>
                    <div class="video_time"><?= $row['time'] ?></div>
                </a>
            </div>
        <? endforeach; ?>
    </div>
<? endif; ?>


