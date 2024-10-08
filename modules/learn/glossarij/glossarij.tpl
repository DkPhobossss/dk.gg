<?= Output::title( __('seo_title_glossarij' ) )?>
<?= Output::description( __('seo_description_glossarij' ) )?>
<?= Output::keywords( __('seo_keywords_glossarij' ) )?>

<?= Template::content_DESCRIPTION( __('Glossary') , __('Glossary_text'), $this ); ?>

<div class="glossary row relative" >
    <?if ( $this->access ) : ?>
        <?= Output::admin_panel( 'control_right_top',
            array( null, Output::ADMIN_ADD, 'edit/learn/glossary' )
        )
        ?>
    <? endif; ?>
    <div class="alphabet">
        <? foreach ( $this->data as $key => $row ) : ?>
            <a href="learn/glossarij/<?= $key ?>"><?= $key ?></a>
        <? endforeach;?>
    </div>

    <h2><?=__('Popular_terms')?></h2>


    <div class="data">
        <? foreach ( $this->data as $key => $row ) : ?>
            <div class="item">
                <div class="h3"><a href="learn/glossarij/<?= $key ?>"><?= $key ?></a></div>
                <div class="list">
                    <? foreach ( $this->data[$key] as $data ) : ?>
                        <h4>
                            <a href="learn/glossarij/<?= $data['url'] ?>"><?= $data['name'] ?></a>
                        </h4>
                    <? endforeach;?>
                </div>
            </div>
        <? endforeach;?>
    </div>
</div>
