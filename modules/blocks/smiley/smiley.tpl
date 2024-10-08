<script type="text/javascript">
    var smiley_selector = '<?= $this->selector ?>';
</script>
<?= $this->css() ?>
<?= $this->js() ?>
<div class="smiley_container">
    <? foreach ( \DB\Forum\Smiley::data() as $code => $row ) : ?>
        <img <?= ( $row['hidden'] ? 'style="display:none;"' : '' )?>code="<?= $code ?>" src="<?= \DB\Forum\Smiley::PATH . $row['filename'] ?>" alt="<?= $row['description'] ?>" title="<? $row['description'] ?>" />
    <? endforeach; ?>
        <div class="center_text">
            <a class="show_more button">
                <?= __('More smileys') ?>
            </a>
        </div>
</div>