<? header( 'HTTP/1.0 404 Not Found' );

  //Admin exists?yes/no?!?!dunno... -_-'
  if ( $_SERVER['REQUEST_URI'] == '/admin' )
  {
      Page::go();
  }
?>
<? Output::title( _Error::$title ) ?>

<div id="default_template">
    <div class="row">
        <h1><?= _Error::$title ?></h1>
    </div>
</div>

<div class="row">
    <?= __( 'error_not_found' ) ?>.
</div>