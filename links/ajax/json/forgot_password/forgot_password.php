<?php
$errors = array();

if ( !Protector::check( Protector::ACTION_FORGOT_PASSWORD ) )
{
    $errors[] = __('protector_spam');
    $this->response()->errors( $errors )->output();
}

if ( Auth::id() )
{
    $errors[] = __('error_already_logon');
    $this->response()->errors( $errors )->output();
}

$email = Input::post('email');
if ( !filter_var( $email, FILTER_VALIDATE_EMAIL ) )
{
    $errors['email'][] = __('email_not_correct');
}
else
{
    if ( !( $user_id = DB\User::select( array('id'), array('email' => $email) )->value() ) )
    {
        $errors['email'][] = __('email_not_exist');
    }
}

if ( !empty( $errors ) )
{
    $this->response()->errors( $errors )->output();
}


$forgot_password_hash = DB\User::activated_hash();
//forgot_password_time
DB\User::update( array(
    'forgot_password_hash' => $forgot_password_hash,
    'forgot_password_time' => time()
) , array('id' => $user_id) );


$link = Config::$root_url . Protector::ACTION_FORGOT_PASSWORD . "?email=$email&forgot_password_hash=$forgot_password_hash" ;
if (!Email::sendmail(
    $email , //$email
    __('forgot_password_theme'),
    ( __('Click_on_link' ) . " <a target='_blank' href='$link'>" . __('here') . "</a> " . __('to_recover_your_password')  ))
)
{
    $errors[] = __('mail_error');
    $this->response()->errors( $errors )->output();
}

$this->response()->tooltip( __('forgot_password_send_success') )->output();
