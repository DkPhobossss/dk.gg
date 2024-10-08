<?php
$errors = array();

if ( !Captcha::check(Input::post('recaptcha_response') , Protector::ACTION_LOGIN, Auth::ip()) )
{
    $errors[] = __('captcha_check_failed');
    $this->response()->errors( $errors )->output();
}

if ( !Protector::check( Protector::ACTION_LOGIN ) )
{
    $errors[] = __('protector_spam');
    $this->response()->errors( $errors )->output();
}

if ( Auth::id() )
{
    $errors[] = __('error_already_logon');
    $this->response()->errors( $errors )->output();
}


$result = Auth::login( Input::post('login'), Input::post('password') );
if ( $result === false )
{
    $errors['login'][] = __('login_and_password_invalid');
    $this->response()->errors( $errors )->output();
}

if ( is_null( $result ) )
{
    $errors['login'][] = ( __('error_User_activation_0') . ' ' . __('or') . ' ' . __('error_already_logon') );
    $this->response()->errors( $errors )->output();
}

$this->response()->reload()->output();