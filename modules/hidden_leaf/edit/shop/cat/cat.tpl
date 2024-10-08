<?=Output::admin_title( 'Edit category : ' . $this->cat['url'] . '. Content : <a href="' . Page::admin( 'edit/shop/cat?id=' . $this->id . '&data=true' ) . '">Here</a>')?>

<?= Output::affected_rows( $this->result )?>

<form method="POST" action="">
    <? foreach ( $this->cat as $key => $value ) : ?>
        <?= DB\Shop\cat::label_element( $key, $value ); ?>
    <? endforeach; ?>
    
    <?= Output::input_session()?>
    <button>OK</button>
</form>