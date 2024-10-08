<?php
$errors = array();

if ( !Captcha::check(Input::post('recaptcha_response') , Protector::ACTION_REGISTER, Auth::ip()) )
{
    $errors[] = __('captcha_check_failed');
    $this->response()->errors( $errors )->output();
}

if ( !Protector::check( Protector::ACTION_REGISTER ) )
{
    $errors[] = __('protector_spam');
    $this->response()->errors( $errors )->output();
}

if ( Auth::id() )
{
    $errors[] = __('error_already_logon');
    $this->response()->errors( $errors )->output();
}


$password = Input::post('password');
if ( mb_strlen( $password ) < 8 )
{
    $errors['password'][] = __('password_short');
}

if ( $password != Input::post('password2') )
{
    $errors['password2'][] = __('password_mismatch');
}

$email = Input::post('email');
if ( !filter_var( $email, FILTER_VALIDATE_EMAIL ) )
{
    $errors['email'][] = __('email_not_correct');
}
else
{
    if ( DB\User::exists( array('email' => $email) ) )
    {
        $errors['email'][] = __('email_exist');
    }
}

$login = Input::post('login');
if ( !preg_match("/^[a-z\d]{1}[a-z-_\d]{2,}$/i", $login) )
{
    $errors['login'][] = __('login_not_correct');
}
else
{
    if ( DB\User::exists( array('login' => $login) ) )
    {
        $errors['login'][] = __('login_exist');
    }
}

$name = htmlspecialchars( trim( Input::post('name') ) );

if ( mb_strlen($name) < 3 || mb_strlen($name) > 64 )
{
    $errors['name'][] = __('name_not_correct');
}

if ( !empty( $errors ) )
{
    $this->response()->errors( $errors )->output();
}


$activated_hash = DB\User::activated_hash();
if ( !( $user_id  = DB\User::register( $login, $password , $email, Auth::ip(), $name, $activated_hash) ) )
{
    $errors[] = __('user_register_error');
    $this->response()->errors( $errors )->output();
}


$link = Config::$root_url . Protector::ACTION_ACTIVATE . "?user_id=$user_id&activated_hash=$activated_hash" ;
if (!Email::sendmail(
    $email , //$email
    __('register_on_site'),
    ( __('registered_on_site' ) . '. </br>' . __('your_login_is') . ": $login" . ".</br>" . __('your_password_is') . ": $password</br> "
        . __('activated_link') . " <a target='_blank' href='$link'>" . __('here') . "</a>"  ))
)
{
    $errors[] = __('mail_error');
    $this->response()->errors( $errors )->output();
}



$this->response()->tooltip( __('register_success') )->output();
