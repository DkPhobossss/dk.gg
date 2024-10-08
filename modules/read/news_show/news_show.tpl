<? Output::seo(  $this->data ); ?>

<?= $this->access  ? Output::admin_panel( 'right' , 
                            array( null , Output::ADMIN_EDIT , 'edit/read/news?data=true&id=' . $this->data['id'])  , 
                            array( null , Output::ADMIN_GLOBAL_EDIT , 'edit/read/news?&id=' . $this->data['id'] ) ,  
                            '<hr>' , 
                            array( null , Output::ADMIN_DELETE , 'delete/read/news?id=' . $this->data['id'])
                        ) : ''?>
<h1>
    <?= $this->data['title'] ?>
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

    <?= $this->module( '/blocks/social_share' , 'mar_top_20' , null ) ?>
</div>

