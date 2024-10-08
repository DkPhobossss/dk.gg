<?php
$this->args( 'cats' , 'cat_id' );

if ( !empty( $this->cats[ $this->cat_id]['disabled'] ) )
{
    _Error::render( _Error::NOT_FOUND );
}

$this->seo = array( 'seo_title' =>  $this->cats[ $this->cat_id ]['name'] . ' , ' . ('Ваш вопрос') ,
    'seo_description' => strip_tags( $this->cats[ $this->cat_id ]['info'] ) , 
    'seo_keywords' => null );


DB\Read\Askpro::init_check();
foreach ( $this->cats as $key => $row )
{
    DB\Read\Askpro::$fields['cat_id']['length'][$row['name']] = (string)$key;
}

if ( !empty( $_POST['field'] ) )
{
    if ( intval( Input::post('check') ) != ( Session::get('captcha_1') + Session::get('captcha_2') )   )
    {
        throw new Exception\User('<b>Captcha</b>: ' . ('Неправильно заполнено' ) );
    }
    
    $_POST['field']['ip'] = Auth::ip();
    $_POST['field']['lang'] = Localka::$lang;
    
    try
    {
        DB::transaction();
        $this->result = DB\Read\Askpro::insert_row( $_POST['field']  );
        DB::commit();
    }
    catch ( \Exception\User $e )
    {
        DB::rollback();
        throw new \Exception\User( $e->getErrors() );
    }
    catch ( \Exception $e )
    {
        DB::rollback();
        throw new \Exception\Fatal( $e->getMessage() );
    }
}

$this->fields = array_fill_keys( array_keys ( 
        array_filter ( DB\Read\Askpro::$fields , function ( $value ) {
            return !isset( $value['disable_update'] );
        } )
    )   , '' );
    
 Session::set( 'captcha_1' , rand(1,25) );
 Session::set( 'captcha_2' , rand(1,25) );