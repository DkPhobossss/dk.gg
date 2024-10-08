<?php

class Captcha
{
    public static $site_key = '6Lc7duQUAAAAALG6O4XLBBY_GrkO8Mc98EjzbOli';
    private static $secret_key = '6Lc7duQUAAAAAFeV9E4fxoP3pkY17ubWVwzlVk6Z';
    private static $verify_url = 'https://www.google.com/recaptcha/api/siteverify';

    private const BOT_VALUE = '0.3';

    public static $policy = 'This site is protected by reCAPTCHA and the Google
    <a href="https://policies.google.com/privacy">Privacy Policy</a> and
    <a href="https://policies.google.com/terms">Terms of Service</a> apply.';


    public static function render( $action = '' )
    {
        Output::add_to_head("<script src=\"https://www.google.com/recaptcha/api.js?onload=ReCaptchaCallbackV3_$action&render=" . self::$site_key . "\"></script><script>
        var ReCaptchaCallbackV3_$action = function() {
            grecaptcha.ready(function () {
                grecaptcha.execute('" . self::$site_key . "', { action: '$action' }).then(function (token) {
                    var recaptchaResponse = document.getElementById('recaptchaResponse_$action');
                    recaptchaResponse.value = token;
                });
            });
        };
        </script>");

        return "<div class='captcha_policy'>" . self::$policy . "</div><input type='hidden' name='recaptcha_response' id='recaptchaResponse_$action' callback='ReCaptchaCallbackV3_$action'>";
    }


    public static function check( $token, $action, $ip)
    {
        $response = CURL::post( self::$verify_url , array(
            'secret' => self::$secret_key,
            'response' => $token,
            'remoteip' => $ip
        )  );

        $decoded_response = empty($response) ? null : json_decode($response);

        if ($decoded_response && $decoded_response->success && $decoded_response->action == $action && $decoded_response->score > self::BOT_VALUE) {
            return true;
        }

        return false;
    }
}