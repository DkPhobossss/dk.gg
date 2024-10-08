<?if ($this->action == 'update' ) : ?>
    <?=Output::admin_title('Edit category : ' . $this->cat['url'])?>
<?else : ?>
    <?=Output::admin_title('ADD category : ' . $this->cat['url'] )?>
<?endif;?>
<? Output::$wysywyg_file_path = 'Images:/shop/'?>
<?= Output::affected_rows( $this->result )?>

<form method="POST" action="">
    <? foreach ( $this->data as $key => $value ) : ?>
        <?= DB\Shop\cat_data::label_element( $key, $value ); ?>
    <? endforeach; ?>
    
    <?= Output::input_session()?>
    <button>OK</button>
</form>