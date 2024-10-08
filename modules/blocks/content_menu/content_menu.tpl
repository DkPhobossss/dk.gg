<?= $this->css() ?>

<div class="content_menu">
    <table>
        <tr>    
            <? $width = round( 100 / count( $this->menu ) ) ?>
            <? foreach ( $this->menu as $row ) : ?>
                <td width="<?= $width ?>%" <?= ( isset( $row['selected'] ) ? 'class="selected"' : '') ?>>
                    <a href="<?= $row['url'] ?>"><?= $row['name'] ?></a>
                </td>
            <? endforeach; ?>
        </tr>
    </table>
</div>
