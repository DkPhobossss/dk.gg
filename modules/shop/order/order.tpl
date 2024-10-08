<?= Output::title( ('Заказать') )?>
<h1 class="zemex"><?= ('Заказать')?></h1>

<? $this->css(); ?>


<? if ( !empty( $this->result ) ) : ?>
    <div class="success">
        <?= ('Благодарим за заказ.')?></br>
        <?= ('В ближайшее время с вами свяжутся.')?></br></br>
        
        <a href="/"><?= ('На главную.')?></a>
    </div>
<? else : ?>
    <form method="POST" action="" accept-charset="utf-8">
        <table>
            <? foreach ( $this->fields as $key => $value ) : ?>
                <tr>
                    <td width="150">
                        <?= isset( DB\Shop\Order::$fields[$key]['comment'] ) ? DB\Shop\Order::$fields[$key]['comment'] : $key ?>
                        <?= ( !isset( DB\Shop\Order::$fields[$key]['default'] ) && empty( DB\Shop\Order::$fields[$key]['null'] )  ? '<span title="Required" class="red">*</span>' : '' )?>
                    </td>
                    <td><?= DB\Shop\Order::label_element( $key,  isset( $_POST['field'][$key] ) ? $_POST['field'][$key] : ''  , '' , false ); ?></td>
                </tr>
            <? endforeach; ?>
                <tr>
                    <td colspan="2"><input type="submit" class="black_button"  /></td>
                </tr>
        </table>

        <?= Output::input_session()?>
    </form>
<? endif; ?>