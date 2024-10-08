<?if ( $this->id ): ?>
    <?=Output::admin_title( 'Edit : ' . ( empty( $this->data[ $this->uniq_field ] ) ? $this->id : $this->data[ $this->uniq_field ] ) . ( empty( $this->admin_lang_url ) ? '' : ' Content <a href="' . Page::admin( $this->admin_lang_url . 'id=' . $this->id ) . '">Here</a>' ) )?>
<?else : ?>
    <?=Output::admin_title( 'Add' , false )?>
<?endif;?>

<? Output::$wysywyg_file_path = $this->wysywyg_path ?>
<?= Output::affected_rows( $this->result )?>

<? $class_name = $this->base_class ?>
<form method="POST" action="">
    <? foreach ( $this->data as $key => $value ) : ?>
        <? if ( $this->id ) :  ?>
            <?= $class_name::label_element( $key, $value ); ?>
        <? else : ?>
            <?= $class_name::label_element( $key, ( !empty( $value ) || ( empty( $class_name::$fields[ $key ]['default'] ) ) ? $value : $class_name::$fields[ $key ]['default']  )  ); ?>
        <? endif; ?>
    <? endforeach; ?>
    
    <?= Output::input_session()?>
    <button class="button">OK</button>
</form>