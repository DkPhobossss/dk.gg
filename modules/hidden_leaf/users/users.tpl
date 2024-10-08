<h2 class="right"><?= __( 'Total' ) ?> : <?= $this->total ?></h2>
<a href="<?= Page::admin( 'users' ) ?>"><?= Output::admin_title( __( 'User list' ), false ) ?></a>

<a name="list"></a>
<div class="right">
    <form>
        User : 
        <input type="text">
        <button><?= __( 'Search' ) ?></button>
    </form>
</div>
<?= $this->pagination ?>

<table>
    <?= Output::table_header( $this->fields, Page::admin( 'users?' . ( $this->group_id ? 'group=' . $this->group_id . '&' : '' ) ), 45 ) ?>

    <? $i = $this->show * ( $this->current_page - 1) + 1; ?>
    <? foreach ( $this->users as $row ) : ?>
        <tr>
            <td>
                <?= $i; ?>
            </td>

            <td>
                <?= $row['id_member'] ?>
            </td>

            <td>
                <a target="_blank" href="profile/<?= rawurlencode( $row['member_name'] ) ?>"><?= $row['member_name'] ?></a>
            </td>

            <td>
                <? if ( !Auth::rule( DB\Rules::CHANGE_GROUP ) || $row['group_id'] == DB\Group::PHOBOS ) : ?>
                    <a href="<?= Page::admin( 'users?group=' . $row['group_id'] ) ?>"><?= $row['group'] ?></a>
                <? else : ?>
                    <x-ajax-form url="ajax/json/set_group?<?= Output::href_session() ?>">
                        <x-dropdown class="selector" name="group_id" autosubmit="true" value="<?= $row['group_id'] ?>">
                            <x-dropdown-value></x-dropdown-value>
                            <x-dropdown-list>
                                <? foreach ( $this->groups as $row2 ) : ?>
                                    <x-option value="<?= $row2['id'] ?>"><?= $row2['name'] ?></x-option>
                                <? endforeach; ?>
                            </x-dropdown-list>
                        </x-dropdown>
                        <input type="hidden" name="user_id" value="<?= $row['id_member'] ?>" />
                    </x-ajax-form>
                <? endif; ?>
            </td>

            <td>
                <?= $row['gold'] ?>
            </td>

            <td>
                <?= $row['registered_source'] == 1 ? __( 'Site' ) : __( 'Forum' ) ?>
            </td>

            <td>
                <?= $row['soc_network'] ?>
            </td>

            <td>
                <?= date( 'd.m.Y - H:i', $row['date_registered'] ) ?>
            </td>
        </tr>
        <? $i++; ?>
    <? endforeach; ?>
</table>

<?= $this->pagination ?>