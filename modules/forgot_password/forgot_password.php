<?php

$this->args( 'email' , 'forgot_password_hash' );

if ( Auth::id() )
{
    _Error::render( _Error::FORBIDDEN );
}

$data = DB\User::select( array('email' , 'forgot_password_hash' , 'forgot_password_time', 'login') ,
    array(
        'email' => $this->email,
        'forgot_password_hash' => $this->forgot_password_hash
    )
)->row();


if ( empty( $data ) || empty( $data['forgot_password_hash'] ) )
{
    _Error::render( _Error::NOT_FOUND );
}

if ( $data['forgot_password_time'] < ( time() - DB\User::Forgot_password_hash_time ) )
{
    _Error::render(  _Error::USER, __('forgot_password_hash_expired') );
}

if ( !empty( $_POST ) )
{
    Session::check('post');
    $errors = array();

    $password = Input::post('password');
    if ( mb_strlen( $password ) < 8 )
    {
        $errors['password'] = __('password_short');
    }

    if ( $password != Input::post('password2') )
    {
        $errors['password2'] = __('password_mismatch');
    }

    if ( !empty( $errors ) )
    {
        _Error::render(  _Error::USER, $errors );
    }

    DB\User::update( array(
            'password' => DB\User::hash( $data['login'], $password), 'forgot_password_hash' => null , 'forgot_password_time' => null, 'login_hash' => \Auth::login_hash( null , $data['login'])
        ) ,
        array('email' => $this->email)
    );


    $this->success = true;
}
