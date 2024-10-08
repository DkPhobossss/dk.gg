<h1>Heroes macro-tasks list. <a href="learn/heroes">Return to heroes list</a></h1>
<div class="mar_top_20 content">

    <div style="display: flex">
        <ul>
            <? foreach ( $this->macrotasks as $name => $row ):  ?>
                <li>
                    <? if ( $this->macrotask == $name ) : ?>
                        <?= $row['text'] ?>
                    <? else : ?>
                        <a href="<?= Config::adminKA?>/edit/learn/heroes?macrotask=<?= $name ?>"><?= $row['text'] ?></a>
                    <? endif; ?>
                </li>
            <? endforeach;?>
        </ul>
        <div style="margin-left : auto; font-size:20px;line-height:30px;">
            <? for ( $i=2; $i <= 20 ; $i+=3  ) :  ?>
                <div>
                    <?= $i-2 ?> - <?= $i ?> : <?= DB\DOTA_2\Heroes_macrotask::description_from_value( $i, true ); ?>
                </div>
            <? endfor;?>
        </div>
    </div>

    <div class="mar_top_20">
        <form method="post">
            <button>
                <input type="hidden" name="query" value="1">
                <?= \Output::input_session(); ?>
                <button class="button_big" type="submit" onclick="return confirm('are you sure?')" />Создать базовые соответствия</button>
            </button>
        </form>


    </div>

    <? if ( !empty( $this->macrotask ) ) : ?>
        <h2 class="mar_top_20"><?= $this->macrotasks[$this->macrotask]['text'] ?></h2>
        <? if ( isset ( $this->affected_rows ) ) : ?>
            <div class="success">
                Affected rows : <?= $this->affected_rows ?>
            </div>
        <? endif; ?>
    <? endif; ?>

    <? if ( !empty( $this->data ) ) : ?>
        <form method="post"  class="mar_top_20">
            <table class="counter sortable" >
                <thead>
                    <tr>
                        <th width="150">
                            <?=__('Hero') ?>
                        </th>

                        <th width="220">
                            <?=__('Role') ?>
                        </th>

                        <th width="70%">
                            <?= $this->macrotasks[$this->macrotask]['text'] ?>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <? foreach ( $this->data as $row ) : ?>
                        <tr>
                            <td>
                                <a target="_blank" href="learn/heroes/<?= $row['url'] ?>?role=<?= $row['role'] ?>"><?= \DOTA_2\Hero::icon_html( $row['name'] , $row['url'])?></a>
                                <? if ( !is_null( $row['type'] ) ) : ?>
                                    <span class="role_name" type="<?= $row['type']?>"><?= $row['name'] ?></span>
                                <? else: ?>
                                    <span class="role_name"><?= $row['name'] ?></span>
                                <? endif; ?>
                            </td>

                            <td  data-text="<?= $row['role'] ?>">
                                <img src="<?= Config::$static_url ?>images/dota_2/role_<?= $row['role'] ?>.png" alt="<?= $this->roles_description[ $row['role'] ][ 'name' ] ?>" title="<?= $this->roles_description[ $row['role'] ][ 'name' ] ?>">
                                <?= $this->roles_description[ $row['role'] ][ 'name' ] ?>
                            </td>

                            <th data-text="<?= $row[ 'macrotask' ] ?>">
                                <input type="text" name="role[<?= $row['id'] ?>]" value="<?= $row[ 'macrotask' ] ?>"  maxlength="2" style="width:32px;"  />
                            </th>
                        </tr>
                    <? endforeach;?>
                </tbody>
            </table>

            <?= \Output::input_session(); ?>
            <button class="button_big" type="submit" /><?= __('Save')?></button>
        </form>
    <? endif; ?>
</div>