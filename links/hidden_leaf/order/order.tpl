<? Auth::check_access( ); ?>
<?= $this->module( 'page', $this->module( 'hidden_leaf' , 'shop/order' , intval( Input::get('id') ) ) ) ?>