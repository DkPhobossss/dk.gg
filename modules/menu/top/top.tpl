<? if ( isset( $this->separator ) ) :?>
    <? $row = array_shift( $this->menu ); ?>
    <a href="<?= Config::$root_url . '/' . $row['url'] ?>" <?= (mb_ereg_match( $row['url'] . '(/|$|\?)', $this->url )) ? 'class="selected"' : '' ?>><?= $row['name'] ?></a>
    <? foreach ( $this->menu as $row ) : ?>
        <?= $this->separator ?><a href="<?= Config::$root_url . '/' . $row['url'] ?>" <?= (mb_ereg_match( $row['url'] . '(/|$|\?)', $this->url )) ? 'class="selected"' : '' ?>><?= $row['name'] ?></a>
    <? endforeach; ?>
<? else : ?>
    <nav class="top_menu">
        <? foreach ( $this->menu as $row ) : ?>
            <? if ( isset ( $row['disabled'] ) ) : ?>
                <a title="<?= ( __('Under_construction')  . '. ' . __( 'Waiting for TI 10' ) ) ?>"><?= $row['name'] ?></a>
            <? else : ?>
                <a <?= (mb_ereg_match( $row['url'] . '(/|$|\?)', $this->url )) ? 'class="selected"' : ''?> href="<?= Config::$root_url . '/' . $row['url'] ?>"><?= $row['name'] ?></a>
            <? endif;?>

        <? endforeach; ?>

        <? if ( $this->url !='error' ) :?>
            <? if (!Auth::id() ) : ?>
                <a href="#login_controller" rel="modal:open"><?=__('Login')?></a>
            <? else: ?>
                <a href="logout?<?=Output::href_session()?>"><?=__('logout')?></a>
            <? endif; ?>
        <? endif; ?>
    </nav>
<? endif; ?>