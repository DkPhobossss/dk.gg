<?= Output::title( __('seo_title_glossarij' ). ' ' . __('words_on') . ' ' .  $this->letter )?>
<?= Output::description( __('seo_description_glossarij' ) . ' ' . __('words_on') . ' ' . $this->letter )?>
<?= Output::keywords( __('seo_keywords_glossarij' ) )?>

<?= Template::content_DEFAULT( __('Glossary') . ', ' . __('Letter') . ' «' . $this->letter . '»' , $this ); ?>

<div class="glossary row relative">
    <?if ( $this->access ) : ?>
        <?= Output::admin_panel( 'control_right_top',
            array( null, Output::ADMIN_ADD, 'edit/learn/glossary' )
        )
        ?>
    <? endif; ?>
    <div class="alphabet">
        <? foreach ( $this->alphabet as $row ) : ?>
            <? if ( $this->letter == $row['letter'] ) : ?>
                <span><?= $row['letter'] ?></span>
            <? else : ?>
                <a href="learn/glossarij/<?= $row['letter'] ?>"><?= $row['letter'] ?></a>
            <? endif; ?>
        <? endforeach;?>
    </div>

    <h2><?=$this->letter ?></h2>


    <div class="data">
        <? foreach ( $this->data as $row ) : ?>
            <div class="word relative">
                <?if ( $this->access ) : ?>
                    <?= Output::admin_panel( 'control_right_top',
                        array( null , Output::ADMIN_EDIT , 'edit/learn/glossary?data=true&id=' . $row['id'])  ,
                        array( null , Output::ADMIN_GLOBAL_EDIT , 'edit/learn/glossary?&id=' . $row['id'] ) ,
                        '<hr>' ,
                        array( null , Output::ADMIN_DELETE , 'delete/learn/glossary?id=' . $row['id'])
                    )
                    ?>
                <? endif; ?>
                <h4><a href="learn/glossarij/<?= $row['url'] ?>"><?= $row['name'] ?></a></h4>
            </div>
        <? endforeach;?>
    </div>
</div>
