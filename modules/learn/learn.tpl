<?= Output::title( __('Learn' ) )?>
<?= Output::description( __('Learn:description' ) )?>
<?= Output::keywords( __('Learn:keywords' ) )?>

<?= Template::content_DEEP( __('Learn' ), __('Learn:text' ), $this ) ?>

<div class="row">
    <div class="group">
        <?foreach ( array(
            array('text' => 'Draft', 'url' => 'learn/draft' , 'items' => 6 ),
            array('text' => 'Heroes', 'url' => 'learn/heroes' , 'items' => 5 ),
            array('text' => 'Education', 'url' => 'learn/education' , 'items' => 5 ),
            array('text' => 'Glossary', 'url' => 'learn/glossarij' , 'items' => 5 ),
        ) as $row  ) : ?>
            <div class="element">
                <h3><?= __( $row[ 'text' ] ) ?></h3>
                <ul class="list">
                    <? for ( $i = 1; $i <= $row['items']; $i++ ) : ?>
                        <li><?= __( $row[ 'text' ] . '_' . $i ) ?>.</li>
                    <? endfor; ?>
                </ul>

                <div class="more">
                    <a class="button_big" href="<?= $row['url'] ?>"><?=__('Know more')?></a>
                </div>
            </div>
        <? endforeach; ?>
    </div>
</div>