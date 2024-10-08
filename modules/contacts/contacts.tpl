<?= $this->css() ?>
<?= $this->js() ?>
<? Output::js( 'js/jquery.date_picker' ); ?>
<? Output::css( 'css/jquery.date_picker' ); ?>

<?= $this->module( '/static_page' , 'contacts' ) ?>

<h3><?=_ ('Feedback')?></h3> 
<form>
    <input type="text" name="name" id="name" class="w"><label for="name"><?=__('Name')?></label><br/>
    <input type="email" name="email" id="email" class="w"><label for="email">E-mail</label><br/>
    <select name="variant">
        <option value="0"><?= __('Select the question topic') ?></option>
        <option value="1"><?= __('Tournament and Leagues') ?></option>
        <option value="2"><?= __('Interview with players') ?></option>
        <option value="3"><?= __('Press & Media Inquiries') ?></option>
        <option value="4"><?= __('Sponsorship & Partnership') ?></option>
        <option value="5"><?= __('AD on website') ?></option>
        <option value="6"><?= __('Shop & Merchandise') ?></option>
        <option value="7"><?= __('Website feedback & Features') ?></option>
        <option value="8"><?= __('Found a bug?') ?></option>
        <option value="9"><?= __('General Inquiries (Other)') ?></option>
    </select>
    
    <div id="additional_info">
        
    </div>
    
    <textarea name="additional_info"><?=__('Additio')?></textarea>
    <button><?=__('Send')?></button>
</form>

<input maxlength="10" class="date_picker" name="date_end" id="date_end" /><label for="date_end"><?=__('Date end')?></label><br/>

<div style="display:none;">
    <div id="t1">
        <script type="text/javascript">
            $('input.date_picker').jdPicker( options );
        </script>
        <div>
            <?= __('Tournament and Leagues description') ?>
        </div>
        <input type="text" name="event_name" id="event_name" class="w"><label for="event_name"><?=__('Event name')?></label><br/>
        <input type="text" name="site" id="site" class="w"><label for="site"><?=__('Website / Organizer')?></label><br/>
        <select name="event_type" onchange="$(this).next().css('display' , $(this).val() == '1' ? 'block' : 'none' )" />
            <option value="0">Online</option>
            <option value="1">LAN</option>
        </select>
        <div style="display:none;">
            <input type="text" name="city" id="city" class="w"><label for="city"><?=__('Country')?>, <?=__('city')?></label><br/>
        </div>
        <input maxlength="10" class="date_picker" name="date_start" id="date_start" /><label for="date_start"><?=__('Date start')?></label><br/>
        <input maxlength="10" class="date_picker" name="date_end" id="date_end" /><label for="date_end"><?=__('Date end')?></label><br/>
        <textarea name="prize_pool">1 - 
2 - 
3 - 
</textarea> Prize pool
    </div>
    <div id="t2">
        template 2
    </div>
</div>