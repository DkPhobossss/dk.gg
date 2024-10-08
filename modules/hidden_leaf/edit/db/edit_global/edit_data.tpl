<?if ( !is_null( $this->info[ 'lang_id' ] )  ) : ?>
    <?=Output::admin_title('Edit data : ' . ( isset( $this->uniq_field_value ) ? $this->uniq_field_value :  $this->id ) . ' Global <a href="' . Page::admin( $this->admin_global_url . 'id=' . $this->id ) . '">Here</a>')?>
<?else : ?>
    <?=Output::admin_title('ADD data : ' . ( isset( $this->uniq_field_value ) ? $this->uniq_field_value :  $this->id ) . ' Global <a href="' . Page::admin(  $this->admin_global_url . 'id=' . $this->id ) . '">Here</a>' )?>
<?endif;?>

<? Output::$wysywyg_file_path = $this->wysywyg_path ?>
<?= Output::affected_rows( $this->result )?>

<? $class_name = $this->lang_class ?>
<form method="POST" action="">
    <? foreach ( $this->data as $key => $value ) : ?>
        <?= $class_name::label_element( $key, $value ); ?>
    <? endforeach; ?>

    <?= Output::input_session()?>
    <button>OK</button>
</form>