<?=Output::admin_title(  __( 'Edit translation' ) )?>


<? if ( isset( $this->result ) ) : ?>
    <div class="success">
        Все прошло успешно, affected_rows : <?= $this->result ?>
    </div>
<? endif; ?>

<h1 style="margin-top:30px;">Перевод</h1>
<form method="POST" action="">
    <table class="table" style="table-layout: fixed;word-break:break-all;">
        <tr>
            <td width="30"> # </td>
            <td>Фраза</td>
            <td width="600">Перевод</td>
        </tr>
        <? $i = 0; ?>
        <? foreach ( $this->words as $row ) : ?>
            <tr>
                <td width="30"> <?= ++$i ?> </td>
                <td> <?= $row['id'] ?> </td>
                <td><textarea style="width:100%;max-width:600px;min-height:50px;" name="words[<?= htmlspecialchars( $row['id']  ) ?>]"><?= $row['value']  ?></textarea></td>
            </tr>
        <? endforeach; ?>
    </table>

    <button><?=__('Save')?></button>
    <input type="hidden" name="mode" value="save" />
    <?=Output::input_session()?>
</form>
