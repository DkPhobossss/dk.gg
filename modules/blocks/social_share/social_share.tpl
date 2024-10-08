<? $this->args('html_class', 'tooltip_data', 'text' , 'url', 'image') ?>


<a tooltip_data='{<?= $this->tooltip_data?>}' data-tooltip-content="#share"  class="tooltip <?= $this->html_class ?>"><?= __('Share') ?></a>

<div class="none">
    <div id="share">
        <a class="fi fi-twitter" href="http://twitter.com/share?text=<?= $this->text ?>&related=dkphobos&hashtags=dkphobos,dkphobosgg&url=<?= $this->url ?>" title="<?=__('Share_link_on_twitter')?>"
           onclick="window.open(this.href, this.title, 'toolbar=0, status=0, width=548, height=325'); return false" target="_parent"></a>

        <a class="fi fi-facebook" href="http://www.facebook.com/sharer.php?u=<?= urlencode($this->url ); ?>"
           onclick="window.open(this.href, this.title, 'toolbar=0, status=0, width=548, height=325'); return false" title="<?=__('Share_on_facebook')?>" target="_parent"></a>

        <a class="fi fi-vk" href="http://vkontakte.ru/share.php?url=<?= urlencode( $this->url ); ?>&title=<?= Output::title(false , true) ?>&description=<?= $this->text ?>&image=<?= $this->image ?>&noparse=true"
           onclick="window.open(this.href, this.title, 'toolbar=0, status=0, width=548, height=325'); return false" title="<?=__('Share_in_VK')?>" target="_parent"></a>
    </div>
</div>