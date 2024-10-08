<? if (!Auth::id() ) : ?>
    <div id="login_controller" class="modal">
        <div class="menu">
            <a class="button_main selected" rel="login"><?=__('Войти')?></a>
            <a class="button_main" rel="register"><?=__('Регистрация')?></a>
            <a class="button_main" rel="forgot_password"><?=__('Забыли пароль')?></a>
        </div>

        <div id="login" class="login_controller">
            <div class="title"><?=__('Login')?></div>
            <form action="ajax/json/login" method="POST" class="ajax_form">

                <span class="input_placeholder" for="login"><span></span><input type="text" name="login" maxlength="16" placeholder="<?=__('Логин')?>"></span>
                <span class="input_placeholder" for="password"><span></span><input type="password" name="password" maxlength="64" placeholder="<?=__('Пароль')?>"></span>

                <?=Captcha::render( Protector::ACTION_LOGIN )?>

                <div class="right_text">
                    <input type="submit" name="dologin" class="button" value="<?=__('Login')?>" />
                </div>
            </form>
        </div>


        <div id="register" class="login_controller none ">
            <div class="title"><?=__('Registration')?></div>
            <form action="ajax/json/register" method="POST" class="ajax_form">

                <span class="input_placeholder" for="login"><span></span><input type="text" name="login" placeholder="<?=__('Логин')?>"  maxlength="16"></span>
                <span class="input_placeholder" for="password"><span></span><input type="password" name="password" placeholder="<?=__('Пароль')?>" maxlength="64"></span>
                <span class="input_placeholder" for="password"><span></span><input type="password" name="password2" placeholder="<?=__('Повторите Пароль')?>"  maxlength="64"></span>
                <span class="input_placeholder" for="email"><span></span><input type="email" name="email" placeholder="<?=__('Email')?>"  maxlength="64"></span>
                <span class="input_placeholder" for="name"><span></span><input type="text" name="name" placeholder="<?=__('Имя')?>"  maxlength="64"></span>

                <?=Captcha::render( Protector::ACTION_REGISTER )?>

                <div class="right_text">
                    <button type="submit" class="button"><?=__('Register')?></button>
                </div>
            </form>
        </div>

        <div id="forgot_password" class="none login_controller">
            <div class="title"><?=__('Forgot_password')?></div>
            <form action="ajax/json/forgot_password" method="POST" class="ajax_form">

                <span class="input_placeholder" for="email"><span></span><input type="email" name="email" placeholder="Email" maxlength="64"></span>

                <div class="right_text">
                    <button type="submit" class="button"><?=__('Send')?></button>
                </div>
            </form>
        </div>
    </div>
<? endif; ?>