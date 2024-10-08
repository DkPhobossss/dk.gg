<? foreach ( $this->data as $row ) : ?>
    <tr>
        <td>
            <a target="_blank" href="learn/heroes/<?= $row['url'] ?>?role=<?= $row['role'] ?>"><?= \DOTA_2\Hero::icon_html( $row['name'] , $row['url'])?>
                <? if ( !is_null( $row['type'] ) ) : ?>
                    <span class="role_name" type="<?= $row['type']?>"><?= $row['name'] ?></span>
                <? else: ?>
                    <span class="role_name"><?= $row['name'] ?></span>
                <? endif; ?>
            </a>
        </td>

        <th data-text="<?= $row['role'] ?>">
            <img src="<?= Config::$static_url ?>images/dota_2/role_<?= $row['role'] ?>.png" alt="<?= $this->roles_description[ $row['role'] ][ 'name' ] ?>" title="<?= $this->roles_description[ $row['role'] ][ 'name' ] ?>">
        </th>

        <? foreach ( $this->macrotasks as $macrotask => $macrotask_data ) : ?>
            <th data-text="<?= $row[ $macrotask ] ?>>">
                <?= DB\DOTA_2\Heroes_macrotask::description_from_value( $row[ $macrotask ] , true ) ?>
            </th>
        <? endforeach;?>
    </tr>
<? endforeach;?>

