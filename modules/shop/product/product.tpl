<? Output::js('js/nivo/nivo'); ?>
<? Output::css('js/nivo/nivo'); ?>

<?= $this->css() ?>
<?= $this->js() ?>
<? Output::js('js/elevatezoom/jquery.elevateZoom-3.0.3.min')?>
<? Output::seo( $this->data ) ?>

<div id="product">
    
    <div class="relative" id="slider">
        <? for ( $i = 1 ; $i <= 10; $i++ ) :?>
            <? if ( !empty( $this->data['image_large_' . $i ] ) ) : ?>
                <img src="<?= $this->data['image_large_' . $i ] ?>" alt="<?= $this->data['name'] ?> <?= $i ?>" class="none" />
            <? endif; ?>
        <? endfor; ?>
    </div>
    
    
    <? if ( !empty( $this->data['image_preview_product'] ) ) : ?>
        <? if ( empty( $this->data[ 'image_source' ] ) ) : ?>
            <img src="<?= $this->data[ 'image_preview_product' ] ?>" alt="<?= $this->data['name'] ?>" />
        <? else : ?>
            <img id="zoom" src="<?= $this->data[ 'image_preview_product' ] ?>" alt="<?= $this->data['name'] ?>" data-zoom-image="<?= $this->data[ 'image_source' ] ?>" />
        <? endif; ?>
    <? endif; ?>
    
    <div class="row">
        <? if ( Auth::rule() ) : ?>
            <?= Output::admin_panel( 'right', 
                array( null, Output::ADMIN_ADD, 'edit/shop/product/model?product_id=' . $this->data['id'] , 'Добавить позицию' ), 
                '<hr>',
                array( null, Output::ADMIN_ADD, 'edit/shop/product/link?product_id=' . $this->data['id'] , 'Добавить баннер' ), 
                '<hr>',
                array( null, Output::ADMIN_EDIT, 'edit/shop/product?data=true&id=' . $this->data['id'] ), 
                array( null, Output::ADMIN_GLOBAL_EDIT, 'edit/shop/product?id=' . $this->data['id'] ),
                '<hr>', 
                array( null, Output::ADMIN_DELETE, 'delete/shop/product?id=' . $this->data['id'] )
                );
            ?>
        <? endif; ?>

        <img class="left" src="<?= $this->data['image_text'] ?>" alt="<?= $this->data['name'] ?>" title="<?= $this->data['name'] ?>" />

        <h1 class="header_hidden">
            <?= $this->data['name'] ?>
        </h1>


        <div class="news_content">
            <?= $this->data['content'] ?>
        </div>
        
        <? if ( !empty( $this->links ) ) : ?>
            <h3 class="mar_top_20"><?= ('Материалы по теме') ?>:</h3>
            <div id="links" class="clear_block">
                <? foreach( $this->links as $row ) : ?>
                    <div class="relative">
                        <a href="<?= $row['url'] ?>" target="_blank">
                            <img class="link" src="<?= $row['image'] ?>" alt="<?= $this->data['name'] ?>" title="<?= $this->data['name'] ?>" />
                        </a>
                        
                        <? if ( Auth::rule() ) : ?>
                            <?= Output::admin_panel( 'control_right_top', 
                                array( null, Output::ADMIN_GLOBAL_EDIT, 'edit/shop/product/link?id=' . $row['id'] ),
                                '<hr>', 
                                array( null, Output::ADMIN_DELETE, 'delete/shop/product/link?id=' . $row['id'] )
                                );
                            ?>
                        <? endif; ?>
                    </div>
                <? endforeach; ?>
            </div>
        <? endif; ?>
        
        <div class="mar_top_20 relative">
            <? if ( !empty( $this->models ) ) : ?>
                <table width="100%" class="models">
                    <thead>
                        <td><?= ('Арт.')?></td>
                        <td><?= ('Модель')?></td>
                        <td><?= ('Длн.(cм)')?></td>
                        <td><?= ('Тест(г)')?></td>
                        <td><?= ('Секции')?></td>
                        <td><?= ('Вес(г)')?></td>
                        <td><?= ('Тр.длн.(см)')?></td>
                        
                        <td width="172"><?= ('Цена / Купить')?></td>
                        
                        <? if ( Auth::rule() ) : ?>
                            <td>-</td>
                        <? endif; ?>
                    </thead>
                    <tbody>
                        <? foreach ( $this->models as $model ) : ?>
                            <tr>
                                <td><?= $model['article'] ?></td>
                                <td>
                                    <b><?= $model['model'] ?></b>
                                    <? if ( !empty( $model['action'] ) ) : ?>
                                        </br>
                                        <?= $model['action'] ?> 
                                    <? endif; ?>
                                </td>
                                <td><?= $model['length'] ?></td>
                                <td><?= $model['test'] ?></td>
                                <td><?= $model['section'] ?></td>

                                <td><?= $model['weight'] ?></td>
                                <td><?= $model['transport_length'] ?></td>
                    
                                <td>
                                    <? foreach ( DB\Shop\model::$price as $key => $row ) : ?>
                                        <? if ( $row['site'] == Localka::$lang ) : ?>
                                            <div class="model_row">
                                                <?= Output::price( $model[ 'price_' . $key ] . ' ' . $row['symbol'] )?>
                                                <? if ( empty( $model['out_of_stock'] ) ) : ?>
                                                    <a class="buy" onclick="addToCart(<?= $model['id'] ?> , '<?= $row['lang'] ?>' , '<?= $model['model']?> <?= ('Добавлен в корзину') ?>');">
                                                        <img class="vertical_middle" src="<?= Config::$static_url?>images/<?= $row['lang'] ?>.gif"> <?= ('Купить')?>
                                                    </a>
                                                <? else : ?>
                                                    <a class="main_disabled vertical_top" onclick="return false;" title="<?= ('Нет в наличии')?>">
                                                        <img class="vertical_middle" src="<?= Config::$static_url?>images/<?= $row['lang'] ?>.gif"> <?= ('Нет в наличии')?>
                                                    </a>
                                                <? endif; ?>
                                            </div>
                                        <? endif; ?>
                                    <? endforeach; ?>
                                </td>
                                <? if ( Auth::rule() ) : ?>
                                    <td><?= Output::admin_panel( '', 
                                        array( null, Output::ADMIN_GLOBAL_EDIT, 'edit/shop/product/model?id=' . $model['id'] ),
                                        '<hr>', 
                                        array( null, Output::ADMIN_DELETE, 'delete/shop/product/model?id=' . $model['id'] )
                                        );
                                        ?>
                                    </td>
                                <? endif; ?>
                            </tr>
                        <? endforeach; ?>
                    </tbody>
                </table>
            <? endif; ?>
        </div>

        <div>
            <? if ( Auth::rule() ) : ?>
                <div class="right news_info">
                    <img src="<?=Config::$static_url?>images/system/views_16.png" alt="Views" title="Views" /><?= $this->data['views'] ?>
                </div>
            <? endif; ?>

            <?= $this->module( '/blocks/social_share' , 'mar_top_20' , null ) ?>
        </div>
    </div>
</div>

<?= $this->module( '/blocks/shop_footer' ) ?>