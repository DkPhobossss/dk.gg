<? Output::seo( $this->data );?>

<?= Template::content_DEFAULT( $this->data['name'], $this )?>

<div class="row">


    <div class="glossary relative">
        <?if ( $this->access ) : ?>
            <? if ( $this->data['system'] ) : ?>
                <?= Output::admin_panel( 'control_right_top',
                    array( null , Output::ADMIN_EDIT , 'edit/learn/glossary?data=true&id=' . $this->data['id'])  ,
                    array( null , Output::ADMIN_GLOBAL_EDIT , 'edit/learn/glossary?&id=' . $this->data['id'] )
                )
                ?>
            <? else : ?>
                <?= Output::admin_panel( 'control_right_top',
                    array( null , Output::ADMIN_EDIT , 'edit/learn/glossary?data=true&id=' . $this->data['id'])  ,
                    array( null , Output::ADMIN_GLOBAL_EDIT , 'edit/learn/glossary?&id=' . $this->data['id'] ) ,
                    '<hr>' ,
                    array( null , Output::ADMIN_DELETE , 'delete/learn/glossary?id=' . $this->data['id'])
                )
                ?>
            <? endif; ?>
        <? endif; ?>

        <div class="content">
            <? if ( isset( $this->data['module'] ) ) : ?>
                <?= Template::render_modules( $this->data['content'] , $this->data['module'] , $this  );?>
            <? else : ?>
                <?=$this->data['content']?>
            <? endif; ?>

            <div class="views">
                <?=__('Views'); ?>: <?= $this->data['views'] ?>
            </div>
        </div>
    </div>
</div>
