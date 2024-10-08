<? if ( empty( $this->access ) ) : ?>
    <? Output::css('css/global'); ?>
    <? Output::css('css/login'); ?>
    <table width="100%" height="100%">
        <tr>
            <td>
                <form action="" method="POST">
                    <center>      
                        <a href="hidden_leaf">
                            <img title="logo" alt="logo" src="/images/zemex_logo_black.png" />
                        </a>
                    </center>

                    <input type="text" name="login" placeholder="Login">
                    <input type="password" name="password" placeholder="Password">

                    <div class="right_text">
                        <button type="submit" class="black_button">Login</button>
                    </div>
                    <input type="hidden" name="mode" value="auth">
                </form>
            </td>
        </tr>
    </table>
<? else : ?>
    <? Output::css( 'css/hidden_leaf' ) ?>
    <? Output::js('js/jquery') ?>
    <div class="main">
        <div class="header">
            <a href="hidden_leaf">
                <img title="logo" alt="logo" src="/images/zemex_logo_white_shadow.png" />
            </a>

            <div class="right">
                <? foreach ( $this->modules as $key => $row ) : ?>
                    <a href="<?= $row['href'] ?>" class="<?= $row['icon'] ?> <?=(mb_strpos( $_SERVER['REQUEST_URI'], $key ) !== false ? 'selected' : '')?>">
                        <?= $row['text'] ?>
                    </a>
                <? endforeach; ?>
            </div>
            <div class="clear"></div>
        </div>

        <div class="content">
            <div class="right">
                <?= Auth::user('login') ?> <a href="<?= Config::adminKA?>?logout&<?= Output::href_session()?>">Logout</a>
            </div>
            
            <? if ( !empty( $this->submodule ) ) : ?>
                <? if ( !is_array( $this->submodule ) ) :?>
                    <? $this->submodule_args = array( '/' . Config::adminKA .'/' . $this->submodule ); ?>
                    <? if ( count( $this->args ) > 1 ) : ?>
                        <? $this->submodule_args = array_merge( $this->submodule_args , array_splice( $this->args , 1 ) ); ?>
                    <? endif; ?>
                    <?= call_user_func_array( array( $this, 'module' ) ,  $this->submodule_args ) ?>
                <? else : ?>
                    <? reset( $this->submodule ); ?>
                    <? while ( ( $module = current( $this->submodule ) ) ) : ?>
                        <? $next = next( $this->submodule ); ?>
                        <? if ( is_array( $next ) ) :?>
                            <?= call_user_func_array( array( $this, 'module' ) ,  array_merge( array( '/' . Config::adminKA .'/' .  $module ) , $next ) ); ?>
                            <? next( $this->submodule ); ?>
                        <? else : ?>
                            <?= call_user_func_array( array( $this, 'module' ) ,  array( '/' . Config::adminKA .'/' . $module ) ); ?>
                        <? endif; ?>
                    <? endwhile; ?>
                <? endif; ?>
            <? endif; ?>
        </div>
    </div>
<? endif; ?>