<?= $this->css() ?>
<?= $this->js() ?>
<? if ( $this->total > 1 && $this->current <= $this->total ) : ?>
    <div class="pagination <?=$this->class?>" <?= empty( $this->reverse ) ? '' : 'reverse="reverse"' ?>>
        <? if ( empty( $this->reverse ) ): ?>
            <a <?= ( $this->current == 1 ? 'class="selected"' : '' ) ?> href="<?= substr( $this->href , 0 , -6 ) ?><?= $this->param_string ?><?= $this->anchor ?>">1</a>
            <? //(>1< ... 6 7 [8] 9 10 ... 15) ?>

            <? if ( $this->current - $this->show > 2 ) : ?>
                <sub <?= (!empty( $this->anchor ) ? ( 'anchor="' . $this->anchor . '"' ) : '' )?> href="<?= $this->href ?><?= $this->param_string ?>" start="<?= ( $this->current - $this->show - 1 ) ?>"><?= $this->separator ?></sub>
            <? endif; //(1 >...< 6 7 [8] 9 10 ... 15)?>


            <? for ( $i = ( $this->current - $this->show ); $i < $this->current; $i++ ) : ?>
                <? if ( $i <= 1 ) continue; ?>
                <a href="<?= $this->href ?><?= $i ?><?= $this->param_string ?><?= $this->anchor ?>"><?= $i ?></a>
            <? endfor; //(1 ... >6 7< [8] 9 10 ... 15)?>


            <? if ( $this->current != 1 && $this->current != $this->total ) : ?>
                <a class="selected" href="<?= $this->href ?><?= $this->current ?><?= $this->param_string ?><?= $this->anchor ?>"><?= $this->current ?></a>
            <? endif; //(1 ... 6 7 >[8]< 9 10 ... 15)?>


            <? for ( $i = ( $this->current + 1 ); $i <= $this->current + $this->show; $i++ ) : ?>
                <? if ( $i >= $this->total ) break; ?>
                <a href="<?= $this->href ?><?= $i ?><?= $this->param_string ?><?= $this->anchor ?>"><?= $i ?></a>
            <? endfor; //(1 ... 6 7 [8] >9 10< ... 15)?>


            <? if ( $this->current + $this->show + 1  < $this->total ) : ?>
                <sub <?= (!empty( $this->anchor ) ? ( 'anchor="' . $this->anchor . '"' ) : '' )?> href="<?= $this->href ?><?= $this->param_string ?>" start="<?= ( $this->current + $this->show + 1 ) ?>" limit="<?= $this->total ?>"><?= $this->separator ?></sub>
            <? endif; //(1 ... 6 7 [8] 9 10 >...< 15)?>


            <a <?= ( $this->current == $this->total ? 'class="selected"' : '' ) ?> href="<?= $this->href ?><?= $this->total ?><?= $this->param_string ?><?= $this->anchor ?>"><?= $this->total ?></a>
            <?  //(1 ... 6 7 [8] 9 10 ... >15<)?>
        <? else : ?>
            <? if ( $this->current == $this->total ) : ?>
                <span><?= $this->current ?></span>
            <? else : ?>
                <a href="<?= substr( $this->href , 0 , -6 ) ?><?= $this->param_string ?><?= $this->anchor ?>"><?= $this->total ?></a>
            <? endif; //(>15< ... 10 9 [8] 7 6 ... 1)?>


            <? if ( $this->current + $this->show < $this->total ) : ?>
                <sub <?= (!empty( $this->anchor ) ? ( 'anchor="' . $this->anchor . '"' ) : '' )?> href="<?= $this->href ?><?= $this->param_string ?>" start="<?= ( $this->current + $this->show + 1 ) ?>" limit="<?= $this->total ?>"><?= $this->separator ?></sub>
            <? endif; //(15 >...< 10 9 [8] 7 6 ... 1)?>


            <? for ( $i = ( $this->current + $this->show ); $i > $this->current; $i-- ) : ?>
                <? if ( $i >= $this->total ) continue; ?>
                <a href="<?= $this->href ?><?= $i ?><?= $this->param_string ?><?= $this->anchor ?>"><?= $i ?></a>
            <? endfor; //(15 ... >10 9< [8] 7 6 ... 1)?>


            <? if ( $this->current != 1 && $this->current != $this->total ) : ?>
                <span><?= $this->current ?></span>
            <? endif; //(15 ... 10 9 >[8]< 7 6 ... 1)?>


            <? for ( $i = ( $this->current - 1 ); $i >= $this->current - $this->show; $i-- ) : ?>
                <? if ( $i <= 1 ) break; ?>
                <a href="<?= $this->href ?><?= $i ?><?= $this->param_string ?><?= $this->anchor ?>"><?= $i ?></a>
            <? endfor; //(15 ... 10 9 [8] >7 6< ... 1)?>


            <? if ( $this->current - $this->show > 2 ) : ?>
                <sub <?= (!empty( $this->anchor ) ? ( 'anchor="' . $this->anchor . '"' ) : '' )?> href="<?= $this->href ?><?= $this->param_string ?>" start="<?= ( $this->current - $this->show - 1 ) ?>"><?= $this->separator ?></sub>
            <? endif; //(15 ... 10 9 [8] 7 6 >...< 1)?>


            <? if ( $this->current == 1 ) : ?>
                <span>1</span>
            <? else : ?>
                <a href="<?= $this->href ?>1<?= $this->param_string ?><?= $this->anchor ?>">1</a>
            <? endif; //(15 ... 10 9 [8] 7 6 ... >1<)?>
        <? endif; ?>
    </div>
<? endif; ?>