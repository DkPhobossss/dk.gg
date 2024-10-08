<?= Output::edit( 'DB\Rules::$STATIC[Localka::$lang]' , 'edit/static_page?page=' . $this->name , 'right' ) ?>
<? if ( !isset( $this->no_seo ) ) : ?>
    <?= Output::seo( $this->page )?>

    <h1 class="<?= $this->name ?>"><?= ( $this->page['title'] ) ?></h1>
<? else : ?>
    <div class="first_level"><?= ( $this->page['title'] ) ?></div>
<? endif;?>
<div class="news_content"><?= $this->page['content'] ?></div>