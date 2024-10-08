<?if ( !empty( $this->id ) ): ?>
    <?=Output::admin_title( 'Edit product : ' . $this->data['url'] . '. Content : <a href="' . Page::admin( 'edit/shop/product?id=' . $this->id . '&data=true' ) . '">Here</a>')?>
<?else : ?>
    <?=Output::admin_title( 'Add product ' , false )?>
<?endif;?>

<?= Output::affected_rows( $this->result )?>

<form method="POST" action="">
    <? foreach ( $this->data as $key => $value ) : ?>
        <?= DB\Shop\product::label_element( $key, $value ); ?>
    <? endforeach; ?>
    
    <?= Output::input_session()?>
    <button>OK</button>
</form>