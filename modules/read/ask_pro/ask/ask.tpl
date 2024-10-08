<? Output::seo( $this->seo ); ?>
<div id="question">
    <? if ( isset( $this->result ) ) : ?>
        <div class="success"><?= ('Ваш вопрос успешно добавлен.') ?></div>
    <? else : ?>
        <h1 class="border_bottom"><?= ('Ваш вопрос') ?></h1>
        <form action="" method="POST">
            <table>
                <? foreach ( $this->fields as $key => $value ) : ?>
                    <tr>
                        <td width="150">
                            <?= isset( DB\Read\Askpro::$fields[$key]['comment'] ) ? DB\Read\Askpro::$fields[$key]['comment'] : $key ?>
                            <?= ( !isset( DB\Read\Askpro::$fields[$key]['default'] ) && empty( DB\Read\Askpro::$fields[$key]['null'] )  ? '<span title="Required" class="red">*</span>' : '' )?>
                        </td>
                        <td>
                            <? if ( $key == 'cat_id' ) : ?>
                                <?= DB\Read\Askpro::label_element( $key,  isset( $_POST['field'][$key] ) ? $_POST['field'][$key] : $this->cat_id  , '' , false ); ?>
                            <? else  :?>
                                <?= DB\Read\Askpro::label_element( $key,  isset( $_POST['field'][$key] ) ? $_POST['field'][$key] : ''  , '' , false ); ?>
                            <? endif; ?>
                        </td>
                    </tr>
                <? endforeach; ?>
                    <tr>
                        <td>captcha<span title="Required" class="red">*</span> <?= Session::get('captcha_1') ?> + <?= Session::get('captcha_2') ?> = ?</td>
                        <td><input type="text" name="check" /></td>
                    </tr>

                    <tr>
                        <td colspan="2"><input type="submit" class="black_button"  /></td>
                    </tr>
            </table>

            <?= Output::input_session()?>
        </form>
    <? endif; ?>
</div>
