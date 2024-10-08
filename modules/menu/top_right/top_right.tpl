    <div class="languages">
        <? if ( Auth::id() ) : ?>
            <span class="hello"><?=__('Hello')?>, <a><?= Auth::user('login')?></a></span>
        <? endif; ?>
        <? $url = implode( '/', Link::$url_parts ) . ( isset(Link::$url_parts[0]) && Link::$url_parts[0] == Config::adminKA ? '?' . Input::server('QUERY_STRING') : '') ; ?>
        <span class="nowrap">
            <? foreach ( Localka::$settings  as $key => $value ) : ?>
                <? if ( empty( $value['disabled'] ) ) : ?>
                    <a <?= $key == Localka::$lang ? '' : ( 'href="' . $value['url'] . '/' . $url . '"' ) ?>><img title="<?= $key ?>" alt="<?= $key ?>" src="<?= Config::$static_url?>images/flags/<?= $key ?>.png" /></a>
                <? endif; ?>
            <? endforeach; ?>
        </span>
    </div>
