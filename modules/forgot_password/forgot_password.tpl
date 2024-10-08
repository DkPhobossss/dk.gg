<h1>
    <?=__('forgot_password_theme')?>
</h1>

<? if (!empty( $this->success )) :?>
    <div class="success">
        <?=__('Forgot_password_success')?>
    </div>
<?else: ?>
    <form action="" method="POST">
        <span class="input_placeholder"><input type="password" name="password" placeholder="<?=__('Пароль')?>" maxlength="64"></span>
        <span class="input_placeholder"><input type="password" name="password2" placeholder="<?=__('Повторите Пароль')?>"  maxlength="64"></span>

        <?= Output::input_session()?>

        <div class="right_text">
            <span class="input_placeholder"><button type="submit" class="black_button"><?=__('Send')?></button></span>
        </div>
    </form>
<? endif; ?>


