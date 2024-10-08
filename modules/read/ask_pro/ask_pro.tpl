<? $this->css(); ?>
<? $this->js(); ?>
<? Output::css('modules/shop/order/order')?>
<h1 class="header_hidden2 left">
    <?= ( 'Спроси PRO!' )?>
</h1>

<div id="cats" class="clear_block">
    <? foreach ( $this->cats as $key => $row ): ?>
        <div class="left relative <?= $this->cat == $key ? 'selected' : '' ?>">
            <?= $this->access  ? Output::admin_panel( 'control_right_top' , 
                                array( null , Output::ADMIN_EDIT , 'edit/read/askpro_cat?data=true&id=' . $key)  , 
                                array( null , Output::ADMIN_GLOBAL_EDIT , 'edit/read/askpro_cat?&id=' . $key ) ,  
                                '<hr>' , 
                                array( null , Output::ADMIN_DELETE , 'delete/read/askpro_cat?id=' . $key)
                            ) : ''?>
            <a href="ask_pro/<?= $key ?>/info"><h2><?= $row['name'] ?></h2></a>
            <a href="ask_pro/<?= $key ?>/info">
                <img src="<?= $row['photo'] ?>" title="<?= $row['name'] ?>" alt="<?= $row['name'] ?>" />
            </a>
            
            <? if ( !$row['disabled'] ) : ?>
                <div class="buttons">
                    <a class="black_button no_shadow" href="ask_pro/<?= $key ?>"><?= ('Ответы') ?></a><a href="ask_pro/<?= $key ?>/ask" class="black_button no_shadow"><?= ('Спросить') ?></a>
                </div>
            <? else : ?>
                <div class="buttons" style="background-color:#fff;">
                    <a style="width:100%;-webkit-border-radius   : 0 0 6px 6px;-moz-border-radius		: 0 0 6px 6px;border-radius			: 0 0 6px 6px;" class="black_button no_shadow" href="ask_pro/<?= $key ?>"><?= ('Ответы') ?></a>
                </div>
            <? endif; ?>
        </div>
    <? endforeach; ?>
</div>

<?= Output::add( '' ,  'edit/read/askpro_cat' , 'right' )?>
<?= $this->module( $this->module , $this->arg1, $this->cat )?>