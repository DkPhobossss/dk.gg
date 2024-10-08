<?= Output::title( __('seo_title_dota_2_heroes' ) )?>
<?= Output::description( __('seo_description_dota_2_heroes' ) )?>
<?= Output::keywords( __('seo_keywords_dota_2_heroes' ) )?>

<? $this->js(); ?>

<?= Template::content_DESCRIPTION( __('Dota_2_heroes') , __('Dota_2_heroes_text'), $this ); ?>

<div class="row heroes_list relative">
    <?if ( Auth::rule()) : ?>
        <?= Output::admin_panel( 'control_right_top',
            array( null, Output::ADMIN_GLOBAL_EDIT, 'edit/learn/heroes?full_data=true', __('Edit_all_heroes_macrotasks') . ' XL' ),
            array( null, Output::ADMIN_GLOBAL_EDIT, 'edit/learn/heroes', __('Edit_all_heroes_macrotasks') ),
            '<hr>',
            array( null, Output::ADMIN_UPDATE, 'edit/learn/heroes/localization?', __('Update aghanims and skills localization') ),
            '<hr>',
            array( null, Output::ADMIN_UPDATE, 'edit/learn/heroes?update_items=true', __('Update hero items') ),
            array( null, Output::ADMIN_UPDATE, 'edit/learn/heroes?update_skills=true', __('Update hero skills') ),
            '<hr>',
            array( null, Output::ADMIN_SHOW, 'edit/learn/heroes/js?icons=true', __('Show hero icons js') )
        )
        ?>
    <? endif; ?>
    <? foreach ( \DOTA_2\Hero::attributes_array()  as $key => $row ) :?>
        <div class="title_with_image">
            <img alt="<?= $row['text'] ?>" title="<?= $row['text'] ?>"  src="<?= Config::$static_url?>images/dota_2/<?= $key ?>.png"  />
            <h2><a href="learn/glossarij/<?= $row['url'] ?>" target="_blank"><?= $row['text'] ?></a></h2>
        </div>
        <div class="block">
            <? foreach ( $this->data[$key] as $row ) : ?>
                <a class="hero" href="learn/heroes/<?= $row['url'] ?>"><?= DOTA_2\Hero::avatar_animated_html( $row['name'], $row['system_image_name'] ) ?></a>
            <? endforeach;?>
        </div>
    <? endforeach; ?>
</div>