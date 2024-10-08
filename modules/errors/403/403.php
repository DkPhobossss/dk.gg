<? header( 'HTTP/1.0 403 Forbidden' ) ?>
<? Output::title( _Error::$title ) ?>

<div id="default_template">
    <div class="row">
        <h1><?= _Error::$title ?></h1>
    </div>
</div>

<div class="row">
    <?= __( "error_forbidden") ?>.
</div>