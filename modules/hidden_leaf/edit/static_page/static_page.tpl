<?=Output::admin_title( 'Edit '  . $this->name . ' page' )?>
<?= Output::affected_rows( $this->result )?>

<form method="POST" action="">
    <? foreach ( $this->page as $key => $value ) : ?>
        <?= DB\Pages_static::label_element( $key, $value ); ?>
    <? endforeach; ?>
    
    <?= Output::input_session()?>
    <button>OK</button>
</form>