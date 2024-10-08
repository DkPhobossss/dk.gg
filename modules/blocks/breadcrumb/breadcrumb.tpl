<div class="breadcrumb row <?= $this->class ?>">
    <? $link_size = sizeof( Link::$url_parts ) - 1 ?>
    <? $url = Link::$url_parts[0]; ?>
    <? $text = $this->branch['text'] ?>
    <? for ( $i = 1; $i <= $link_size; $i++  ) : ?>
        <a href="<?= $url ?>">
            <?= $text ?>
        </a>
        <? if ( isset( $this->branch['items'][ Link::$url_parts[$i] ] ) ):  ?>
            <? $text = $this->branch['items'][ Link::$url_parts[$i] ]['text']; ?>
            <? $this->branch = $this->branch['items'][ Link::$url_parts[$i] ] ?>
        <? else : ?>
            <? $this->branch = null ?>
            <? $text = Link::$url_parts[$i]; ?>
        <? endif; ?>

        <? $url .= '/' . Link::$url_parts[$i]  ?>
    <? endfor; ?>
    <h1><?= $this->title ?></h1>
</div>
