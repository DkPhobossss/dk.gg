<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?=Localka::$lang?>">
    <head>
        <?= Output::head() ?>
        <script type="text/javascript">
            var lang = '<?= Localka::$lang?>',
                token = '<?= Output::href_session () ?>',
                user_id = <?= Auth::id(); ?>,
                static_url = '<?= Config::$static_url ?>';
        </script>
    </head>
    <body>
        <?= $this->body ?>
        <? if ( Auth::rule() && !empty( Output::$debug['DB'] ) && !empty( Config::DEBUG ) ) : ?>
            <div class="debug">
                <? foreach ( Output::$debug['DB'] as $val ) : ?>
                    <div><?= $val ?></div>
                <? endforeach;?>
            </div>
        <?endif;?>
    </body>
</html>