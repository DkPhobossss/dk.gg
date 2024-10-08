<?= Output::title( ('Корзина' ) )?>
<h1 class="zemex"><?= ('Корзина')?></h1>

<? if ( empty( $this->order ) ): ?>
    <?= ('Корзина пуста')?>
<? else : ?>
    <? $this->js(); ?>
    <? $this->css(); ?>

    <form method="GET">
        <?= ('Выберите страну')?> <select name="lang" style="width:150px;" class="mar_bottom_10">
            <? foreach ( DB\Shop\model::$price as $key => $row ) : ?>
                <? if ( $row['site'] == Localka::$lang ) : ?>
                    <? if ( $this->order_lang == $row['lang'] ) : ?>
                        <option value="<?= $row['lang'] ?>" selected><?= $row['country'] ?></option>
                        <? $this->currency = $key; ?>
                    <? else : ?>
                        <option value="<?= $row['lang'] ?>"><?= $row['country'] ?></option>
                    <? endif; ?>
                <? endif; ?>
            <? endforeach; ?>
            <? if ( !isset( $this->currency ) ) :?>
                <? $this->currency = 'RUR'; ?>
            <? endif; ?>
        </select>
    </form>

    <form method="POST" action="basket">
        <table width="100%" class="models">
            <thead>
                <td width="250"> - </td>
                <td><?= ('Арт.')?></td>
                <td><?= ('Модель')?></td>
                <td><?= ('Цена')?></td>
                <td><?= ('Количество')?></td>
                <td><?= ('Всего')?></td>
                <td><?= ('Удалить')?></td>
            </thead>
            <tbody>
                <? $sum = 0; ?>
                <? foreach ( $this->order as $model_id => $row ) : ?>
                    <tr>
                        <td>
                            <a href="<?= $this->product_data[ $row['product_id'] ]['url'] ?>" target="_blank">
                                <img src="<?= $this->product_data[ $row['product_id'] ]['image'] ?>" alt="<?= $row['model'] ?>" title="<?= $row['model'] ?>" />
                            </a>
                        </td>
                        
                        <td><?= $row['article'] ?></td>
                        
                        <td><b><?= $row['model'] ?></b></td>
                        
                        <td><?= $row[ 'price_' . $this->currency ] ?> <?= DB\Shop\model::$price[ $this->currency ]['symbol'] ?></td>
                        
                        <td><input maxlength="3" style="width:45px;" type="number" min="0" max="99" value="<?= $row['count'] ?>" name="model[<?= $row['id'] ?>]" /></td>
                        
                        <td><?= $row[ 'price_' . $this->currency ] * $row['count'] ?> <?= DB\Shop\model::$price[ $this->currency ]['symbol'] ?></td>
                        
                        <td><input type="checkbox" name="remove[<?= $row['id'] ?>]" /></td>
                        
                        <? $sum += $row[ 'price_' . $this->currency ] * $row['count']; ?>
                    </tr>
                <? endforeach; ?>
                    <tr>
                        <td colspan="5">
                            <?= ('Всего')?>
                        </td>
                        
                        <td colspan="2">
                            <?= $sum ?> <?= DB\Shop\model::$price[ $this->currency ]['symbol'] ?>
                        </td>
                    </tr>
            </tbody>
        </table>
        
        <div class="right_text mar_top_20">
            <input type="submit" class="black_button" name="recalculate" value="<?= ('Пересчитать')?>" />
            <a class="black_button right mar_left_5" href="basket/order" /><?= ('Оформить заказ')?></a>
        </div>
    </form>
<? endif; ?>
