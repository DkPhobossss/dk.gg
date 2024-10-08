<h1>Heroes macro-tasks list. <a href="learn/heroes">Return to heroes list</a></h1>
</div>


<style>
    .hexagon
    {
        display: none;
    }
</style>
<div class="mar_top_20 content">


    <div style="display: flex">
        <div style="margin-left : auto; font-size:20px;line-height:30px;">
            <? for ( $i=2; $i <= 20 ; $i+=3  ) :  ?>
                <div>
                    <?= $i-2 ?> - <?= $i ?> : <?= DB\DOTA_2\Heroes_macrotask::description_from_value( $i, true ); ?>
                </div>
            <? endfor;?>
        </div>
    </div>

    <div style="width:100%;position: fixed;margin: 0 auto;top:0;z-index:1000;">
        <table style="margin-top : 0;">
            <thead>
            <tr>
                <th style="font-size:12px;">#</th>
                <th width="150">
                    <?=__('Hero') ?>
                </th>

                <th width="170">
                    <?=__('Role') ?>
                </th>

                <? foreach ( $this->macrotasks as $row ) : ?>
                    <th width="60">
                        <?= $row['text'] ?>
                    </th>
                <? endforeach;?>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#main_table input').change(function() {
                var $input = $(this);
                var $form = $(this).closest('form');
                $.ajax({
                    data: $form.serialize(),
                    type: $form.attr('method'),
                    url: $form.attr('action')
                }).done( function (response) {
                    console.log( response );
                    $input.css('border' , '2px solid #0aa');
                }).fail(function( jqXHR, textStatus ) {
                    $input.css('border' , '2px solid #f00');
                });;
            });
        });
    </script>

    <table class="counter" id="main_table">
        <thead>
        <tr>
            <th width="150">
                <?=__('Hero') ?>
            </th>

            <th width="170">
                <?=__('Role') ?>
            </th>

            <? foreach ( $this->macrotasks as $row ) : ?>
                <th width="60">
                    <?= $row['text'] ?>
                </th>
            <? endforeach;?>
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

                <td>
                    <img src="<?= Config::$static_url ?>images/dota_2/role_<?= $row['role'] ?>.png" alt="<?= $this->roles_description[ $row['role'] ][ 'name' ] ?>" title="<?= $this->roles_description[ $row['role'] ][ 'name' ] ?>">
                    <?= $this->roles_description[ $row['role'] ][ 'name' ] ?>
                </td>

                <? foreach ( $this->macrotasks as $macrotask => $macrotask_data ) : ?>
                    <th>
                        <form method="post" action="ajax/json/learn/heroes/macrotask?<?= Output::href_session() ?>">
                            <input type="text" name="role[<?= $row['id'] ?>][<?= $macrotask ?>]" value="<?= $row[ $macrotask ] ?>"  maxlength="2" style="width:32px;"  />
                        </form>
                    </th>
                <? endforeach;?>
            </tr>
        <? endforeach;?>
        </tbody>
    </table>
</div>

<div>