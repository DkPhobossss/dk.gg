<? Output::seo( $this->seo ); ?>
<h1 class="border_bottom"><?= ('Отвечает') ?> <?= $this->cats[ $this->cat_id ]['name']; ?></h1>

<div id="data">
    <? foreach ( $this->data as $row ): ?>
        <div class="news_body <?= ( $row['visible'] ? '' : 'not_visible') ?>"> 
            <?= $this->access  ? Output::admin_panel( 'right' , 
                                array( null , Output::ADMIN_EDIT , 'edit/read/askpro?id=' . $row['id'])  , 
                                '<hr>' , 
                                array( null , Output::ADMIN_DELETE , 'delete/read/askpro?id=' . $row['id'])
                            ) : ''?>

            <div class="header">
                <span class="question_name"><?= $row['name'] ?></span> 
            </div>
            
            <span class="small gray">
                <span class="italic mar_left_5"><?= Output::date_dayname( $row['date_ins']  ) ?></span>
                <span class="right">
                    <? if ( $this->access ) : ?>
                        <a href="mailto:<?= $row['email'] ?>"><?= $row['email'] ?></a> <?=  $row['ip'] ?>
                    <? endif; ?>
                </span>
            </span>
            
            
            
            <div class="question">
                <?= $row['question']?>
            </div>
           
            <div class="header">
                <span class="answer_name">
                    <?= isset( $this->cats[ $row['cat_id'] ] ) && isset( $this->cats[ $row['cat_id'] ]['name'] ) ? $this->cats[ $row['cat_id'] ]['name'] : 'A' ?>
                </span>
            </div>
            
            <div class="answer news_content"><?= $row['answer']?></div>
        </div>
    <? endforeach; ?>
</div>

<?= $this->pagination_html ?>