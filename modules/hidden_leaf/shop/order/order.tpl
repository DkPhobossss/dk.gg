<?=Output::admin_title( 'Заказ #' . $this->id , false )?>

<? $this->css(); ?>

<? if ( !empty( $this->order_count ) ) : ?>
    <fieldset>
        <legend><a href="<?= Page::admin( '' ) ?>" <?= ( !$this->_status ? 'class="status_selected"' : '' ) ?>>Количество заказов</a></legend>
        <? foreach( $this->order_count as $this->data ) : ?>
            <div>
                <a href="<?= Page::admin( '?status=' . $this->data['status'] ) ?>" <?= ( $this->_status == $this->data['status'] ? 'class="status_selected"' : '' )?>><?= $this->status[ $this->data['status'] ] ?></a>: <?= $this->data['count'] ?>
            </div>
        <? endforeach; ?>
    </fieldset>
<? endif; ?>


<fieldset id="info">
    <legend>Информация о заказе</legend>
    <div class="right" style="text-align:right;">
        <img src="<?= Config::$static_url?>images/shop/<?= $this->data['status'] ?>.png" alt="<?= $this->status[ $this->data['status'] ] ?>" title="<?= $this->status[ $this->data['status'] ] ?>" />

        <form action="" method="POST">
            <select name="status">
                <? foreach ( $this->status as $key => $value ) : ?>
                    <option value="<?= $key ?>" <?= $this->data['status'] == $key ? 'selected' : ''?>><?= $value ?></option>
                <? endforeach; ?>
            </select>
            <input type="hidden" name="id" value="<?= $this->data['id'] ?>" />
            <button type="submit">OK</button>
        </form>
    </div>
    
    <div><b>Имя</b><?= $this->data['name'] ?></div>
    <div><b>Страна</b><img class="vertical_top" src="<?= Config::$static_url?>images/<?= $this->data['lang'] ?>.gif"></div>
    <div><b>Город</b><?= $this->data['city'] ?></div>
    <div><b>Адрес</b><?= $this->data['adress'] ?></div>
    <div><b>E-mail</b><a href="mailto:<?= $this->data['email'] ?>"><?= $this->data['email'] ?></a></div>
    <div><b>Телефон</b><?= $this->data['telephone'] ?></div>
    <div><b class="left">Комментарий</b><div class="left"><?= $this->data['info'] ?></div></div>
    <div class="clear"></div>
    
    <div><b>Время</b><?= date('d.m.Y H:i' ,  strtotime( $this->data['date_ins'] ) ) ?></div>
    
    <div><b>IP</b><?= $this->data['ip'] ?></div>
    
    <hr class="mar_hor_20" />
    
    <div><b>К оплате</b><?= $this->data['price'] ?> <?= DB\Shop\model::$lang_currency[ $this->data['lang'] ] ?></div> 
</fieldset>

<fieldset id="info">
    <legend>Заказ</legend>
    
    <table width="100%" class="models" class="mar_top_20">
        <thead>
            <td width="250"> - </td>
            <td><?= ('Арт.')?></td>
            <td><?= ('Модель')?></td>
            <td><?= ('Цена')?></td>
            <td><?= ('Количество')?></td>
            <td><?= ('Всего')?></td>
        </thead>
        <tbody>
            <? $sum = 0; ?>
            <? $symbol = DB\Shop\model::$lang_currency[ $this->data['lang'] ] ?>
            <? foreach ( $this->order as $row ) : ?>
                <? list( $row['article'] , $row['model'] ) = explode( ' => ', $row['product_name'] )?>
                <tr>
                    <td>
                        <a href="<?= $row['url'] ?>" target="_blank">
                            <img width="250" height="80" src="<?= $row['image'] ?>" alt="<?= $row['model'] ?>" title="<?= $row['model'] ?>" />
                        </a>
                    </td>

                    <td><?= $row['article'] ?></td>

                    <td><b><?= $row['model'] ?></b></td>

                    <td><?= $row[ 'product_price'] ?> <?= $symbol ?></td>

                    <td><?= $row['product_count'] ?></td>

                    <td><?= $row[ 'product_price' ] * $row['product_count'] ?> <?= $symbol ?></td>

                    <? $sum += $row[ 'product_price' ] * $row['product_count']; ?>
                </tr>
            <? endforeach; ?>
                <tr>
                    <td colspan="4">
                        <?= ('Всего')?>
                    </td>

                    <td colspan="2">
                        <?= $sum ?> <?= $symbol ?>
                    </td>
                </tr>
        </tbody>
    </table>
</fieldset>