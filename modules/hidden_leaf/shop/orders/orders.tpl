<?=Output::admin_title( 'Заказы' , false )?>
<? $this->css(); ?>

<?= $this->pagination_html; ?>


<? if ( !empty( $this->order_count ) ) : ?>
    <fieldset id="fieldset">
        
        <div class="right">
            Фильтр стран
    
            <form method="POST">
                <select name="lang">
                    <option value="">---</option>
                    <? foreach ( Localka::$langs as $value ) : ?>
                        <option value="<?= $value ?>" <?= ( $value == $this->_lang ? 'selected' : '' ) ?>><?= $value ?></option>
                    <? endforeach; ?>
                </select>
                <button type="submit">OK</button>
            </form>
        </div>
        
        <? $sum = 0;?>
        <? foreach( $this->status as $key => $value ) : ?>
            <div>
                <a href="<?= Page::admin( '?status=' . $key ) ?>" <?= ( $this->_status == $key ? 'class="status_selected"' : '' )?>>
                     <img class="vertical_middle" src="<?= Config::$static_url?>images/shop/<?= $key ?>.png" alt="<?= $this->status[ $key ] ?>" title="<?= $value ?>" />
                </a>
                
                <a href="<?= Page::admin( '?status=' . $key ) ?>" <?= ( $this->_status == $key ? 'class="status_selected"' : '' )?>>
                    <?= $value ?>
                </a><span>
                    <? if ( !isset( $this->order_count[ $key ] ) ) : ?>
                        0
                    <? else : ?>
                        <?= $this->order_count[ $key ] ['count'] ?>
                        <? $sum+= $this->order_count[ $key ] ['count']; ?>
                    <? endif; ?>
                </span>
            </div>
        <? endforeach; ?>
            <div>
                <a href="<?= Page::admin( '' ) ?>" <?= ( !$this->_status ? 'class="status_selected"' : '' ) ?>>
                     <img class="vertical_middle" src="<?= Config::$static_url?>images/shop/all.png" alt="Все" title="Все" />
                </a>
                
                <a href="<?= Page::admin( '' ) ?>" <?= ( !$this->_status ? 'class="status_selected"' : '' ) ?>>
                     Все
                </a><span><?= $sum ?></span>
            </div>
    </fieldset>
<? endif; ?>


<? if ( !empty( $this->income ) ) : ?>
    <fieldset id="income">
        <? foreach(  Localka::$langs as $lang ) : ?>
            <div>
                <img src="<?= Config::$static_url?>images/shop/<?= $lang ?>.png">
                <span>Доход <?= DB\Shop\model::$lang_currency[ $lang ] ?></span><span><?= isset( $this->income[$lang]['sum'] ) ? $this->income[$lang]['sum'] : 0 ?></span>
            </div>
        <? endforeach; ?>
    </fieldset>
<? endif; ?>

<table class="admin_table">
    <tr>
        <td width="35">
            #
        </td>
        
        <td>
            -
        </td>
        
        <td>
            Информация
        </td>
        
        <td>
            Цена
        </td>
        
        <td>
            Статус
        </td>
        
        <td width="100">Дата</td>
    </tr>
    <? foreach( $this->data as $row ) : ?>
        <tr onclick='window.location.href="<?= Config::adminKA ?>/order?id=<?= $row['id'] ?>"' style="cursor:pointer;">
            <th>
                <?= $row['id'] ?>
            </th>
            
            <th>
                <img class="vertical_middle" src="<?= Config::$static_url?>images/<?= $row['lang'] ?>.gif">
            </th>

            <td style="padding-left:8px;">
                <b>Имя</b>: <?= $row['name'] ?></br>
                <b>Город</b>: <?= $row['city'] ?></br>
                <b>Адрес</b>: <?= $row['adress'] ?></br>
                <b>E-mail</b>: <a href="mailto:<?= $row['email'] ?>"><?= $row['email'] ?></a></br>
                <b>Телефон</b>: <?= $row['telephone'] ?></br></br>
                <b>IP</b>: <?= $row['ip'] ?>
            </td>

            <th>
                <?= $row['price'] ?> <?= DB\Shop\model::$lang_currency[ $row['lang'] ] ?>
            </th>
            
            <th>
                <img class="vertical_middle" src="<?= Config::$static_url?>images/shop/<?= $row['status'] ?>.png" alt="<?= $this->status[ $row['status'] ] ?>" title="<?= $this->status[ $row['status'] ] ?>" />
            </th>
            
            <th>
                <?= date('d.m.Y' ,  strtotime( $row['date_ins'] ) ) ?>
                <div style="font-weight:normal;"><?= date('H:i' ,  strtotime( $row['date_ins'] ) ) ?></div>
            </th>
        </tr>
    <? endforeach; ?>
</table>

<?= $this->pagination_html; ?>