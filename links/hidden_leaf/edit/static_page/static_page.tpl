<? Auth::check_access( 'DB\Rules::$STATIC[Localka::$lang]' ); ?>
<?= $this->module( 'page', $this->module( 'main', Config::adminKA . '/edit/static_page' , Input::get('page') ) ) ?>