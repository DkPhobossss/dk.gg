<? Output::title( _Error::$title ) ?>

<div id="default_template">
    <div class="row">
        <h1><?= _Error::$title ?></h1>
    </div>
</div>

<div class="row">
    <?= __( "error_fatal") ?>.
    <? if (  Auth::rule( )  ): ?>
        <br>
        <b><?=_Error::get_errors_html()?></b>
    <?endif;?>
</div>
