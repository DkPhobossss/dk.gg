<? Output::title( _Error::$title ) ?>


<div id="default_template">
    <div class="row">
        <h1><?= _Error::$title ?></h1>
    </div>
</div>

<div class="row">
    <?= _Error::get_errors_html() ?>
</div>
